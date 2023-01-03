<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->data['totalPendingAds'] = $this->m_admin->countPendingAds();
		$this->db->order_by('id', "desc");
		$this->data['pending_withdrawals'] = $this->m_admin->getPendingWithdrawals();
	}
}
