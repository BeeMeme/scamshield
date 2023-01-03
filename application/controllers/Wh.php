<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'third_party/coinbase/autoload.php';

use CoinbaseCommerce\ApiClient;
use CoinbaseCommerce\Resources\Charge;
use CoinbaseCommerce\Webhook;

class Wh extends Guess_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(['m_deposit', 'm_offerwall']);
		$this->data['settings'] = $this->m_core->getSettings();
		$this->data['whitelist_ips'] = [
			'coinbase' => [],
			'faucetpay' => [],
			'wannads' => [
				'34.250.159.173',
				'34.244.210.150',
				'52.212.236.135',
				'34.251.83.149'
			],
			'cpx' => [
				'188.40.3.73'
			],
			'offertoro' => [
				'54.175.173.245'
			],
			'ayetstudios' => [
				'35.165.166.40',
				'35.166.159.131',
				'52.40.3.140'
			],
			'personaly' => [
				'159.203.84.146',
				'52.200.142.249'
			],
			'bitswall' => [
				'188.165.198.204',
				'2001:41d0:2:8fcc::'
			],
			'payeer' => [
				'185.71.65.92',
				'185.71.65.189',
				'149.202.17.210'
			]
		];
	}

	public function coinbase()
	{
		if ($this->data['settings']['coinbase_deposit_status'] == 'off') {
			die();
		}
		$secret = $this->data['settings']['coinbase_secret'];
		$signraturHeader = isset($_SERVER['HTTP_X_CC_WEBHOOK_SIGNATURE']) ? $_SERVER['HTTP_X_CC_WEBHOOK_SIGNATURE'] : null;
		$payload = trim(file_get_contents('php://input'));

		try {
			$event = Webhook::buildEvent($payload, $signraturHeader, $secret);
			http_response_code(200);
			switch ($event->type) {
				case 'charge:created':
					$this->m_deposit->updateStatus($event->data->code, 'Created');
					break;
				case 'charge:confirmed':
					$this->m_deposit->updateStatus($event->data->code, 'Confirmed');
					$this->m_deposit->depositSuccess($event->data->code);
					break;
				case 'charge:failed':
					$this->m_deposit->updateStatus($event->data->code, 'Failed');
					break;
				case 'charge:delayed':
					$this->m_deposit->updateStatus($event->data->code, 'Delayed');
					break;
				case 'charge:pending':
					$this->m_deposit->updateStatus($event->data->code, 'Pending');
					break;
				case 'charge:resolved':
					$this->m_deposit->updateStatus($event->data->code, 'Confirmed');
					$this->m_deposit->updateStatus($event->data->code, 'Resolved');
					break;
			}
			echo sprintf('Successully verified event with id %s and type %s.', $event->id, $event->type);
		} catch (\Exception $exception) {
			http_response_code(400);
			echo 'Error occured. ' . $exception->getMessage();
		}
	}

	public function faucetpay()
	{
		if ($this->data['settings']['faucetpay_deposit_status'] == 'off') {
			die();
		}
		$token = $this->input->post('token');
		$validate = @json_decode(get_data('https://faucetpay.io/merchant/get-payment/' . $token), TRUE);
		if ($validate['valid'] && $validate['merchant_username'] == $this->data['settings']['faucetpay_username'] && $validate['currency1'] == 'USD' && $validate['amount1'] >= $this->data['settings']['faucetpay_min_deposit']) {
			if ($this->data['settings']['faucetpay_currency'] != "") {
				$faucetpayMethods = explode(',', $this->data['settings']['faucetpay_currency']);
				if (in_array($validate['currency2'], $faucetpayMethods)) {
					$this->m_deposit->addDeposit($validate['custom'], $validate['amount1'], $validate['transaction_id'], 1, 'Confirmed');
					$this->m_deposit->updateUser($validate['custom'], $validate['amount1']);
				}
			} else {
				$this->m_deposit->addDeposit($validate['custom'], $validate['amount1'], $validate['transaction_id'], 1, 'Confirmed');
				$this->m_deposit->updateUser($validate['custom'], $validate['amount1']);
			}
		}
	}

	public function payeer()
	{
		if (!in_array($this->input->ip_address(), $this->data['whitelist_ips']['payeer'])) {
			echo 'ok';
			die();
		}
		if (isset($_POST['m_operation_id']) && isset($_POST['m_sign'])) {
			$arHash = array(
				$_POST['m_operation_id'],
				$_POST['m_operation_ps'],
				$_POST['m_operation_date'],
				$_POST['m_operation_pay_date'],
				$_POST['m_shop'],
				$_POST['m_orderid'],
				$_POST['m_amount'],
				$_POST['m_curr'],
				$_POST['m_desc'],
				$_POST['m_status']
			);

			if (isset($_POST['m_params'])) {
				$arHash[] = $_POST['m_params'];
			}

			$arHash[] = $this->data['settings']['payeer_secret'];

			$sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));

			if ($_POST['m_sign'] == $sign_hash && $_POST['m_status'] == 'success' && $_POST['m_amount'] >= $this->data['settings']['payeer_min_deposit']) {
				$orderId = $this->db->escape_str($_POST['m_orderid']);
				$this->m_deposit->updateStatus($orderId, 'Confirmed');
				$this->m_deposit->depositSuccess($orderId);
				die($_POST['m_orderid'] . '|success');
			}

			die($_POST['m_orderid'] . '|error');
		}
	}

	public function wannads()
	{
		if (!in_array($this->input->ip_address(), $this->data['whitelist_ips']['wannads'])) {
			die();
		}
		$userId = isset($_GET['subId']) ? $this->db->escape_str($_GET['subId']) : null;
		$transactionId = isset($_GET['transId']) ? $this->db->escape_str($_GET['transId']) : null;
		$reward = isset($_GET['reward']) ? $this->db->escape_str($_GET['reward']) : null;
		$signature = isset($_GET['signature']) ? $this->db->escape_str($_GET['signature']) : null;
		$action = isset($_GET['status']) ? $this->db->escape_str($_GET['status']) : null;
		$userIp = isset($_GET['userIp']) ? $this->db->escape_str($_GET['userIp']) : "0.0.0.0";

		if (md5($userId . $transactionId . $reward . $this->data['settings']['wannads_secret_key']) != $signature) {
			echo "ERROR: Signature doesn't match";
			return;
		}

		$trans = $this->m_offerwall->getTransaction($transactionId, 'wannads');
		if ($action == 2) {
			$this->m_offerwall->reduceUserBalance($userId, abs($reward));
			$this->m_offerwall->insertTransaction($userId, 'wannads', $userIp, $reward, $transactionId, 1, time());
			echo "OK";
		} else {
			if (!$trans) {
				$hold = 0;
				if ($reward > $this->data['settings']['offerwall_min_hold']) {
					$hold = $this->data['settings']['wannads_hold'];
				}
				if ($hold == 0) {
					$offerId = $this->m_offerwall->insertTransaction($userId, 'wannads', $userIp, $reward, $transactionId, 2, time());
					$this->m_offerwall->updateUserBalance($userId, $reward);
					$this->m_core->addNotification($userId, currency($reward, $this->data['settings']['currency_rate']) . " from Wannads Offer #" . $offerId . " was credited to your balance.", 1);

					$user = $this->m_core->get_user_from_id($userId);
					$this->m_core->addExp($user['id'], $this->data['settings']['offerwall_exp_reward']);
					if (($user['exp'] + $this->data['settings']['offerwall_exp_reward']) >= ($user['level'] + 1) * 100) {
						$this->m_core->levelUp($user['id']);
					}
				} else {
					$availableAt = time() + $hold * 86400;
					$offerId = $this->m_offerwall->insertTransaction($userId, 'wannads', $userIp, $reward, $transactionId, 0, $availableAt);
					$this->m_core->addNotification($userId, "Your Wannads Offer #" . $offerId . " is pending approval.", 0);
				}
				echo "OK";
			} else {
				echo "DUP";
			}
		}
	}

	public function offertoro()
	{
		if (!in_array($this->input->ip_address(), $this->data['whitelist_ips']['offertoro'])) {
			echo 'ok';
			die();
		}
		$secret = $this->data['settings']['offertoro_app_secret'];

		$userId = isset($_GET['user_id']) ? $this->db->escape_str($_GET['user_id']) : 2;
		$transactionId = isset($_GET['oid']) ? $this->db->escape_str($_GET['oid']) : null;
		$offerId = isset($_GET['oid']) ? $this->db->escape_str($_GET['oid']) : null;
		$reward = isset($_GET['amount']) ? $this->db->escape_str($_GET['amount']) : null;
		$ipAddress = isset($_GET['ip_address']) ? $this->db->escape_str($_GET['ip_address']) : null;
		$signature = isset($_GET['sig']) ? $this->db->escape_str($_GET['sig']) : null;

		if (md5($offerId . '-' . $userId . '-' . $secret) != $signature) {
			echo 0;
			return;
		}

		if ($reward < 0) {
			$this->m_offerwall->reduceUserBalance($userId, abs($reward));
			$this->m_offerwall->insertTransaction($userId, 'Offertoro', $ipAddress, $reward, $transactionId, 1, time());
			echo 1;
		} else {
			$trans = $this->m_offerwall->getTransaction($transactionId, 'offertoro');
			if (!$trans) {
				$hold = 0;
				if ($reward > $this->data['settings']['offerwall_min_hold']) {
					$hold = $this->data['settings']['offertoro_hold'];
				}
				if ($hold == 0) {
					$offerId = $this->m_offerwall->insertTransaction($userId, 'offertoro', $ipAddress, $reward, $transactionId, 2, time());
					$this->m_offerwall->updateUserBalance($userId, $reward);
					$this->m_core->addNotification($userId, currency($reward, $this->data['settings']['currency_rate']) . " from Offertoro Offer #" . $offerId . " was credited to your balance.", 1);

					$user = $this->m_core->get_user_from_id($userId);
					$this->m_core->addExp($user['id'], $this->data['settings']['offerwall_exp_reward']);
					if (($user['exp'] + $this->data['settings']['offerwall_exp_reward']) >= ($user['level'] + 1) * 100) {
						$this->m_core->levelUp($user['id']);
					}
				} else {
					$availableAt = time() + $hold * 86400;
					$offerId = $this->m_offerwall->insertTransaction($userId, 'offertoro', $ipAddress, $reward, $transactionId, 0, $availableAt);
					$this->m_core->addNotification($userId, "Your Offertoro Offer #" . $offerId . " is pending approval.", 0);
				}
				echo 1;
			} else {
				echo 1;
			}
		}
	}

	public function cpx()
	{
		if (!in_array($this->input->ip_address(), $this->data['whitelist_ips']['cpx'])) {
			echo 'ok';
			die();
		}
		$secret = $this->data['settings']['cpx_hash'];
		$userId = isset($_GET['user_id']) ? $this->db->escape_str($_GET['user_id']) : null;
		$action = isset($_GET['status']) ? $this->db->escape_str($_GET['status']) : null;
		$transactionId = isset($_GET['trans_id']) ? $this->db->escape_str($_GET['trans_id']) : null;
		$reward = isset($_GET['amount']) ? $this->db->escape_str($_GET['amount']) : null;
		$userIp = isset($_GET['ip_click']) ? $this->db->escape_str($_GET['ip_click']) : "0.0.0.0";
		$signature = isset($_GET['hash']) ? $this->db->escape_str($_GET['hash']) : null;

		if (md5($transactionId . '-' . $secret) != $signature) {
			echo "ERROR: Signature doesn't match";
			return;
		}

		$trans = $this->m_offerwall->getTransaction($transactionId, 'CPX Research');
		if ($action == 2) {
			$this->m_offerwall->reduceUserBalance($userId, abs($reward));
			$this->m_offerwall->insertTransaction($userId, 'CPX Research', $userIp, $reward, $transactionId, 1, time());
			echo "OK";
		} else {
			if (!$trans) {
				$hold = 0;
				if ($reward > $this->data['settings']['offerwall_min_hold']) {
					$hold = $this->data['settings']['cpx_hold'];
				}
				if ($hold == 0) {
					$offerId = $this->m_offerwall->insertTransaction($userId, 'CPX Research', $userIp, $reward, $transactionId, 2, time());
					$this->m_offerwall->updateUserBalance($userId, $reward);
					$this->m_core->addNotification($userId, currency($reward, $this->data['settings']['currency_rate']) . " from CPX Research Offer #" . $offerId . " was credited to your balance.", 1);

					$user = $this->m_core->get_user_from_id($userId);
					$this->m_core->addExp($user['id'], $this->data['settings']['offerwall_exp_reward']);
					if (($user['exp'] + $this->data['settings']['offerwall_exp_reward']) >= ($user['level'] + 1) * 100) {
						$this->m_core->levelUp($user['id']);
					}
				} else {
					$availableAt = time() + $hold * 86400;
					$offerId = $this->m_offerwall->insertTransaction($userId, 'CPX Research', $userIp, $reward, $transactionId, 0, $availableAt);
					$this->m_core->addNotification($userId, "Your CPX Research Offer #" . $offerId . " is pending approval.", 0);
				}
				echo "OK";
			} else {
				echo "DUP";
			}
		}
	}

	public function ayetstudios()
	{
		$userId = isset($_REQUEST['uid']) ? $this->db->escape_str($_REQUEST['uid']) : null;
		$transactionId = isset($_REQUEST['transaction_id']) ? $this->db->escape_str($_REQUEST['transaction_id']) : null;
		$action = isset($_REQUEST['is_chargeback']) ? $this->db->escape_str($_REQUEST['is_chargeback']) : null;
		$reward = isset($_REQUEST['currency_amount']) ? $this->db->escape_str($_REQUEST['currency_amount']) : null;
		$userIp = isset($_REQUEST['ip']) ? $this->db->escape_str($_REQUEST['ip']) : "not available";
		$signature = isset($_SERVER['HTTP_X_AYETSTUDIOS_SECURITY_HASH']) ? $this->db->escape_str($_SERVER['HTTP_X_AYETSTUDIOS_SECURITY_HASH']) : null;

		ksort($_REQUEST, SORT_STRING);
		$sortedQueryString = http_build_query($_REQUEST, '', '&');
		$securityHash = hash_hmac('sha256', $sortedQueryString, $this->data['settings']['ayetstudios_api']);
		error_log($_SERVER['HTTP_X_AYETSTUDIOS_SECURITY_HASH']);
		if ($securityHash != $signature) {
			echo "invalid signature";
			return;
		}

		$trans = $this->m_offerwall->getTransaction($transactionId, 'AyetStudios');
		if ($action == 1) {
			$this->m_offerwall->reduceUserBalance($userId, abs($reward));
			$this->m_offerwall->insertTransaction($userId, 'AyetStudios', $userIp, $reward, $transactionId, 1, time());
			echo "ok";
		} else {
			if (!$trans) {
				$hold = 0;
				if ($reward > $this->data['settings']['offerwall_min_hold']) {
					$hold = $this->data['settings']['ayetstudios_hold'];
				}
				if ($hold == 0) {
					$offerId = $this->m_offerwall->insertTransaction($userId, 'AyetStudios', $userIp, $reward, $transactionId, 2, time());
					$this->m_offerwall->updateUserBalance($userId, $reward);
					$this->m_core->addNotification($userId, currency($reward, $this->data['settings']['currency_rate']) . " from AyetStudios Offer #" . $offerId . " was credited to your balance.", 1);

					$user = $this->m_core->get_user_from_id($userId);
					$this->m_core->addExp($user['id'], $this->data['settings']['offerwall_exp_reward']);
					if (($user['exp'] + $this->data['settings']['offerwall_exp_reward']) >= ($user['level'] + 1) * 100) {
						$this->m_core->levelUp($user['id']);
					}
				} else {
					$availableAt = time() + $hold * 86400;
					$offerId = $this->m_offerwall->insertTransaction($userId, 'AyetStudios', $userIp, $reward, $transactionId, 0, $availableAt);
					$this->m_core->addNotification($userId, "Your AyetStudios Offer #" . $offerId . " is pending approval.", 0);
				}
				echo "ok";
			} else {
				echo "ok";
			}
		}
	}
	public function offerdaddy()
	{
		$transactionId = $this->db->escape_str(urldecode($_GET["transaction_id"]));
		$offer_id = $this->db->escape_str(urldecode($_GET["offer_id"]));
		$reward = $this->db->escape_str(urldecode($_GET["amount"]));
		$userId = $this->db->escape_str(urldecode($_GET["userid"]));
		$signature = urldecode($_GET["signature"]);

		//Check the signature
		$validationSignature = md5($transactionId . "/" . $offer_id . "/" . $this->data['settings']['offerdaddy_app_key']);

		if ($validationSignature != trim($signature)) {
			echo "0";
			die();
		}

		$trans = $this->m_offerwall->getTransaction($transactionId, 'OfferDady');
		if ($reward < 0) {
			$this->m_offerwall->reduceUserBalance($userId, abs($reward));
			$this->m_offerwall->insertTransaction($userId, 'OfferDady', 'not available', $reward, $transactionId, 1, time());
			echo "1";
		} else {
			if (!$trans) {
				$hold = 0;
				if ($reward > $this->data['settings']['offerwall_min_hold']) {
					$hold = $this->data['settings']['offerdaddy_hold'];
				}
				if ($hold == 0) {
					$offerId = $this->m_offerwall->insertTransaction($userId, 'OfferDady', 'not available', $reward, $transactionId, 2, time());
					$this->m_offerwall->updateUserBalance($userId, $reward);
					$this->m_core->addNotification($userId, currency($reward, $this->data['settings']['currency_rate']) . " from OfferDady Offer #" . $offerId . " was credited to your balance.", 1);

					$user = $this->m_core->get_user_from_id($userId);
					$this->m_core->addExp($user['id'], $this->data['settings']['offerwall_exp_reward']);
					if (($user['exp'] + $this->data['settings']['offerwall_exp_reward']) >= ($user['level'] + 1) * 100) {
						$this->m_core->levelUp($user['id']);
					}
				} else {
					$availableAt = time() + $hold * 86400;
					$offerId = $this->m_offerwall->insertTransaction($userId, 'OfferDady', 'not available', $reward, $transactionId, 0, $availableAt);
					$this->m_core->addNotification($userId, "Your OfferDady Offer #" . $offerId . " is pending approval.", 0);
				}
				echo "1";
			} else {
				echo "1";
			}
		}
	}
	public function personaly()
	{
		if (!in_array($this->input->ip_address(), $this->data['whitelist_ips']['personaly'])) {
			echo 'ok';
			die();
		}
		$transactionId = isset($_GET['offer_id']) ? $this->db->escape_str($_GET['offer_id']) : null;
		$reward = isset($_GET['amount']) ? $this->db->escape_str($_GET['amount']) : null;
		$userId = isset($_GET['user_id']) ? $this->db->escape_str($_GET['user_id']) : null;
		$userIp = isset($_GET['user_ip']) ? $this->db->escape_str($_GET['user_ip']) : "not available";
		$signature = isset($_GET['signature']) ? $this->db->escape_str($_GET['signature']) : "null";

		//Check the signature
		$validationSignature = md5($userId . ':' . $this->data['settings']['personaly_hash'] . ':' . $this->data['settings']['personaly_secret_key']);

		if ($validationSignature != trim($signature)) {
			echo "0";
			die();
		}

		if ($reward < 0) {
			$this->m_offerwall->reduceUserBalance($userId, abs($reward));
			$this->m_offerwall->insertTransaction($userId, 'Persona.ly', $userIp, $reward, $transactionId, 1, time());
			echo "1";
		} else {
			$hold = 0;
			if ($reward > $this->data['settings']['offerwall_min_hold']) {
				$hold = $this->data['settings']['personaly_hold'];
			}
			if ($hold == 0) {
				$offerId = $this->m_offerwall->insertTransaction($userId, 'Persona.ly', $userIp, $reward, $transactionId, 2, time());
				$this->m_offerwall->updateUserBalance($userId, $reward);
				$this->m_core->addNotification($userId, currency($reward, $this->data['settings']['currency_rate']) . " from Persona.ly Offer #" . $offerId . " was credited to your balance.", 1);

				$user = $this->m_core->get_user_from_id($userId);
				$this->m_core->addExp($user['id'], $this->data['settings']['offerwall_exp_reward']);
				if (($user['exp'] + $this->data['settings']['offerwall_exp_reward']) >= ($user['level'] + 1) * 100) {
					$this->m_core->levelUp($user['id']);
				}
			} else {
				$availableAt = time() + $hold * 86400;
				$offerId = $this->m_offerwall->insertTransaction($userId, 'Persona.ly', $userIp, $reward, $transactionId, 0, $availableAt);
				$this->m_core->addNotification($userId, "Your Persona.ly Offer #" . $offerId . " is pending approval.", 0);
			}
			echo "1";
		}
	}

	public function pollfish()
	{
		$transactionId = isset($_GET['tx_id']) ? $this->db->escape_str($_GET['tx_id']) : null;
		$reward = isset($_GET['reward_value']) ? $this->db->escape_str($_GET['reward_value']) : null;
		$status = isset($_GET['status']) ? $this->db->escape_str($_GET['status']) : null;
		$userId = isset($_GET['request_uuid']) ? $this->db->escape_str($_GET['request_uuid']) : null;
		$userIp = isset($_GET['user_ip']) ? $this->db->escape_str($_GET['user_ip']) : "not available";
		$signature = isset($_GET['signature']) ? $this->db->escape_str($_GET['signature']) : "null";

		$cpa = rawurldecode($_GET["cpa"]);
		$device_id = rawurldecode($_GET["device_id"]);
		$reward_name = rawurldecode($_GET["reward_name"]);
		$timestamp = rawurldecode($_GET["timestamp"]);

		$data = $cpa . ":" . $device_id;
		if (!empty($userId)) {
			$data = $data . ":" . $userId;
		}
		$data = $data . ":" . $reward_name . ":" . $reward . ":" . $status . ":" . $timestamp . ":" . $transactionId;

		$computedSignature = base64_encode(hash_hmac("sha1", $data, $this->data['settings']['pollfish_secret'], true));
		if ($signature == $computedSignature) {
			if ($status == 'eligible') {
				if ($this->data['settings']['pollfish_hold'] == 0) {
					$offerId = $this->m_offerwall->insertTransaction($userId, 'Pollfish', $userIp, $reward, $transactionId, 2, time());
					$this->m_offerwall->updateUserBalance($userId, $reward);
					$this->m_core->addNotification($userId, currency($reward, $this->data['settings']['currency_rate']) . " from Pollfish Offer #" . $offerId . " was credited to your balance.", 1);

					$user = $this->m_core->get_user_from_id($userId);
					$this->m_core->addExp($user['id'], $this->data['settings']['offerwall_exp_reward']);
					if (($user['exp'] + $this->data['settings']['offerwall_exp_reward']) >= ($user['level'] + 1) * 100) {
						$this->m_core->levelUp($user['id']);
					}
				} else {
					$availableAt = time() + $this->data['settings']['pollfish_hold'] * 86400;
					$offerId = $this->m_offerwall->insertTransaction($userId, 'Pollfish', $userIp, $reward, $transactionId, 0, $availableAt);
					$this->m_core->addNotification($userId, "Your Pollfish Offer #" . $offerId . " is pending approval.", 0);
				}
				echo "1";
			} else {
				$this->m_offerwall->insertTransaction($userId, 'Pollfish', $userIp, $reward, $transactionId, 1, time());
			}
		}
	}

	public function bitswall()
	{
		// if (!in_array($this->input->ip_address(), $this->data['whitelist_ips']['bitswall'])) {
		// 	echo 'ok';
		// 	die();
		// }
		$userId = isset($_REQUEST['subId']) ? $this->db->escape_str($_REQUEST['subId']) : null;
		$transactionId = isset($_REQUEST['transId']) ? $this->db->escape_str($_REQUEST['transId']) : null;
		$reward = isset($_REQUEST['reward']) ? $this->db->escape_str($_REQUEST['reward']) : null;
		$userIp = isset($_REQUEST['userIp']) ? $this->db->escape_str($_REQUEST['userIp']) : "0.0.0.0";
		$signature = isset($_REQUEST['signature']) ? $this->db->escape_str($_REQUEST['signature']) : null;
		if (md5($userId . $transactionId . $reward . $this->data['settings']['bitswall_secret']) != $signature) {
			echo "ERROR: Signature doesn't match";
			return;
		}

		$trans = $this->m_offerwall->getTransaction($transactionId, 'Bitswall');
		if (!$trans) {
			$hold = 0;
			if ($reward > $this->data['settings']['offerwall_min_hold']) {
				$hold = $this->data['settings']['bitswall_hold'];
			}
			if ($hold == 0) {
				$offerId = $this->m_offerwall->insertTransaction($userId, 'Bitswall', $userIp, $reward, $transactionId, 2, time());
				$this->m_offerwall->updateUserBalance($userId, $reward);
				$this->m_core->addNotification($userId, currency($reward, $this->data['settings']['currency_rate']) . " from Bitswall Offer #" . $offerId . " was credited to your balance.", 1);

				$user = $this->m_core->get_user_from_id($userId);
				$this->m_core->addExp($user['id'], $this->data['settings']['offerwall_exp_reward']);
				if (($user['exp'] + $this->data['settings']['offerwall_exp_reward']) >= ($user['level'] + 1) * 100) {
					$this->m_core->levelUp($user['id']);
				}
			} else {
				$availableAt = time() + $hold * 86400;
				$offerId = $this->m_offerwall->insertTransaction($userId, 'Bitswall', $userIp, $reward, $transactionId, 0, $availableAt);
				$this->m_core->addNotification($userId, "Your Bitswall Offer #" . $offerId . " is pending approval.", 0);
			}
			echo "ok";
		} else {
			echo "DUP";
		}
	}

	public function monlix()
	{
		// UPDATE YOUR SECRET KEY
		$secretKey = $this->data['settings']['monlix_secret'];
		$hold = $this->data['settings']['monlix_hold'];
		$userId = isset($_GET['userId']) ? $this->db->escape_str($_GET['userId']) : null;
		$userIp = isset($_GET['userIp']) ? $this->db->escape_str($_GET['userIp']) : "0.0.0.0";
		$transactionId = isset($_GET['transactionId']) ? $this->db->escape_str($_GET['transactionId']) : null;
		$reward = isset($_GET['rewardValue']) ? $this->db->escape_str($_GET['rewardValue']) : null;
		$action = isset($_GET['status']) ? $this->db->escape_str($_GET['status']) : null;
		$signature = isset($_GET['secretKey']) ? $this->db->escape_str($_GET['secretKey']) : null;
		if ($secretKey != $signature) {
			echo "ERROR: Signature doesn't match";
			return;
		}
		$trans = $this->m_offerwall->getTransaction($transactionId, 'Monlix');
		if ($action == 2) {
			$this->m_offerwall->reduceUserBalance($userId, abs($reward));
			$this->m_offerwall->insertTransaction($userId, 'Monlix', $userIp, $reward, $transactionId, 1, time());
			echo "OK";
		} else {
			if (!$trans) {
				$hold = 0;
				if ($reward > $this->data['settings']['offerwall_min_hold']) {
					$hold = $this->data['settings']['monlix_hold'];
				}
				if ($hold == 0) {
					$offerId = $this->m_offerwall->insertTransaction($userId, 'Monlix', $userIp, $reward, $transactionId, 2, time());
					$this->m_offerwall->updateUserBalance($userId, $reward);
					$this->m_core->addNotification($userId, format_money($reward) . " USD from Monlix Offer #" . $offerId . " was credited to your balance.", 1);
					$user = $this->m_core->get_user_from_id($userId);
					$this->m_core->addExp($user['id'], $this->data['settings']['offerwall_exp_reward']);
					if (($user['exp'] + $this->data['settings']['offerwall_exp_reward']) >= ($user['level'] + 1) * 100) {
						$this->m_core->levelUp($user['id']);
					}
				} else {
					$availableAt = time() + $hold * 86400;
					$offerId = $this->m_offerwall->insertTransaction($userId, 'Monlix', $userIp, $reward, $transactionId, 0, $availableAt);
					$this->m_core->addNotification($userId, "Your Monlix Offer #" . $offerId . " is pending approval.", 0);
				}
				echo "OK";
			} else {
				echo "DUP";
			}
		}
	}
}
