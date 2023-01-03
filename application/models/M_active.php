<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Active extends CI_Model
{
	public function getUser($activeKey)
	{
		$user = $this->db->get_where('users', array('secret' => $activeKey));
		if ($user->num_rows() == 0) {
			return false;
		}
		return $user->result_array()[0];
	}
	public function active($activeKey)
	{
		$this->db->where('secret', $activeKey);
		$this->db->set('verified', 1);
		$this->db->set('secret', random_string('alnum', 30));
		$this->db->update('users');
		return $this->db->affected_rows() == 1;
	}

	public function updateReferralCount($userId)
	{
		$this->db->where('id', $userId);
		$this->db->set('ref_count', 'ref_count+1', FALSE);
		$this->db->update('users');
	}
}
