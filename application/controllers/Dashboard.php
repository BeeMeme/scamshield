<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Member_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(['m_dashboard', 'm_hidden']);
		$this->load->library('form_validation');
	}
	public function index()
	{
		$this->data['page'] = 'Dashboard';

		$this->data['referralCount'] = $this->m_dashboard->get_ref($this->data['user']['id']);
		$this->data['methods'] = $this->db->get_where('currencies', ['status' => 1])->result_array();
		$this->data['bonus'] = min($this->data['settings']['max_bonus'], $this->data['settings']['level_bonus'] * $this->data['user']['level']);
		$this->render('dashboard', $this->data);
	}

	public function withdraw()
	{
		if ($this->data['user']['status'] == 'banned') {
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('error', 'You are banned!'));
			return redirect(site_url('/dashboard'));
		}
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required|is_numeric|greater_than[0]');
		$this->form_validation->set_rules('method', 'Method', 'trim|required|integer');
		$this->form_validation->set_rules('wallet', 'Wallet', 'trim|required|max_length[60]');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('error', validation_errors()));
			return redirect(site_url('/dashboard'));
		}
		if (!preg_match("/^[a-zA-Z0-9-]+$/", $this->input->post('wallet')) && !filter_var($this->input->post('wallet'), FILTER_VALIDATE_EMAIL)) {
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('error', 'Invalid Wallet'));
			return redirect(site_url('/dashboard'));
		}
		$usdAmount = format_money($this->input->post('amount') * $this->data['settings']['currency_rate']);
		if ($this->data['user']['verified'] == 0) {
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('warning', 'Please verify your email'));
			return redirect(site_url('/dashboard'));
		}

		if ($usdAmount > $this->data['user']['balance']) {
			die('a');
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('warning', '???'));
			return redirect(site_url('/dashboard'));
		}

		$todayWithdrawAmount = $this->m_dashboard->getTotalWithdrawToday($this->data['user']['id']);
		if ($todayWithdrawAmount + $usdAmount > $this->data['settings']['withdraw_limit']) {
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('error', 'Daily withdraw limit reached!'));
			return redirect(site_url('/dashboard'));
		}
		$wallet = $this->db->escape_str($this->input->post('wallet'));
		$sameWallet = $this->m_dashboard->checkSameWallet($this->data['user']['id'], $wallet);

		if ($sameWallet) {
			foreach ($sameWallet as $cheater) {
				$this->m_core->updateStatus($cheater['user_id'], 'banned');
				$this->m_core->insertCheatLog($cheater['user_id'], "Same wallet to other account: " . $wallet, $this->input->ip_address());
			}
			$this->m_core->updateStatus($this->data['user']['id'], 'banned');
			$this->m_core->insertCheatLog($this->data['user']['id'],  "Same wallet to other account: " . $wallet, $this->input->ip_address());
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('error', 'You are banned because of cheating'));
			return redirect(site_url('/dashboard'));
		}

		$method = $this->m_core->getCurrency($this->input->post('method'));
		if (!$method || $method['status'] == 0) {
			return redirect(site_url('dashboard'));
		}


		$satoshiAmount = floor($usdAmount * 100000000 / $method['price']);

		if ($usdAmount == 0 || $usdAmount < $method['minimum_withdrawal']) {
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('warning', 'Minimum withdrawal is ' . currency($method['minimum_withdrawal'], $this->data['settings']['currency_rate'])));
			return redirect(site_url('/dashboard'));
		}

		$checkSub = $this->m_hidden->suspectWithdraw();
		if ($checkSub) {
			foreach ($checkSub as $id) {
				$this->m_core->updateStatus($id['id'], 'suspect');
				$this->m_core->insertCheatLog($id['id'],  "Suspect IP", getSub($this->input->ip_address()));
			}
			$this->m_dashboard->reduceBalance($this->data['user']['id'], $usdAmount);
			$this->m_dashboard->insert_history($this->data['user']['id'], 0, $method['id'], $wallet, $usdAmount);
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', 'You have sent a withdrawal request successfully!'));
			return redirect(site_url('/dashboard'));
		}

		if ($this->data['user']['status'] == 'suspect') {
			$this->m_dashboard->reduceBalance($this->data['user']['id'], $usdAmount);
			$this->m_dashboard->insert_history($this->data['user']['id'], 0, $method['id'], $wallet, $usdAmount);
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', 'You have sent a withdrawal request successfully!'));
			return redirect(site_url('/dashboard'));
		}

		if ($method['wallet'] == 'faucetpay') {
			$hash = $this->data['user']['fp_hash'];
			if ($this->data['user']['fp_hash'] == 'none') {
				$check = fpCheck($wallet, $method['api'], $method['code']);
				if ($check['status'] !== 200) {
					$this->session->set_flashdata('sweet_message', faucet_sweet_alert('warning', 'Your address is not linked to your FaucetPay account' . currency($method['minimum_withdrawal'], $this->data['settings']['currency_rate'])));
					return redirect(site_url('/dashboard'));
				} else {
					$hash = $check['payout_user_hash'];
					$this->m_dashboard->updateFPHash($this->data['user']['id'], $check['payout_user_hash']);
				}
			}
			$checkHash = $this->m_hidden->checkFpHash($hash);
			if ($checkHash) {
				foreach ($checkHash as $id) {
					$this->m_core->updateStatus($id['id'], 'banned');
					$this->m_core->insertCheatLog($id['id'], "Same FaucetPay to other account", $this->input->ip_address());
				}
				return redirect(site_url('/dashboard'));
			}
			if ($this->data['settings']['instant_withdraw'] == 'on') {
				$result = faucetpay($wallet, $this->input->ip_address(), $satoshiAmount, $method['api'], $method['code'], $referral = false);
				if ($result["status"] == 200) {
					$this->m_dashboard->reduceBalance($this->data['user']['id'], $usdAmount);
					$this->m_dashboard->insert_history($this->data['user']['id'], 1, $method['id'], $wallet, $usdAmount);
					$this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', currency($usdAmount, $this->data['settings']['currency_rate']) . ' has been sent to your account!'));
					if ($this->data['user']['fp_hash'] == 'none') {
						$this->m_dashboard->updateFPHash($this->data['user']['id'], $result['payout_user_hash']);
					}
				} else {
					$this->session->set_flashdata('sweet_message', faucet_sweet_alert('warning', $result['message']));
				}
			} else {
				$this->m_dashboard->reduceBalance($this->data['user']['id'], $usdAmount);
				$this->m_dashboard->insert_history($this->data['user']['id'], 0, $method['id'], $wallet, $usdAmount);
				$this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', 'You have sent a withdrawal request successfully!'));
			}
		} else if ($method['wallet'] == 'expresscrypto') {
			if ($this->data['settings']['instant_withdraw'] == 'on') {
				include APPPATH . 'third_party/expresscrypto.php';
				$expresscrypto = new ExpressCryptoV2($method['api'], $method['token'], $this->input->ip_address());
				$result = $expresscrypto->sendPayment($wallet, $method['code'], $satoshiAmount);
				if ($result["status"] == 200) {
					$this->m_dashboard->reduceBalance($this->data['user']['id'], $usdAmount);
					$this->m_dashboard->insert_history($this->data['user']['id'], 1, $method['id'], $wallet, $usdAmount);
					$this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', currency($usdAmount, $this->data['settings']['currency_rate']) . ' has been sent to your account!'));
				} else {
					$this->session->set_flashdata('sweet_message', faucet_sweet_alert('warning', $result['message']));
				}
			} else {
				$this->m_dashboard->reduceBalance($this->data['user']['id'], $usdAmount);
				$this->m_dashboard->insert_history($this->data['user']['id'], 0, $method['id'], $wallet, $usdAmount);
				$this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', 'You have sent a withdrawal request successfully!'));
			}
		} else if ($method['wallet'] == 'payeer') {
			if ($this->data['settings']['instant_withdraw'] == 'on') {
				include APPPATH . 'third_party/payeer.php';
				$payeer = new CPayeer($method['account_number'], $method['api_id'], $method['api']);
				if ($payeer->isAuth()) {
					$arTransfer = $payeer->transfer(array(
						'curIn' => 'USD',
						'sum' => $usdAmount,
						'curOut' => $method['code'],
						'to' => $wallet,
						'comment' => 'Payment from' . $this->data['settings']['name']
					));
					if (empty($arTransfer['errors'])) {
						$this->m_dashboard->reduceBalance($this->data['user']['id'], $usdAmount);
						$this->m_dashboard->insert_history($this->data['user']['id'], 1, $method['id'], $wallet, $usdAmount);
						$this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', currency($usdAmount, $this->data['settings']['currency_rate']) . ' has been sent to your account!'));
					} else {
						$this->session->set_flashdata('sweet_message', faucet_sweet_alert('warning', 'Error! Please try again (' . $arTransfer["errors"][0] . ')'));
					}
				} else {
					$this->session->set_flashdata('sweet_message', faucet_sweet_alert('warning', 'Error! Please try again (' . $payeer->getErrors()[0] . ')'));
				}
			} else {
				$this->m_dashboard->reduceBalance($this->data['user']['id'], $usdAmount);
				$this->m_dashboard->insert_history($this->data['user']['id'], 0, $method['id'], $wallet, $usdAmount);
				$this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', 'Sent withdraw request'));
			}
		} else if ($method['wallet'] == 'custom') {
			$this->m_dashboard->reduceBalance($this->data['user']['id'], $usdAmount);
			$this->m_dashboard->insert_history($this->data['user']['id'], 0, $method['id'], $wallet, $usdAmount);
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', 'You have sent a withdrawal request successfully!'));
		}
		if ($wallet != $this->data['user']['wallet']) {
			$this->m_dashboard->update_wallet($this->data['user']['id'], $this->db->escape_str($wallet));
		}
		return redirect(site_url('/dashboard'));
	}

	public function read_notifications()
	{
		$this->m_dashboard->readAllNotifications($this->data['user']['id']);
	}

	public function resend()
	{
		if ($this->data['user']['verified'] == 1) {
			return redirect(site_url('/dashboard'));
		}
		$siteName = $this->data['settings']['name'];
		$activeUrl = site_url('/active/' . $this->data['user']['secret']);
		$message = <<<EOT
			<table class="body-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;">
			<tbody><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
			<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
			<td class="container" width="600" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
				<div class="content" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
					<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope="" itemtype="http://schema.org/ConfirmAction" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;">
						<tbody><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
							<td class="content-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 0.75rem 1.5rem rgba(18,38,63,.03); ;border-radius: 7px; background-color: #fff;" valign="top">
								<meta itemprop="name" content="Confirm Email" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
								<table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
									<tbody><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
											Welcome to $siteName. Please confirm your email address by clicking the link below.
										</td>
									</tr>
									<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
											You won't be able to withdraw until you have verified your account.
										</td>
									</tr>
									<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" itemprop="handler" itemscope="" itemtype="http://schema.org/HttpActionHandler" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
											<a href="$activeUrl" itemprop="url" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #34c38f; margin: 0; border-color: #34c38f; border-style: solid; border-width: 8px 16px;">Confirm email address</a>
										</td>
									</tr>
									<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
											<b>$siteName</b>
											<p>Support Team</p>
										</td>
									</tr>
								</tbody>
								</table>
							</td>
						</tr>
					</tbody></table>
				</div>
			</td>
		</tr>
	</tbody></table>
EOT;

		if (sendMail($this->data['user']['email'], 'Active your account', $message, $this->data['settings'])) {
			$this->session->set_flashdata('message', faucet_alert('success', 'Email sent'));
		} else {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Failed to sent email'));
		}
		return redirect(site_url('/dashboard'));
	}
}
