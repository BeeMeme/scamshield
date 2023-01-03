<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Faucet extends CI_Model
{

	public function reduce_energy($id, $cost)
	{
		$this->db->where('id', $id);
		$this->db->set('energy', 'energy-' . $cost, FALSE);
		$this->db->update('users');
	}

	public function insert_history($id, $amount)
	{
		$insert = array(
			'user_id' => $id,
			'ip_address' => $this->input->ip_address(),
			'amount' => $amount,
			'claim_time' => time()
		);
		$this->db->insert('faucet_history', $insert);
	}
	public function update_user($id, $amount)
	{
		$this->db->where('id', $id);
		$this->db->set('balance', 'balance+' . $amount, FALSE);
		$this->db->set('total_earned', 'total_earned+' . $amount, FALSE);
		$this->db->set('faucet_count', 'faucet_count+1', FALSE);
		$this->db->set('faucet_count_tmp', 'faucet_count_tmp+1', FALSE);
		$this->db->set('today_faucet', 'today_faucet+1', FALSE);
		$this->db->set('last_claim', time());
		$this->db->set('last_active', time());
		$this->db->set('token', random_string('alnum', 30));
		$this->db->update('users');
	}
	public function findCheaters($userId)
	{
		$past = time() - 86400;
		$ip = $this->input->ip_address();
		$find = $this->db->query("SELECT COUNT(*) as cnt FROM faucet_history WHERE claim_time>" . $past . " AND ip_address = '" . $ip . "' AND user_id<>" . $userId)->result_array()[0]['cnt'];
		if ($find > 0) {
			$this->db->query("UPDATE users SET status='Multiple Accounts on Faucet' WHERE id IN (SELECT user_id FROM faucet_history WHERE claim_time>" . $past . " AND ip_address = '" . $ip . "')");
		}
	}
}
