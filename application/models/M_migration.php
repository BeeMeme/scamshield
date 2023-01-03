<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_migration extends CI_Model
{
	public function updateUsername($userId, $username)
	{
		$this->db->where('id', $userId);
		$this->db->set('username', $username);
		$this->db->update('users');
	}
}
