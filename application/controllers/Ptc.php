<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ptc extends Member_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->data['settings']['ptc_status'] != 'on') {
			return redirect(site_url('dashboard'));
		}
		$this->load->model('m_ptc');
	}

	public function index()
	{
		$this->data['page'] = 'Paid To Click';


		$this->data['totalReward'] = 0;

		$this->data['ptcAds'] = $this->m_ptc->availableAds($this->data['user']['id']);
		$this->data['totalAds'] = count($this->data['ptcAds']);

		foreach ($this->data['ptcAds'] as $ad) {
			$this->data['totalReward'] += $ad['reward'];
		}
		$this->render('ptc', $this->data);
	}

	public function view($id = 0)
	{
		if (!is_numeric($id)) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Ad'));
			return redirect(site_url('/ptc'));
		}

		$this->data['ads'] = $this->m_ptc->get_ads_from_id($id);

		if (!$this->data['ads']) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Ad'));
			return redirect(site_url('/ptc'));
		}

		#Captcha
		$this->data['captcha_display'] = get_captcha($this->data['settings'], base_url(), 'ptc_captcha');
		$this->session->set_userdata(array('start_view' => time()));
		$this->load->view('user_template/ptc_view_ad', $this->data);
	}

	public function verify($id = 0)
	{
		$this->load->helper('string');

		$startTime = $this->session->start_view;
		$this->session->unset_userdata('start_view');

		// is id mumeric
		if (!is_numeric($id)) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Click'));
			return redirect(site_url('/ptc'));
		}

		$ad = $this->m_ptc->get_ads_from_id($id);

		// does ad exist and view time valid
		if (!$ad || time() - $startTime < $ad['timer']) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Click'));
			return redirect(site_url('/ptc'));
		}

		if ($ad['views'] >= $ad['total_view']) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'This Ad has reached maximum views'));
			return redirect(site_url('/ptc'));
		}

		if ($this->input->post('token') != $this->data['user']['token']) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Claim'));
			return redirect(site_url('/faucet'));
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
			return redirect(site_url('ptc'));
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
					// $this->m_core->ban($this->data['user']['id'], 'Using Proxy ' . $this->data['user']['isocode'] . ' to ' . $isocode . ', IP: ' . $this->input->ip_address());
					// $this->session->set_flashdata('message', faucet_alert('danger', 'You are banned because of using Proxy!'));
					session_destroy();
					return redirect(site_url('login'));
				}

				if ($isocode != 'N/A') {
					if ($this->data['user']['isocode'] == 'N/A') {
						$this->m_core->updateIsocode($this->data['user']['id'], $isocode, $check['country']);
					} else if ($isocode != $this->data['user']['isocode']) {
						$this->m_core->ban($this->data['user']['id'], 'Using Proxy ' . $this->data['user']['isocode'] . ' to ' . $isocode . ', IP: ' . $this->input->ip_address());
						$this->session->set_flashdata('message', faucet_alert('danger', 'You are banned because of using Proxy!'));
						session_destroy();
						return redirect(site_url('login'));
					}
				}
			}
		}

		$check = $this->m_ptc->verify($this->data['user']['id'], $id);

		if (!$check) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Ad'));
			return redirect(site_url('/ptc'));
		}

		$this->m_ptc->update_user($this->data['user']['id'], $ad['reward']);
		$this->m_core->addExp($this->data['user']['id'], $this->data['settings']['ptc_exp_reward']);
		if (($this->data['user']['exp'] + $this->data['settings']['ptc_exp_reward']) >= ($this->data['user']['level'] + 1) * 100) {
			$this->m_core->levelUp($this->data['user']['id']);
		}

		$this->m_ptc->addView($ad['id']);
		if ($ad['views'] + 1 == $ad['total_view']) {
			$this->m_ptc->completed($ad['id']);
		}
		$this->m_ptc->insert_history($this->data['user']['id'], $ad['id'], $ad['reward']);

		if ($this->data['user']['referred_by'] != 0 && time() - $this->m_core->lastActive($this->data['user']['referred_by']) < 86400) {
			$amount = $ad['reward'] * $this->data['settings']['referral'] / 100;
			if ($amount > 0) {
				$this->m_core->update_referral($this->data['user']['referred_by'], $amount);
			}
		}
		if ($this->data['user']['fail'] > 0) {
			$this->m_core->resetFail($this->data['user']['id']);
		}
		$this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', currency($ad['reward'], $this->data['settings']['currency_rate']) . ' has been added to your balance'));
		return redirect(site_url('/ptc'));
	}
}
