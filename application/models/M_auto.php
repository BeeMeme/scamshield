<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Auto extends CI_Model
{
	public function update_user($id, $amount, $cost)
	{
		$this->db->where('id', $id);
		$this->db->set('balance', 'balance+' . $amount, FALSE);
		$this->db->set('energy', 'energy-' . $cost, FALSE);
		$this->db->set('total_earned', 'total_earned+' . $amount, FALSE);
		$this->db->set('last_auto', time());
		$this->db->set('last_active', time());
		$this->db->update('users');
	}

	public function updateStat($amount)
	{
		$this->db->set('autofaucet_count', 'autofaucet_count+1', FALSE);
		$this->db->set('autofaucet_amount', 'autofaucet_amount+' . $amount, FALSE);
		$this->db->where('date', date("Y-m-d"));
		$this->db->update('faucet_stats');
	}
}
