<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Core extends CI_Model
{
	public function getSettings()
	{
		$settings = $this->db->get('settings')->result_array();
		foreach ($settings as $value) {
			$result[$value['name']] = $value['value'];
		}
		return $result;
	}
	public function countLinkHistory($user_id)
	{
		$past = time() - 86400;
		$ip_address = $this->input->ip_address();
		return $this->db->query("SELECT COUNT(link_id) as cnt FROM link_history WHERE claim_time>$past AND (ip_address='$ip_address' OR user_id=$user_id)")->result_array()[0]['cnt'];
	}
	public function countAllLinksView()
	{
		return $this->db->query("SELECT IFNULL(SUM(view_per_day), 0) as cnt FROM links")->result_array()[0]['cnt'];
	}
	public function countAvailableAds($user_id)
	{
		$past = time() - 86400;
		$ip_address = $this->input->ip_address();
		return $this->db->query("SELECT COUNT(*) AS cnt FROM ptc_ads WHERE views < total_view AND status = 'active' AND id NOT IN (SELECT ad_id FROM ptc_history WHERE claim_time>$past AND (ip_address='$ip_address' OR user_id=$user_id))")->result_array()[0]['cnt'];
	}
	public function countAvailableTasks($user_id)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM tasks WHERE id NOT IN (SELECT task_id FROM task_history WHERE user_id = " . $user_id . ") AND id NOT IN (SELECT task_id FROM task_submission WHERE user_id = " . $user_id . ")")->result_array()[0]['cnt'];
	}
	public function get_user_from_id($id)
	{
		$user = $this->db->get_where('users', array('id' => $id));
		if ($user->num_rows() == 0) {
			return false;
		}
		return $user->result_array()[0];
	}
	public function get_user_from_email($email)
	{
		$user = $this->db->get_where('users', array('email' => $email));
		if ($user->num_rows() == 0) {
			return false;
		}
		return $user->result_array()[0];
	}

	public function update_referral($id, $amount)
	{
		$this->db->where('id', $id);
		$this->db->set('balance', 'balance+' . $amount, FALSE);
		$this->db->set('total_earned', 'total_earned+' . $amount, FALSE);
		$this->db->update('users');
	}

	public function lastActive($userId)
	{
		$user = $this->db->query("SELECT last_active FROM users WHERE id = " . $userId);
		if ($user->num_rows() == 0) {
			return 0;
		}
		return $user->result_array()[0]['last_active'];
	}

	public function updateIsocode($id, $isocode, $country)
	{
		$this->db->where('id', $id);
		$this->db->set('isocode', $isocode);
		$this->db->set('country', $country);
		$this->db->update('users');
	}

	public function ban($id, $reason)
	{
		$this->db->where('id', $id);
		$this->db->set('status', $reason);
		$this->db->update('users');
	}
	public function banIp($ip, $reason)
	{
		$this->db->where('ip_address', $ip);
		$this->db->set('status', $reason);
		$this->db->update('users');
	}

	public function claim_fail($id, $status)
	{
		if (is_numeric($status)) {
			if ($status >= 4) {
				$this->db->set('status', 'Cheating');
			} else {
				$this->db->set('status', $status + 1);
			}
			$this->db->where('id', $id);
			$this->db->update('users');
		}
	}

	public function newIp()
	{
		$ipAddress = $this->input->ip_address();
		$check = $this->db->query("SELECT COUNT(*) as cnt FROM ip_addresses WHERE ip_address='" . $ipAddress . "'")->result_array()[0]['cnt'];
		return ($check == 0);
	}

	public function newIpUser($userId)
	{
		$ipAddress = $this->input->ip_address();
		$check = $this->db->query("SELECT COUNT(*) as cnt FROM ip_addresses WHERE ip_address='" . $ipAddress . "' AND user_id = " . $userId)->result_array()[0]['cnt'];
		return ($check == 0);
	}

	public function insertNewIp($userId)
	{
		$sub = '';
		$ip = $this->input->ip_address();
		if (strlen($ip) < 20) {
			$splited = explode('.', $ip);
			$sub = $splited[0] . '.' . $splited[1] . '.' . $splited[2];
		} else {
			$splited = explode(':', $ip);
			$sub = $splited[0] . ':' . $splited[1] . ':' . $splited[2] . ':' . $splited[3];
		}
		$insert = [
			'user_id' => $userId,
			'ip_address' => $this->input->ip_address(),
			'last_use' => time(),
			'sub' => $sub
		];
		$this->db->insert('ip_addresses', $insert);
	}

	public function updateIpLastUse($userId)
	{
		$this->db->set('last_use', time());
		$this->db->where('user_id', $userId);
		$this->db->where('ip_address', $this->input->ip_address());
		$this->db->update('ip_addresses');
	}

	public function getPages()
	{
		return $this->db->query("SELECT title, slug FROM pages WHERE priority <> 0 ORDER BY priority DESC")->result_array();
	}

	public function getCurrency($id)
	{
		$currency = $this->db->get_where('currencies', array('id' => $id));
		if ($currency->num_rows() == 0) {
			return false;
		}
		return $currency->result_array()[0];
	}

	public function insertCheatLog($userId, $log, $ipAddress = false)
	{
		if (!$ipAddress) {
			$ipAddress = $this->input->ip_address();
		}
		$insert = [
			'user_id' => $userId,
			'log' => $log,
			'ip_address' => $ipAddress,
			'create_time' => time()
		];
		$this->db->insert('cheat_logs', $insert);
		return $this->db->insert_id();
	}
	public function addExp($userId, $amount)
	{
		$this->db->set('exp', 'exp+' . $amount, FALSE);
		$this->db->set('claims', 'claims+' . $amount, FALSE);
		$this->db->where('id', $userId);
		$this->db->update('users');
	}
	public function levelUp($userId)
	{
		$this->db->set('level', 'level+1', FALSE);
		$this->db->where('id', $userId);
		$this->db->update('users');
	}
	public function countLottery()
	{
		return $this->db->query("SELECT COUNT(*) as cnt FROM lotteries")->result_array()[0]['cnt'];
	}
	public function getCurrencies()
	{
		return $this->db->get('currencies')->result_array();
	}
	public function firewallLock($userId)
	{
		$this->db->set('status', 'firewall');
		$this->db->where('id', $userId);
		$this->db->update('users');
	}
	public function unlockFirewall($userId)
	{
		$this->db->set('status', 'ok');
		$this->db->set('last_firewall', time());
		$this->db->where('id', $userId);
		$this->db->update('users');
	}
	public function wrongCaptcha($userId)
	{
		$this->db->set('fail', 'fail+1', FALSE);
		$this->db->where('id', $userId);
		$this->db->update('users');
	}
	public function resetFail($userId)
	{
		$this->db->set('fail', '0');
		$this->db->where('id', $userId);
		$this->db->update('users');
	}
	public function addNotification($userId, $content, $type)
	{
		$insert = [
			'user_id' => $userId,
			'content' => $content,
			'type' => $type,
			'create_time' => time()
		];
		$this->db->insert('notifications', $insert);
	}
	public function getNotifications($userId)
	{
		$this->db->order_by('id', 'desc')->limit(20);
		return $this->db->get_where('notifications', ['user_id' => $userId])->result_array();
	}
	public function countUnreadNotifications($userId)
	{
		return $this->db->query("SELECT COUNT(*) as cnt FROM notifications WHERE status = 0 AND user_id = " . $userId)->result_array()[0]['cnt'];
	}
	public function updateStatus($id, $status)
	{
		if ($status == 'suspect') {
			$this->db->where(['last_suspect<' => time() - 86400 * 5, 'id' => $id]);
		} else {
			$this->db->where('id', $id);
		}
		$this->db->where('status<>', 'banned');
		$this->db->set('status', $status);
		$this->db->update('users');

		if ($status == 'banned') {
			$this->db->delete('withdraw_history', ['type' => 0, 'user_id' => $id]);
		}
	}
	public function addOtherLog($userId, $name, $amount)
	{
		$insert = [
			'user_id' => $userId,
			'name' => $name,
			'amount' => $amount,
			'claim_time' => time()
		];
		$this->db->insert('other_history', $insert);
	}
}
