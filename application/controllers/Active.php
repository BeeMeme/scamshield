<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Active extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_active');
		$this->data['settings'] = $this->m_core->getSettings();
	}

	public function verify($active_keys = '')
	{
		$this->load->helper('string');
		if (strlen($active_keys) != 30 || !preg_match("/^[a-zA-Z0-9]+$/", $active_keys)) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Account activation failed'));
			return redirect(site_url('/profile'));
		}
		$active_keys = $this->db->escape_str($this->db->escape_str($active_keys));
		$user = $this->m_active->getUser($active_keys);
		if ($this->m_active->active($active_keys) && $user['verified'] == 0) {
			$this->session->set_flashdata('message', faucet_alert('success', 'Your account has been activated successfully'));

			$valid = true;
			if (isset($_SERVER['HTTP_REFERER']) && filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL)) {
				$referralHost = parse_url($_SERVER['HTTP_REFERER'])['host'];
				$banMails = ['temp', 'tmp', 'mail.tm', '10minutemail', 'mailpoof', 'maildrop', 'emailondeck', 'throwawaymail', 'guerrillamail', 'mailinator', 'mailcatch', 'trashmail', 'getnada', 'owlymail', 'moakt', 'luxusmail', 'generator', 'fake', 'mintemail'];
				for ($i = 0; $i < count($banMails); ++$i) {
					if (strpos($referralHost, $banMails[$i]) !== false) {
						$this->m_core->updateStatus($user['id'], 'banned');
						$this->m_core->insertCheatLog($user['id'], 'Using fake mail: ' . $banMails[$i], 0);
						$valid = false;
						break;
					}
				}
			}

			if ($valid) {
				if ($user['referred_by'] != 0) {
					$this->m_active->updateReferralCount($user['referred_by']);
				}
			}
		} else {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Account activation failed'));
		}
		return redirect(site_url('/dashboard'));
	}
}
