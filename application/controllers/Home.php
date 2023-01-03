<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends Guess_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_home');
		$this->data['csrf_name'] = $this->security->get_csrf_token_name();
		$this->data['csrf_hash'] = $this->security->get_csrf_hash();
	}
	public function index()
	{

		$this->data['page'] = 'Home';

		$homeInfo = $this->cache->get('home_info');
		if (!$homeInfo) {
			$homeInfo = [
				'stat' => [
					'total_user' => $this->m_home->total_user(),
					'withdrawals' => $this->m_home->countWithdrawals(),
					'earning' => $this->m_home->get_earning(),
					'dayOnline' => $this->m_home->getDayOnline()
				],
				'lotteryReward' => $this->m_core->countLottery() * $this->data['settings']['lottery_reward'] + $this->data['settings']['lottery_base_reward'],
				'methods' => $this->m_home->getCurrencies(),
				'withdrawHistory' => $this->m_home->getPaymentProofs()
			];
			$this->cache->save('home_info', $homeInfo, 600);
		}
		$this->data = array_merge($this->data, $homeInfo);

		if (isset($_GET['r'])) {
			$this->session->set_userdata('referral', $_GET['r']);
		}

		$this->load->view('user_template/home_' . $this->data['settings']['home_page'], $this->data);
	}

	public function login()
	{
		$this->data['captcha_display'] = get_captcha($this->data['settings'], base_url(), 'login_captcha');
		$this->data['page'] = 'Login';
		$this->load->view('user_template/login', $this->data);
	}

	public function register()
	{
		$this->data['captcha_display'] = get_captcha($this->data['settings'], base_url(), 'register_captcha');
		$this->data['page'] = 'Register';
		$this->load->view('user_template/register', $this->data);
	}

	public function forgot_password()
	{
		$this->data['captcha_display'] = get_captcha($this->data['settings'], base_url(), 'login_captcha');
		$this->data['page'] = 'Forgot Password';
		$this->load->view('user_template/forgot-password', $this->data);
	}
}
