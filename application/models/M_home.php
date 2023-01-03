<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Home extends CI_Model
{
	public function total_user()
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM users")->result_array()[0]['cnt'];
	}
	public function countWithdrawals()
	{
		$lastWithdrawal = $this->db->query("SELECT * FROM withdraw_history ORDER BY id DESC LIMIT 1");
		if ($lastWithdrawal->num_rows() == 0) {
			return 0;
		}
		return $lastWithdrawal->result_array()[0]['id'];
	}
	public function get_earning()
	{
		$this->db->select_sum('total_earned');
		return $this->db->get('users')->row()->total_earned;
	}
	public function getCurrencies()
	{
		return $this->db->get('currencies')->result_array();
	}
	public function getPaymentProofs()
	{
		return $this->db->query('SELECT users.username, currencies.code, withdraw_history.* FROM users, withdraw_history, currencies WHERE withdraw_history.user_id=users.id AND withdraw_history.type = 1 AND currencies.id = withdraw_history.method ORDER BY id DESC LIMIT 20')->result_array();
	}
	public function getDayOnline()
	{
		$check = $this->db->query("SELECT id FROM faucet_stats ORDER BY id DESC LIMIT 1");
		if ($check->num_rows() == 0) {
			return false;
		}
		return $check->result_array()[0]['id'];
	}
}
