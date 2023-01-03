<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Currencies extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->data['page'] = 'Currency';
        $this->data['currencies'] = $this->m_admin->getCurrency();
        $this->render('currency', $this->data);
    }
    public function add()
    {
        $name = $this->db->escape_str($this->input->post('name'));
        $currencyName = $this->db->escape_str($this->input->post('currency_name'));
        $code = $this->db->escape_str($this->input->post('code'));
        $api = $this->db->escape_str($this->input->post('api'));
        $token = $this->db->escape_str($this->input->post('token'));
        $wallet = $this->db->escape_str($this->input->post('wallet'));
        $price = $this->db->escape_str($this->input->post('price'));
        $accountNumber = $this->db->escape_str($this->input->post('account_number'));
        $apiId = $this->db->escape_str($this->input->post('api_id'));
        $minimumWithdrawal = $this->db->escape_str($this->input->post('minimum_withdrawal'));
        $this->m_admin->addCurrency($name, $currencyName, $code, $api, $token, $wallet, $price, $accountNumber, $apiId, $minimumWithdrawal);
        redirect(site_url('admin/currencies'));
    }
    public function delete($id = 0)
    {
        $this->db->delete('currencies', array('id' => $id));
        redirect(site_url('admin/currencies'));
    }
    public function update($id = 0)
    {
        $name = $this->db->escape_str($this->input->post('name'));
        $currencyName = $this->db->escape_str($this->input->post('currency_name'));
        $code = $this->db->escape_str($this->input->post('code'));
        $api = $this->db->escape_str($this->input->post('api'));
        $token = $this->db->escape_str($this->input->post('token'));
        $wallet = $this->db->escape_str($this->input->post('wallet'));
        $price = $this->db->escape_str($this->input->post('price'));
        $status = $this->db->escape_str($this->input->post('status'));
        $accountNumber = $this->db->escape_str($this->input->post('account_number'));
        $apiId = $this->db->escape_str($this->input->post('api_id'));
        $minimumWithdrawal = $this->db->escape_str($this->input->post('minimum_withdrawal'));
        $this->m_admin->updateCurrency($id, $name, $currencyName, $code, $api, $token, $wallet, $price, $accountNumber, $apiId, $minimumWithdrawal, $status);
        redirect(site_url('admin/currencies'));
    }
}
