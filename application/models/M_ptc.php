<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Ptc extends CI_Model
{

	public function availableAds($user_id)
	{
		$past = time() - 86400;
		$ip_address = $this->input->ip_address();

		return $this->db->query("SELECT * FROM ptc_ads WHERE views < total_view AND status = 'active' AND id NOT IN (SELECT ad_id FROM ptc_history WHERE claim_time>$past AND (ip_address='$ip_address' OR user_id=$user_id)) ORDER BY reward DESC")->result_array();
	}

	public function getAds()
	{
		return $this->db->get('ptc_ads')->result_array();
	}

	public function get_ads_from_id($id)
	{
		$link = $this->db->get_where('ptc_ads', array('id' => $id));
		if ($link->num_rows() == 0) {
			return false;
		}
		return $link->result_array()[0];
	}

	function verify($user_id, $ad_id)
	{
		$past = time() - 86400;
		$ip_address = $this->input->ip_address();

		$cnt = $this->db->query("SELECT ad_id FROM ptc_history WHERE ad_id = $ad_id AND claim_time>$past AND (ip_address='$ip_address' OR user_id=$user_id)")->num_rows();
		return ($cnt == 0);
	}
	public function update_user($id, $amount)
	{
		$this->db->where('id', $id);
		$this->db->set('balance', 'balance+' . $amount, FALSE);
		$this->db->set('total_earned', 'total_earned+' . $amount, FALSE);
		$this->db->set('last_active', time());
		$this->db->set('token', random_string('alnum', 30));
		$this->db->update('users');
	}
	public function addView($id)
	{
		$this->db->where('id', $id);
		$this->db->set('views', 'views+1', FALSE);
		$this->db->update('ptc_ads');
	}
	public function completed($id)
	{
		$this->db->where('id', $id);
		$this->db->set('status', 'completed');
		$this->db->update('ptc_ads');
	}
	public function insert_history($id, $ad_id, $amount)
	{
		$insert = array(
			'user_id' => $id,
			'ip_address' => $this->input->ip_address(),
			'ad_id' => $ad_id,
			'amount' => $amount,
			'claim_time' => time()
		);
		$this->db->insert('ptc_history', $insert);
	}
}
