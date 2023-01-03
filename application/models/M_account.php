<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Account extends CI_Model
{

	public function update_password($user_id, $password)
	{
		$this->db->where('id', $user_id);
		$this->db->set('password', $password);
		$this->db->set('last_active', time());
		$this->db->update('users');
	}

	public function get_faucet_history($id)
	{
		$this->db->order_by('id', "desc")->limit(20);
		return $this->db->get_where('faucet_history', array('user_id' => $id))->result_array();
	}

	public function get_other_history($id)
	{
		$this->db->order_by('id', "desc")->limit(50);
		return $this->db->get_where('other_history', array('user_id' => $id))->result_array();
	}

	public function get_wheel_history($id)
	{
		$this->db->order_by('id', "desc")->limit(20);
		return $this->db->get_where('wheel_history', array('user_id' => $id))->result_array();
	}

	public function get_shortlinks_history($id)
	{
		$this->db->order_by('id', "desc")->limit(20);
		return $this->db->get_where('link_history', array('user_id' => $id))->result_array();
	}

	public function get_ptc_history($id)
	{
		$this->db->order_by('id', "desc")->limit(20);
		return $this->db->get_where('ptc_history', array('user_id' => $id))->result_array();
	}

	public function get_lottery_history($id)
	{
		$this->db->order_by('id', "desc")->limit(20);
		return $this->db->get_where('lottery_winners', array('user_id' => $id))->result_array();
	}

	public function get_offerwall_history($id)
	{
		$this->db->order_by('claim_time', "desc")->limit(20);
		return $this->db->get_where('offerwall_history', array('user_id' => $id))->result_array();
	}

	public function get_task_history($id)
	{
		$this->db->order_by('id', "desc")->limit(20);
		return $this->db->query("SELECT tasks.name, task_history.id, tasks.usd_reward, task_history.claim_time FROM task_history, tasks WHERE task_history.user_id = " . $id . " AND task_history.task_id = tasks.id")->result_array();
	}

	public function get_withdrawals_history($id)
	{
		$this->db->order_by('id', "desc")->limit(20);
		return $this->db->get_where('withdraw_history', array('user_id' => $id))->result_array();
	}

	public function reduceBalance($id, $amount)
	{
		$this->db->set('balance', 'balance-' . $amount, FALSE);
		$this->db->where('id', $id);
		$this->db->update('users');
	}

	public function transferBalance($id, $amount)
	{
		$this->db->set('dep_balance', 'dep_balance+' . $amount, FALSE);
		$this->db->where('id', $id);
		$this->db->update('users');
	}

	public function add_withdrawal($user_id, $amount, $wallet)
	{
		$insert = array(
			'user_id' => $user_id,
			'ip_address' => $this->input->ip_address(),
			'amount' => $amount,
			'wallet' => $wallet,
			'create_time' => time()
		);
		$this->db->insert('pending_withdrawals', $insert);
	}

	public function get_ref($id)
	{
		return $this->db->get_where('users', array('referred_by' => $id))->num_rows();
	}
	public function insert_history($id, $type, $amount)
	{
		$insert = array(
			'user_id' => $id,
			'ip_address' => $this->input->ip_address(),
			'type' => $type,
			'amount' => $amount,
			'claim_time' => time()
		);
		$this->db->insert('withdraw_history', $insert);
	}
	public function getReferrals($userId)
	{
		$this->db->order_by('id', "desc")->limit(100);
		return $this->db->get_where('users', ['referred_by' => $userId])->result_array();
	}
}
