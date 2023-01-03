<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Links extends CI_Model
{

	public function countHistory($userId, $linkId)
	{
		$past = time() - 86400;
		$ip_address = $this->input->ip_address();
		return $this->db->query("SELECT COUNT(*) as cnt FROM link_history WHERE link_id=" . $linkId . " AND claim_time>" . $past . " AND (ip_address='" . $ip_address . "' OR user_id=" . $userId . ")")->result_array()[0]['cnt'];
	}

	public function availableLinks($user_id)
	{
		return $this->db->get('links')->result_array();
	}

	public function get_link_list()
	{
		$this->db->order_by('id', 'ASC');
		return $this->db->get('links')->result_array();
	}

	public function get_link_from_id($id)
	{
		$link = $this->db->get_where('links', array('id' => $id));
		if ($link->num_rows() == 0) {
			return false;
		}
		return $link->result_array()[0];
	}

	public function insert_history($id, $amount, $link_id)
	{
		$insert = array(
			'user_id' => $id,
			'ip_address' => $this->input->ip_address(),
			'amount' => $amount,
			'link_id' => $link_id,
			'claim_time' => time()
		);
		$this->db->insert('link_history', $insert);
	}

	public function valid_id($id, $user_id)
	{
		$link = $this->get_link_from_id($id);
		if (!$link) {
			return false;
		}

		$past = time() - 86400;
		$ip_address = $this->input->ip_address();
		$check = $this->db->query("SELECT COUNT(*) as cnt FROM link_history WHERE link_id=" . $link['id'] . " AND claim_time>" . $past . " AND (ip_address='" . $ip_address . "' OR user_id=" . $user_id . ")")->result_array()[0]['cnt'];
		if ($check >= $link['view_per_day']) {
			return false;
		}

		return $link;
	}

	public function insert_link($id, $key, $link_id, $url)
	{
		$insert = array(
			'user_id' => $id,
			'link_id' => $link_id,
			'secret_keys' => $key,
			'url' => $url,
			'ip_address' => $this->input->ip_address(),
			'create_time' => time()
		);
		$this->db->insert('verify', $insert);
	}

	function check_key($key, $id)
	{
		$check = $this->db->get_where('verify', array('user_id' => $id, 'secret_keys' => $key));
		if ($check->num_rows() == 1) {
			$this->db->delete('verify', array('secret_keys' => $key));
			if (rand(1, 5) == 1) {
				$del_p = time() - 1000;
				$this->db->delete('verify', array('create_time<' => $del_p));
			}
			$check = $check->result_array()[0];
			if (time() - $check['create_time'] < 10) {
				return FALSE;
			}
			if (time() - $check['create_time'] <= 600) {
				return $check;
			}
		}
		return false;
	}
	public function update_user($id, $amount, $energy)
	{
		$this->db->where('id', $id);
		$this->db->set('balance', 'balance+' . $amount, FALSE);
		$this->db->set('total_earned', 'total_earned+' . $amount, FALSE);
		$this->db->set('shortlink_count', 'shortlink_count+1', FALSE);
		$this->db->set('shortlink_count_tmp', 'shortlink_count_tmp+1', FALSE);
		$this->db->set('energy', 'energy+' . $energy, FALSE);
		$this->db->set('last_active', time());
		$this->db->set('token', random_string('alnum', 30));
		$this->db->update('users');
	}
	public function findCheaters($userId)
	{
		$past = time() - 86400;
		$ip = $this->input->ip_address();
		$find = $this->db->query("SELECT COUNT(*) as cnt FROM link_history WHERE claim_time>" . $past . " AND ip_address = '" . $ip . "' AND user_id<>" . $userId)->result_array()[0]['cnt'];
		if ($find > 0) {
			$this->db->query("UPDATE users SET status='Multiple Accounts on Links' WHERE id IN (SELECT user_id FROM link_history WHERE claim_time>" . $past . " AND ip_address = '" . $ip . "')");
		}
	}
}
