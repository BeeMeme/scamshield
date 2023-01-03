<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends Member_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_account');
		$this->load->library('form_validation');
	}
	public function index()
	{
		$this->data['page'] = 'Profile';

		$this->data['referral_count'] = $this->m_account->get_ref($this->data['user']['id']);

		$this->render('account', $this->data);
	}
	public function history()
	{
		$this->data['page'] = 'Account History';

		$this->data['task_history'] = $this->m_account->get_task_history($this->data['user']['id']);
		$this->data['lottery_history'] = $this->m_account->get_lottery_history($this->data['user']['id']);
		$this->data['offerwall_history'] = $this->m_account->get_offerwall_history($this->data['user']['id']);
		$this->data['withdrawals_history'] = $this->m_account->get_withdrawals_history($this->data['user']['id']);
		$this->render('history', $this->data);
	}
	public function referrals()
	{
		$this->data['page'] = 'Referrals';
		$this->data['referrals'] = $this->m_account->getReferrals($this->data['user']['id']);

		$this->render('referrals', $this->data);
	}

	public function update_password()
	{
		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|min_length[3]|md5');
		$this->form_validation->set_rules('password', 'New Password', 'trim|required|min_length[3]|md5');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]|md5');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', faucet_alert('danger', validation_errors()));
			return redirect(site_url('account'));
		}
		if ($this->input->post('old_password') != $this->data['user']['password']) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Your current password is incorrect'));
			redirect(site_url('account'));
		}
		$password = $this->db->escape_str($this->input->post('password'));
		$this->m_account->update_password($this->data['user']['id'], $password);
		$this->session->set_flashdata('message', faucet_alert('success', 'Your password has been updated'));
		redirect(site_url('account'));
	}

	public function resend()
	{
		if ($this->data['user']['verified'] == 1) {
			return redirect(site_url('account'));
		}
		$message = '<html>
		<head>
			<title>Welcome to ' . $this->data['settings']['name'] . '</title>
		</head>
		<body>
			<h1>Thanks you for joining with us!</h1>
			<p>To active your account at ' . $this->data['settings']['name'] . ', please click this link (or you can copy and paste it in your browser)</p>
			<a href="' . site_url('/active/' . $this->data['user']['secret']) . '">' . site_url('/active/' . $this->data['user']['secret']) . '</a>
		</body>
		</html>';

		if (sendMail($this->data['user']['email'], 'Active your account', $message, $this->data['settings'])) {
			$this->session->set_flashdata('message', faucet_alert('success', 'Email sent'));
		} else {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Failed to sent email'));
		}
		return redirect(site_url('account'));
	}

	public function transfer()
	{
		$this->data['page'] = 'Transfer';
		$this->render('transfer', $this->data);
	}

	public function transfer_balance()
	{
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required|is_numeric|greater_than[0]');

		if ($this->form_validation->run() == FALSE) {
			return redirect(site_url('/transfer'));
		}

		$amount = $this->input->post('amount') * $this->data['settings']['currency_rate'];
		if ($amount > $this->data['user']['balance']) {
			return redirect(site_url('/transfer'));
		}

		$this->m_account->reduceBalance($this->data['user']['id'], $amount);
		$this->m_account->transferBalance($this->data['user']['id'], $amount);
		$this->session->set_flashdata('message', faucet_alert('success', $this->input->post('amount') . ' tokens have been added to your deposit balance!'));
		return redirect(site_url('/transfer'));
	}
}
