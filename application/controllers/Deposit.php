<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'third_party/coinbase/autoload.php';

use CoinbaseCommerce\ApiClient;
use CoinbaseCommerce\Resources\Charge;
use CoinbaseCommerce\Webhook;

class Deposit extends Member_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_deposit');
	}

	public function index()
	{
		$this->data['page'] = 'Deposit';
		$this->data['deposits'] = $this->m_deposit->getDepositByUser($this->data['user']['id']);
		if ($this->input->get('success') != NULL) {
			if ($this->input->get('success') == 'true') {
				$this->data['message'] = faucet_alert('success', 'Deposit success!');
			} else {
				$this->data['message'] = faucet_alert('success', 'Deposit failed!');
			}
		}
		$this->data['faucetpayMethods'] = explode(',', $this->data['settings']['faucetpay_currency']);
		$this->render('deposit', $this->data);
	}

	public function coinbase()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required|is_numeric');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', faucet_alert('danger', validation_errors()));
			return redirect(site_url('/deposit'));
		}

		$amount = number_format($this->db->escape_str($this->input->post('amount')), 6);
		if ($amount < $this->data['settings']['minimum_deposit']) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Minimum deposit is ' . currency($this->data['settings']['minimum_deposit'], $this->data['settings']['currency_rate'])));
			return redirect(site_url('/deposit'));
		}

		ApiClient::init($this->data['settings']['coinbase_api']);
		$chargeObj = new Charge(
			[
				"description" => 'Deposit to ' . $this->data['settings']['name'],
				"metadata" => [
					'user_id' => $this->data['user']['id'],
					'order_id' => 1
				],
				"name" => $this->data['settings']['name'],
				"payments" => [],
				"pricing_type" => "fixed_price",
				"local_price" => [
					"amount" => $amount,
					"currency" => 'USD'
				]
			]
		);

		try {
			$chargeObj->save();
			$this->m_deposit->addDeposit($this->data['user']['id'], $amount, $chargeObj->code, 2);
			redirect($chargeObj->hosted_url);
		} catch (\Exception $exception) {
			echo sprintf("Enable to create charge. Error: %s \n", $exception->getMessage());
		}
	}

	public function payeer()
	{
		$this->load->library('form_validation');
		$this->load->helper('string');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required|is_numeric');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', faucet_alert('danger', validation_errors()));
			return redirect(site_url('/deposit'));
		}
		$amount = number_format($this->input->post('amount'), 2, '.', '');
		$payeer['m_shop'] = $this->data['settings']['payeer_id'];
		$payeer['m_orderid'] = random_string('alnum', 20);
		$payeer['m_amount'] = $amount;
		$payeer['m_curr'] = 'USD';
		$payeer['m_desc'] = base64_encode('Payment to ' . $this->data['settings']['name']);
		$payeer['m_key'] = $this->data['settings']['payeer_secret'];

		$arHash = array(
			$payeer['m_shop'],
			$payeer['m_orderid'],
			$payeer['m_amount'],
			$payeer['m_curr'],
			$payeer['m_desc'],
			$payeer['m_key']
		);

		$payeer['sign'] = strtoupper(hash('sha256', implode(':', $arHash)));
		$this->m_deposit->addDeposit($this->data['user']['id'], $amount, $payeer['m_orderid'], 3);

		redirect('https://payeer.com/merchant/?m_shop=' . $payeer['m_shop'] . '&m_orderid=' . $payeer['m_orderid'] . '&m_amount=' . $payeer['m_amount'] . '&m_curr=' . $payeer['m_curr'] . '&m_desc=' . $payeer['m_desc'] . '&m_sign=' . $payeer['sign'] . '&m_process=send');
	}
}
