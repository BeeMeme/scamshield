<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reward extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->data['page'] = 'Reward User';
        $this->render('reward', $this->data);
    }

    public function add()
    {
        $userId = $this->db->escape_str($this->input->post('userId'));
        $balanceAmount = $this->db->escape_str($this->input->post('balanceAmount'));
        $depBalanceAmount = $this->db->escape_str($this->input->post('depBalanceAmount'));
        $energyAmount = $this->db->escape_str($this->input->post('energyAmount'));
        $this->m_admin->rewardUser($userId, $balanceAmount, $depBalanceAmount, $energyAmount);
        $this->session->set_flashdata('message', faucet_alert('success', $balanceAmount . 'USD, ' . $depBalanceAmount . ' USD, ' . $energyAmount . ' energy has been added to user ' . $userId));
        redirect(site_url('/admin/reward'));
    }
}
