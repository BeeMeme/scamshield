<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faucet extends Member_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->data['settings']['faucet_status'] != 'on') {
			return redirect(site_url('dashboard'));
		}
		$this->load->helper('string');
		$this->load->model('m_faucet');
	}
	public function index()
	{
		$this->data['page'] = 'Faucet';

		$this->data['wait'] = max(0, $this->data['settings']['timer'] - time() + $this->data['user']['last_claim']);
		$this->data['limit'] = false;
		$this->data['useEnergy'] = false;
		if ($this->data['user']['today_faucet'] >= $this->data['settings']['daily_limit']) {
			if ($this->data['user']['energy'] >= $this->data['settings']['faucet_cost']) {
				$this->data['useEnergy'] = true;
			} else {
				$this->data['limit'] = true;
			}
		}
		if ($this->data['settings']['antibotlinks'] == 'on') {
			include APPPATH . 'third_party/antibot/antibotlinks.php';
			$antibotlinks = new antibotlinks(true, 'ttf,otf', array('abl_light_colors' => 'off', 'abl_background' => 'off', 'abl_noise' => 'on'));
			$antibotlinks->generate(3, true);
			$this->data['antibot_js'] = $antibotlinks->get_js();
			$this->data['antibot_show_info'] = $antibotlinks->show_info();
		}
		$this->data['captcha_display'] = get_captcha($this->data['settings'], base_url(), 'faucet_captcha');
		$this->data['countHistory'] = max(0, $this->data['settings']['daily_limit'] - $this->data['user']['today_faucet']);

		$this->data['anti_pos'] = [rand(0, 5), rand(0, 5), rand(0, 5)];
		$this->data['bonus'] = min($this->data['settings']['max_bonus'], $this->data['settings']['level_bonus'] * $this->data['user']['level']);
		$this->render('faucet', $this->data);
	}

	public function verify()
	{
		if ($this->input->post('token') != $this->data['user']['token']) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Claim'));
			return redirect(site_url('/faucet'));
		}
		if ($this->data['settings']['antibotlinks'] == 'on') {
			#CHECK ANTIBOTLINKS
			if ((trim($_POST['antibotlinks']) !== $_SESSION['antibotlinks']['solution']) or (empty($_SESSION['antibotlinks']['solution']))) {
				if ($this->data['user']['fail'] == $this->data['settings']['captcha_fail_limit']) {
					$this->m_core->insertCheatLog($this->data['user']['id'], 'Too many wrong captcha.', 0);
				} else if ($this->data['user']['fail'] < 4) {
					$this->m_core->wrongCaptcha($this->data['user']['id']);
				}
				$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Anti-Bot Links'));
				return redirect(site_url('/faucet'));
			}
		}
		#Check captcha
		$captcha = $this->input->post('captcha');
		$Check_captcha = false;
		setcookie('captcha', $captcha, time() + 86400 * 10);
		switch ($captcha) {
			case "recaptchav3":
				$Check_captcha = verifyRecaptchaV3($this->input->post('recaptchav3'), $this->data['settings']['recaptcha_v3_secret_key']);
				break;
			case "recaptchav2":
				$Check_captcha = verifyRecaptchaV2($this->input->post('g-recaptcha-response'), $this->data['settings']['recaptcha_v2_secret_key']);
				break;
			case "solvemedia":
				$Check_captcha = verifySolvemedia($this->data['settings']['v_key'], $this->data['settings']['h_key'], $this->input->ip_address(), $this->input->post('adcopy_challenge'), $this->input->post('adcopy_response'));
				break;
			case "hcaptcha":
				$Check_captcha = verifyHcaptcha($this->input->post('h-captcha-response'), $this->data['settings']['hcaptcha_secret_key'], $this->input->ip_address());
				break;
		}
		if (!$Check_captcha) {
			if ($this->data['user']['fail'] == $this->data['settings']['captcha_fail_limit']) {
				$this->m_core->insertCheatLog($this->data['user']['id'], 'Too many wrong captcha.', 0);
			} else if ($this->data['user']['fail'] < 4) {
				$this->m_core->wrongCaptcha($this->data['user']['id']);
			}
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Captcha'));
			return redirect(site_url('faucet'));
		}

		#CHECK BAD IP
		if ($this->m_core->newIp()) {
			$check = false;
			$isocode = 'N/A';
			if (!empty($this->data['settings']['proxycheck'])) {
				$check = proxycheck($this->data['settings'], $this->input->ip_address());
				$isocode = $check['isocode'];
			} else if (!empty($this->data['settings']['iphub'])) {
				$check = iphub($this->data['settings'], $this->input->ip_address());
				$isocode = $check['isocode'];
			}
			if ($check) {
				if ($check['status'] == 1) {
					$this->session->set_flashdata('message', faucet_alert('danger', 'VPN/ Proxy is not allowed!'));
					session_destroy();
					return redirect(site_url('login'));
				}

				if ($isocode != 'N/A') {
					if ($this->data['user']['isocode'] == 'N/A') {
						$this->m_core->updateIsocode($this->data['user']['id'], $isocode, $check['country']);
					} else if ($isocode != $this->data['user']['isocode']) {
						$this->session->set_flashdata('message', faucet_alert('danger', 'VPN/ Proxy is not allowed!'));
						session_destroy();
						return redirect(site_url('login'));
					}
				}
			}
		}

		if (time() - $this->data['user']['last_claim'] < $this->data['settings']['timer']) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Claim'));
			return redirect(site_url('/faucet'));
		}

		if ($this->data['user']['today_faucet'] >= $this->data['settings']['daily_limit'] && $this->data['user']['energy'] < $this->data['settings']['faucet_cost']) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Claim'));
			return redirect(site_url('/faucet'));
		}

		if ($this->data['user']['today_faucet'] >= $this->data['settings']['daily_limit']) {
			$this->m_faucet->reduce_energy($this->data['user']['id'], $this->data['settings']['faucet_cost']);
		}

		$reward = $this->data['settings']['reward'] * (1 + min($this->data['settings']['max_bonus'], $this->data['settings']['level_bonus'] * $this->data['user']['level']) / 100);
		$this->m_faucet->update_user($this->data['user']['id'], $reward);

		$this->m_core->addExp($this->data['user']['id'], $this->data['settings']['faucet_exp_reward']);
		if (($this->data['user']['exp'] + $this->data['settings']['faucet_exp_reward']) >= ($this->data['user']['level'] + 1) * 100) {
			$this->m_core->levelUp($this->data['user']['id']);
		}
		$this->m_faucet->insert_history($this->data['user']['id'], $reward);
		$this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', currency($reward, $this->data['settings']['currency_rate']) . ' has been added to your balance'));
		if ($this->data['user']['referred_by'] != 0 && time() - $this->m_core->lastActive($this->data['user']['referred_by']) < 86400) {
			$amount = $reward * $this->data['settings']['referral'] / 100;
			if ($amount > 0) {
				$this->m_core->update_referral($this->data['user']['referred_by'], $amount);
			}
		}

		if ($this->data['user']['fail'] > 0) {
			$this->m_core->resetFail($this->data['user']['id']);
		}

		if ($this->data['settings']['firewall'] == 'on' && time() - $this->data['user']['last_firewall'] > rand(1500, 2000)) {
			$this->m_core->firewallLock($this->data['user']['id']);
			return redirect(site_url('/firewall'));
		}
		redirect(site_url('/faucet'));
	}
}
