<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Achievements extends CI_Model
{

	public function get()
	{
		return $this->db->get('achievements')->result_array();
	}

	public function update($id, $type, $condition, $reward_usd, $reward_energy)
	{
		$this->db->where('id', $id);
		$this->db->set('type', $type);
		$this->db->set('condition', $condition);
		$this->db->set('reward_usd', $reward_usd);
		$this->db->set('reward_energy', $reward_energy);
		$this->db->update('achievements');
	}
	public function add($type, $condition, $reward_usd, $reward_energy)
	{
		$insert = array(
			'type' => $type,
			'condition' => $condition,
			'reward_usd' => $reward_usd,
			'reward_energy' => $reward_energy
		);
		$this->db->insert('achievements', $insert);
	}

	public function getAchievements($id)
	{
		$today_midnight = strtotime('today midnight');
		return $this->db->query('SELECT * FROM achievements WHERE id NOT IN (SELECT achievement_id FROM achievement_history WHERE user_id='.$id.' AND claim_time > ' . $today_midnight . ')')->result_array();
	}

	public function checkFaucet($id)
	{
		$today_midnight = strtotime('today midnight');
		$ip_address = $this->input->ip_address();
		$count_claim = $this->db->query('SELECT COUNT(id) AS cnt FROM faucet_history WHERE user_id=' . $id . ' AND claim_time > ' . $today_midnight)->result_array()[0]['cnt'];
		return $count_claim;
	}

	public function checkLink($id)
	{
		$today_midnight = strtotime('today midnight');
		$ip_address = $this->input->ip_address();
		$count_claim = $this->db->query('SELECT COUNT(id) AS cnt FROM link_history WHERE user_id=' . $id . ' AND claim_time > ' . $today_midnight)->result_array()[0]['cnt'];
		return $count_claim;
	}

	public function checkPtc($id)
	{
		$today_midnight = strtotime('today midnight');
		$ip_address = $this->input->ip_address();
		$count_claim = $this->db->query('SELECT COUNT(id) AS cnt FROM ptc_history WHERE user_id=' . $id . ' AND claim_time > ' . $today_midnight)->result_array()[0]['cnt'];
		return $count_claim;
	}

	public function checkLottery($id)
	{
		$today_midnight = strtotime('today midnight');
		$ip_address = $this->input->ip_address();
		$count_claim = $this->db->query('SELECT COUNT(id) AS cnt FROM lotteries WHERE user_id=' . $id . ' AND create_time > ' . $today_midnight)->result_array()[0]['cnt'];
		return $count_claim;
	}

	public function checkHistory($achievementId, $userId)
	{
		$today_midnight = strtotime('today midnight');
		$check = $this->db->query('SELECT COUNT(*) AS cnt FROM achievement_history WHERE user_id=' . $userId . ' AND achievement_id=' . $achievementId . ' AND claim_time > ' . $today_midnight)->result_array()[0]['cnt'];
		return $check == 0;
	}

	public function updateUser($id, $amount, $energy)
	{
		$this->db->where('id', $id);
		$this->db->set('balance', 'balance+' . $amount, FALSE);
		$this->db->set('energy', 'energy+' . $energy, FALSE);
		$this->db->set('total_earned', 'total_earned+' . $amount, FALSE);
		$this->db->set('last_active', time());
		$this->db->update('users');
	}

	public function getAchievementFromId($id)
	{
		$achievement = $this->db->get_where('achievements', array('id' => $id));
		if ($achievement->num_rows() == 0) {
			return false;
		}
		return $achievement->result_array()[0];
	}

	public function insertHistory($userId, $achievementId, $amount)
	{
		$insert = array(
			'achievement_id' => $achievementId,
			'user_id' => $userId,
			'amount' => $amount,
			'claim_time' => time()
		);
		$this->db->insert('achievement_history', $insert);
	}
}
