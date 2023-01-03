<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Dice extends CI_Model
{

	public function insertHistory($userId, $salt, $roll)
	{
		$insert = array(
			'user_id' => $userId,
			'salt' => $salt,
			'roll' => $roll,
			'claim_time' => time()
		);
		$this->db->insert('dice_history', $insert);
		return $this->db->insert_id();
	}

	public function getHistory($userId)
	{
		$this->db->order_by('id', "desc")->limit(10);
		return $this->db->get_where('dice_history', ['user_id' => $userId, 'open' => 1])->result_array();
	}


	public function getRoll($id)
	{
		$result = $this->db->get_where('dice_history', ['id' => $id]);

		if ($result->num_rows() == 0) {
			return false;
		}
		return $result->result_array()[0];
	}

	public function getOneLastRoll($userId)
	{
		$this->db->order_by('id', "desc")->limit(1);
		$result = $this->db->get_where('dice_history', ['user_id' => $userId, 'open' => 0]);

		if ($result->num_rows() == 0) {
			return false;
		}
		return $result->result_array()[0];
	}

	public function getLastRoll($userId)
	{
		$this->db->order_by('id', "desc")->limit(20);
		return $this->db->get_where('dice_history', ['user_id' => $userId])->result_array();
	}

	public function openLastRoll($id, $bet, $target, $type)
	{
		$this->db->where('id', $id);
		$this->db->set('target', $target);
		$this->db->set('bet', $bet);
		$this->db->set('type', $type);
		$this->db->set('open', 1);
		$this->db->update('dice_history');
	}

	public function updateRollProfit($id, $profit)
	{
		$this->db->where('id', $id);
		$this->db->set('profit', $profit);
		$this->db->update('dice_history');
	}

	public function addBalance($userId, $amount)
	{
		$this->db->where('id', $userId);
		$this->db->set('balance', 'balance+' . $amount, FALSE);
		$this->db->set('total_earned', 'total_earned+' . $amount, FALSE);
		$this->db->set('last_active', time());
		$this->db->update('users');
	}

	public function reduceBalance($userId, $amount)
	{
		$this->db->where('id', $userId);
		$this->db->set('balance', 'balance-' . $amount, FALSE);
		$this->db->set('last_active', time());
		$this->db->update('users');
	}
}
