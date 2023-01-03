<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Admin extends CI_Model
{
	public function getStats()
	{
		$this->db->order_by('date', 'desc');
		$date = date("Y-m-d", time() - 86400 * 15);
		$today = date("Y-m-d", time());
		return $this->db->get_where('faucet_stats', ['date>' => $date, 'date<' => $today])->result_array();
	}
	public function shortLinkStatic()
	{
		$data = [];
		$time = strtotime('today midnight');
		for ($i = 0; $i < 7; $i++) {
			$data[$i] = $this->db->query("SELECT links.id, COUNT(link_history.id) AS cnt, SUM(link_history.amount) as amount, links.name FROM links LEFT JOIN link_history ON links.id = link_history.link_id AND link_history.claim_time>" . $time . " AND link_history.claim_time<" . ($time + 86400) . " GROUP BY links.name, links.id")->result_array();
			$time -= 86400;
		}
		return $data;
	}

	public function getTodayStat()
	{
		$check = $this->db->get_where('faucet_stats', ['date' => date("Y-m-d")]);
		if ($check->num_rows() == 0) {
			return false;
		}
		return $check->result_array()[0];
	}

	public function countActiveUsers($today)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM users WHERE last_active >= " . $today)->result_array()[0]['cnt'];
	}

	public function countNewUsers($today)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM users WHERE joined >= " . $today)->result_array()[0]['cnt'];
	}

	public function faucetStat($today)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM faucet_history WHERE claim_time >= " . $today)->result_array()[0];
	}

	public function wheelStat($today)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM wheel_history WHERE claim_time >= " . $today)->result_array()[0];
	}

	public function shortlinkStat($today)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM link_history WHERE claim_time >= " . $today)->result_array()[0];
	}

	public function ptcStat($today)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM ptc_history WHERE claim_time >= " . $today)->result_array()[0];
	}

	public function offerwallStat($today)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM offerwall_history WHERE claim_time >= " . $today)->result_array()[0];
	}

	public function diceStat($today)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(profit), 0) AS amount FROM dice_history WHERE claim_time >= " . $today)->result_array()[0];
	}

	public function coinflipStat($today)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(profit), 0) AS amount FROM coinflip_history WHERE claim_time >= " . $today)->result_array()[0];
	}

	public function achievementStat($today)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM achievement_history WHERE claim_time >= " . $today)->result_array()[0];
	}

	public function depositStat($today)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM deposit WHERE (type = 1 OR (type = 2 AND status = 'Confirmed')) AND create_time >= " . $today)->result_array()[0];
	}

	public function withdrawStat($today)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM withdraw_history WHERE type <> 2 AND claim_time >= " . $today)->result_array()[0];
	}

	public function info()
	{
		$result['totalUser'] = $this->db->query('SELECT COUNT(id) AS cnt FROM users WHERE 1')->result_array()[0]['cnt'];
		$this->db->select_sum('balance');
		$result['totalBalance'] = $this->db->get('users')->row()->balance;
		$today = strtotime('today midnight');
		$result['activeToday'] = $this->db->query('SELECT COUNT(id) AS cnt FROM users WHERE last_active > ' . $today)->result_array()[0]['cnt'];
		$result['registerToday'] = $this->db->query('SELECT COUNT(id) AS cnt FROM users WHERE joined > ' . $today)->result_array()[0]['cnt'];
		$result['pendingWithdrawals'] = $this->db->query("SELECT COUNT(id) AS cnt FROM withdraw_history WHERE type = 0")->result_array()[0]['cnt'];
		return $result;
	}

	public function clear_history()
	{
		$date = date("Y-m-d", time() - 86400 * 15);
		$this->db->delete('faucet_stats', array('date<' => $date));
		$this->db->delete('faucet_history', array('claim_time<' => time() - 86400 * 2));
		$this->db->delete('achievement_history', array('claim_time<' => time() - 86400 * 2));
		$this->db->delete('dice_history', array('claim_time<' => time() - 86400 * 2, 'open' => 0));
		$this->db->delete('link_history', array('claim_time<' => time() - 86400 * 7));
		$this->db->delete('ptc_history', array('claim_time<' => time() - 86400));
		$this->db->delete('offerwall_history', array('claim_time<' => time() - 86400 * 7, 'status' => '2'));
		$this->db->delete('withdraw_history', array('claim_time<' => time() - 86400 * 30, 'type<>' => 0));
		$this->db->delete('deposit', array('create_time<' => time() - 86400 * 7));
		$this->db->delete('notifications', array('create_time<' => time() - 86400 * 3));
		$this->db->delete('ip_addresses', array('last_use<' => time() - 86400 * 3));
	}

	public function count_all_users()
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM users")->result_array()[0]['cnt'];
	}

	public function get_users($skip)
	{
		$this->db->order_by('id', "desc")->limit(50, $skip);
		return $this->db->get('users')->result_array();
	}

	// public function countSuspectedUsers()
	// {
	// 	return $this->db->query("SELECT COUNT(*) AS cnt FROM users WHERE status = 'suspect'")->result_array()[0]['cnt'];
	// }

	// public function getSuspectedUsers($skip)
	// {
	// 	return $this->db->query("SELECT * FROM users WHERE status = 'suspect' ORDER BY id DESC LIMIT 50 OFFSET " . $skip)->result_array();
	// }

	public function get_referrals($id)
	{
		$this->db->order_by('id', "desc");
		return $this->db->get_where('users', array('referred_by' => $id))->result_array();
	}

	public function add_link($name, $url, $reward, $energy, $view)
	{
		$insert = array(
			'name' => $name,
			'url' => $url,
			'reward' => $reward,
			'energy' => $energy,
			'view_per_day' => $view
		);
		$this->db->insert('links', $insert);
	}
	public function update_link($id, $name, $url, $reward, $energy, $view)
	{
		$this->db->where('id', $id);
		$this->db->set('name', $name);
		$this->db->set('url', $url);
		$this->db->set('reward', $reward);
		$this->db->set('energy', $energy);
		$this->db->set('view_per_day', $view);
		$this->db->update('links');
	}

	public function rewardUser($user, $balance, $depBalance, $energy)
	{

		$this->db->where('id', $user);
		$this->db->set('balance', 'balance+' . $balance, FALSE);
		$this->db->set('dep_balance', 'dep_balance+' . $depBalance, FALSE);
		$this->db->set('energy', 'energy+' . $energy, FALSE);
		$this->db->update('users');
	}

	public function get_withdrawal($id)
	{
		$result = $this->db->get_where('withdraw_history', array('id' => $id));
		if (!$result->num_rows()) {
			return false;
		}
		return $result->result_array()[0];
	}
	public function active($id)
	{
		$this->db->where('id', $id);
		$this->db->set('verified', '1');
		$this->db->update('users');
	}

	public function get_banned_users($skip)
	{
		return $this->db->query("SELECT * FROM users WHERE status = 'banned' ORDER BY id DESC LIMIT 50 OFFSET " . $skip)->result_array();
	}

	public function count_banned_users()
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM users WHERE status = 'banned'")->result_array()[0]['cnt'];
	}

	public function deleteBannedUsers()
	{
		$this->db->delete('users', array('status' => 'banned'));
	}

	public function deleteInactiveUsers()
	{
		$this->db->delete('users', array('last_active<' => time() - 30 * 86400));
	}

	public function get_pages($id)
	{
		if (!$id) {
			return $this->db->get('pages')->result_array();
		} else {
			return $this->db->get_where('pages', array('id' => $id))->result_array()[0];
		}
	}

	public function add_page($title, $slug, $priority, $content)
	{
		$insert = array(
			'title' => $title,
			'slug' => $slug,
			'priority' => $priority,
			'content' => $content
		);
		$this->db->insert('pages', $insert);
	}

	public function update_page($id, $title, $slug, $priority, $content)
	{
		$this->db->where('id', $id);
		$this->db->set('title', $title);
		$this->db->set('slug', $slug);
		$this->db->set('priority', $priority);
		$this->db->set('content', $content);
		$this->db->update('pages');
	}

	public function delete_page($id)
	{
		$this->db->delete('pages', array('id' => $id));
	}

	public function getAcceptedAds()
	{
		return $this->db->query("SELECT ptc_ads.*, users.username FROM ptc_ads, users WHERE ptc_ads.owner <> 0 AND (ptc_ads.status = 'active' OR ptc_ads.status = 'paused') AND ptc_ads.owner = users.id ORDER BY id DESC LIMIT 50")->result_array();
	}

	public function countAcceptedAds()
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM ptc_ads WHERE ptc_ads.owner <> 0 AND (ptc_ads.status = 'active' OR ptc_ads.status = 'paused')")->result_array()[0]['cnt'];
	}

	public function getPendingAds()
	{
		return $this->db->query("SELECT ptc_ads.*, users.username FROM ptc_ads, users WHERE ptc_ads.owner <> 0 AND ptc_ads.status = 'pending' AND ptc_ads.owner = users.id ORDER BY id DESC LIMIT 50")->result_array();
	}

	public function countPendingAds()
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM ptc_ads WHERE ptc_ads.owner <> 0 AND ptc_ads.status = 'pending'")->result_array()[0]['cnt'];
	}

	public function getCompletedAds()
	{
		return $this->db->query("SELECT ptc_ads.*, users.username FROM ptc_ads, users WHERE ptc_ads.owner <> 0 AND ptc_ads.status = 'completed' AND ptc_ads.owner = users.id ORDER BY id DESC LIMIT 50")->result_array();
	}

	public function countCompletedAds()
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM ptc_ads WHERE ptc_ads.owner <> 0 AND ptc_ads.status = 'completed'")->result_array()[0]['cnt'];
	}

	public function getAdsByAdmin()
	{
		return $this->db->query("SELECT * FROM ptc_ads WHERE owner = 0 ORDER BY id DESC LIMIT 50")->result_array();
	}

	public function countAdminAds()
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM ptc_ads WHERE ptc_ads.owner = 0")->result_array()[0]['cnt'];
	}

	public function addOption($price, $reward, $timer, $minView)
	{
		$this->db->insert('ptc_option', array(
			'price' => $price,
			'reward' => $reward,
			'timer' => $timer,
			'min_view' => $minView
		));
	}

	public function cheatLogs($userId)
	{
		$this->db->order_by('id', "desc")->limit(100);
		return $this->db->get_where('cheat_logs', ['user_id' => $userId])->result_array();
	}

	public function getSameLogs($id)
	{
		return $this->db->query("SELECT cheat_logs.*, users.username FROM cheat_logs JOIN users ON cheat_logs.user_id = users.id AND (cheat_logs.relate_id = " . $id . " OR cheat_logs.id = " . $id . ")")->result_array();
	}

	public function getCurrency()
	{
		return $this->db->get('currencies')->result_array();
	}

	public function addCurrency($name, $currencyName, $code, $api, $token, $wallet, $price, $accountNumber, $apiId, $minimumWithdrawal)
	{
		$insert = array(
			'name' => $name,
			'currency_name' => $currencyName,
			'code' => $code,
			'api' => $api,
			'token' => $token,
			'wallet' => $wallet,
			'price' => $price,
			'account_number' => $accountNumber,
			'api_id' => $apiId,
			'minimum_withdrawal' => $minimumWithdrawal
		);
		$this->db->insert('currencies', $insert);
	}
	public function updateCurrency($id, $name, $currencyName, $code, $api, $token, $wallet, $price, $accountNumber, $apiId, $minimumWithdrawal, $status)
	{
		$this->db->where('id', $id);
		$this->db->set('name', $name);
		$this->db->set('currency_name', $currencyName);
		$this->db->set('code', $code);
		$this->db->set('api', $api);
		$this->db->set('token', $token);
		$this->db->set('status', $status);
		$this->db->set('wallet', $wallet);
		$this->db->set('price', $price);
		$this->db->set('api_id', $apiId);
		$this->db->set('account_number', $accountNumber);
		$this->db->set('minimum_withdrawal', $minimumWithdrawal);
		$this->db->update('currencies');
	}

	public function get_user($id)
	{
		return $this->db->get_where('users', array('id' => $id))->result_array()[0];
	}

	public function sameIp($ipAddress, $id)
	{
		return $this->db->get_where('users', array('ip_address' => $ipAddress, 'ip_address<>' => 'removed', 'id<>' => $id))->result_array();
	}

	public function getTotalWithdrawals($skip)
	{
		$time = strtotime('today midnight');
		return $this->db->query("SELECT withdraw_history.user_id, SUM(withdraw_history.amount) as amt, users.username, users.id FROM withdraw_history JOIN users ON withdraw_history.user_id = users.id AND withdraw_history.type=1 AND withdraw_history.claim_time > " . $time . " GROUP BY user_id ORDER BY amt DESC LIMIT 50 OFFSET " . $skip)->result_array();
	}
	public function countTotalWithdrawals()
	{
		$time = strtotime('today midnight');
		return $this->db->query("SELECT withdraw_history.user_id, SUM(withdraw_history.amount) as amt, users.email, users.id FROM withdraw_history, users WHERE withdraw_history.user_id = users.id AND withdraw_history.type=1 AND withdraw_history.claim_time > " . $time . " GROUP BY user_id ORDER BY amt DESC")->num_rows();
	}

	public function getTotalWithdrawalsYesterday($skip)
	{
		$time = strtotime('today midnight');
		return $this->db->query("SELECT withdraw_history.user_id, SUM(withdraw_history.amount) as amt, users.username, users.id FROM withdraw_history JOIN users ON withdraw_history.user_id = users.id AND withdraw_history.type=1 AND withdraw_history.claim_time < " . $time . " AND withdraw_history.claim_time > " . ($time - 86400) . " GROUP BY user_id ORDER BY amt DESC LIMIT 50 OFFSET " . $skip)->result_array();
	}
	public function countTotalWithdrawalsYesterday()
	{
		$time = strtotime('today midnight');
		return $this->db->query("SELECT withdraw_history.user_id, SUM(withdraw_history.amount) as amt, users.email, users.id FROM withdraw_history, users WHERE withdraw_history.user_id = users.id AND withdraw_history.type=1 AND withdraw_history.claim_time < " . $time . " AND withdraw_history.claim_time > " . ($time - 86400) . " GROUP BY user_id ORDER BY amt DESC")->num_rows();
	}

	public function getRecentWithdrawals()
	{
		return $this->db->query("SELECT withdraw_history.user_id, withdraw_history.amount as amt, users.username, users.id FROM withdraw_history JOIN users ON withdraw_history.user_id = users.id AND withdraw_history.type=1 ORDER BY withdraw_history.id DESC LIMIT 200")->result_array();
	}

	public function getUserFromId($id)
	{
		$user = $this->db->get_where('users', array('id' => $id));
		return $user->result_array();
	}
	public function getUserFromEmail($email)
	{
		return $this->db->query("SELECT * FROM users WHERE email LIKE '%" . $email . "%'")->result_array();
	}
	public function getUserFromUsername($username)
	{
		return $this->db->query("SELECT * FROM users WHERE username LIKE '%" . $username . "%'")->result_array();
	}
	public function getUserFromIp($ipAddress)
	{
		return $this->db->query(
			"SELECT * FROM users WHERE ip_address = '" . $ipAddress . "' OR id IN
		(
			SELECT user_id FROM ip_addresses WHERE ip_address = '" . $ipAddress . "') ORDER BY id DESC"
		)->result_array();
	}
	public function getPendingOfferwall($skip)
	{
		return $this->db->query("SELECT offerwall_history.*, users.username, users.isocode, users.country, users.id AS user_id FROM offerwall_history, users WHERE offerwall_history.status = 0 AND offerwall_history.user_id = users.id ORDER BY id DESC LIMIT 50 OFFSET " . $skip)->result_array();
	}
	public function countPendingOfferwall()
	{
		return $this->db->query("SELECT COUNT(id) AS cnt FROM offerwall_history WHERE status = 0")->result_array()[0]['cnt'];
	}
	public function getCancelledOfferwall($skip)
	{
		return $this->db->query("SELECT offerwall_history.*, users.username, users.isocode, users.country, users.id AS user_id FROM offerwall_history, users WHERE (offerwall_history.status = 1 OR offerwall_history.amount < 0) AND offerwall_history.user_id = users.id ORDER BY id DESC LIMIT 50 OFFSET " . $skip)->result_array();
	}
	public function countCancelledOfferwall()
	{
		return $this->db->query("SELECT COUNT(id) AS cnt FROM offerwall_history WHERE status = 1")->result_array()[0]['cnt'];
	}
	public function getApprovedOfferwall($skip)
	{
		return $this->db->query("SELECT offerwall_history.*, users.username, users.isocode, users.country, users.id AS user_id FROM offerwall_history, users WHERE offerwall_history.status = 2 AND offerwall_history.user_id = users.id ORDER BY id DESC LIMIT 50 OFFSET " . $skip)->result_array();
	}
	public function countApprovedOfferwall()
	{
		return $this->db->query("SELECT COUNT(id) AS cnt FROM offerwall_history WHERE status = 2")->result_array()[0]['cnt'];
	}
	public function countPendingWithdrawal()
	{
		return $this->db->query("SELECT COUNT(id) AS cnt FROM withdraw_history WHERE type = 0")->result_array()[0]['cnt'];
	}
	public function getPendingWithdrawal()
	{
		return $this->db->query('SELECT withdraw_history.*, users.username, users.status as user_status, currencies.name FROM withdraw_history, users, currencies WHERE withdraw_history.type=0 AND withdraw_history.method=currencies.id AND withdraw_history.user_id = users.id ORDER BY id DESC')->result_array();
	}

	public function countDiceLoose()
	{
		$time = strtotime('today midnight');
		return $this->db->query("SELECT COUNT(id) AS cnt FROM dice_history WHERE profit < 0 AND claim_time > " . $time)->result_array()[0]['cnt'];
	}
	public function countDiceWin()
	{
		$time = strtotime('today midnight');
		return $this->db->query("SELECT COUNT(id) AS cnt FROM dice_history WHERE profit > 0 AND claim_time > " . $time)->result_array()[0]['cnt'];
	}
	public function totalDiceLoose()
	{
		$time = strtotime('today midnight');
		return $this->db->query("SELECT IFNULL(SUM(profit),0) AS amt FROM dice_history WHERE open = 1 AND profit < 0 AND claim_time >" . $time)->result_array()[0]['amt'];
	}
	public function totalDiceWin()
	{
		$time = strtotime('today midnight');
		return $this->db->query("SELECT IFNULL(SUM(profit),0) AS amt FROM dice_history WHERE open = 1 AND profit > 0 AND claim_time >" . $time)->result_array()[0]['amt'];
	}


	public function countFlipLoose()
	{
		$time = strtotime('today midnight');
		return $this->db->query("SELECT COUNT(id) AS cnt FROM coinflip_history WHERE profit < 0 AND claim_time > " . $time)->result_array()[0]['cnt'];
	}
	public function countFlipWin()
	{
		$time = strtotime('today midnight');
		return $this->db->query("SELECT COUNT(id) AS cnt FROM coinflip_history WHERE profit > 0 AND claim_time > " . $time)->result_array()[0]['cnt'];
	}
	public function totalFlipLoose()
	{
		$time = strtotime('today midnight');
		return $this->db->query("SELECT IFNULL(SUM(profit),0) AS amt FROM coinflip_history WHERE profit < 0 AND claim_time >" . $time)->result_array()[0]['amt'];
	}
	public function totalFlipWin()
	{
		$time = strtotime('today midnight');
		return $this->db->query("SELECT IFNULL(SUM(profit),0) AS amt FROM coinflip_history WHERE profit > 0 AND claim_time >" . $time)->result_array()[0]['amt'];
	}
	public function countLottery()
	{
		return $this->db->query("SELECT COUNT(id) AS cnt FROM lotteries")->result_array()[0]['cnt'];
	}
	public function getTodayDeposit()
	{
		$time = strtotime('today midnight');
		return $this->db->query("SELECT deposit.*, users.username FROM deposit, users WHERE deposit.user_id = users.id AND create_time > " . $time . " ORDER BY id DESC")->result_array();
	}
	public function addAuthenticator($secret)
	{
		$this->db->set('value', $secret);
		$this->db->where('name', 'authenticator_code');
		$this->db->update('settings');
	}
	public function updateUser($userId, $email, $username, $ipAddress, $exp, $level, $referredBy, $verified, $status, $wallet, $balance, $depBalance, $energy, $faucetCount, $shortlinkCount, $offerwallCount, $refCount, $totalEarned)
	{
		$this->db->set('email', $email);
		$this->db->set('username', $username);
		$this->db->set('ip_address', $ipAddress);
		$this->db->set('exp', $exp);
		$this->db->set('level', $level);
		$this->db->set('referred_by', $referredBy);
		$this->db->set('verified', $verified);
		$this->db->set('status', $status);
		$this->db->set('wallet', $wallet);
		$this->db->set('balance', $balance);
		$this->db->set('dep_balance', $depBalance);
		$this->db->set('energy', $energy);
		$this->db->set('faucet_count', $faucetCount);
		$this->db->set('shortlink_count', $shortlinkCount);
		$this->db->set('offerwall_count', $offerwallCount);
		$this->db->set('ref_count', $refCount);
		$this->db->set('total_earned', $totalEarned);

		$this->db->where('id', $userId);
		$this->db->update('users');
	}

	public function getUsersByCountry($isocode, $skip, $inactive, $banned)
	{
		$this->db->order_by('id', 'desc')->limit(50, $skip);
		$this->db->select('id, username, email, last_active, balance, ip_address, referred_by, verified, isocode, country');
		if ($inactive) {
			$this->db->where('last_active>', time() - 14 * 86400);
		}
		if ($banned) {
			$this->db->where('status<>', 'banned');
		}
		$this->db->where('isocode', $isocode);
		return $this->db->get('users')->result_array();
	}

	public function countUsersByCountry($isocode, $inactive, $banned)
	{
		$inactiveSql = "";
		if ($inactive) {
			$inactiveSql = " AND last_active>" . (time() - 14 * 86400);
		}
		$bannedSql = "";
		if ($banned) {
			$bannedSql = " AND status<>'banned'";
		}
		return $this->db->query("SELECT COUNT(*) AS cnt FROM users WHERE isocode = '" . $isocode . "'" . $inactiveSql . "" . $bannedSql)->result_array()[0]['cnt'];
	}

	public function denyPayment($paymentId)
	{
		$this->db->set('type', 2);
		$this->db->where('id', $paymentId);
		$this->db->update('withdraw_history');
	}

	public function updateOption($optionId, $price, $reward, $timer, $minView)
	{
		$this->db->set('price', $price);
		$this->db->set('reward', $reward);
		$this->db->set('timer', $timer);
		$this->db->set('min_view', $minView);
		$this->db->where('id', $optionId);
		$this->db->update('ptc_option');
	}

	public function getPendingWithdrawals()
	{
		$this->db->query('SELECT withdraw_history.*, currencies.name FROM withdraw_history, currencies WHERE withdraw_history.type=0 AND withdraw_history.method=currencies.id ORDER BY id DESC')->result_array();
	}

	public function countLotteries($userId)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM lotteries WHERE user_id = " . $userId)->result_array()[0]['cnt'];
	}

	public function countReferrals($userId)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM users WHERE referred_by = " . $userId)->result_array()[0]['cnt'];
	}

	public function getRecentNotifications()
	{
		return $this->db->query("SELECT notifications.*, users.username, users.id AS user_id FROM notifications JOIN users ON notifications.user_id = users.id ORDER BY notifications.id DESC LIMIT 100")->result_array();
	}

	public function getTasks()
	{
		return $this->db->get('tasks')->result_array();
	}

	public function addTask($name, $usdReward, $energyReward, $expReward, $requirement, $description)
	{
		$task = [
			'name' => $name,
			'usd_reward' => $usdReward,
			'energy_reward' => $energyReward,
			'exp_reward' => $expReward,
			'requirement' => $requirement,
			'description' => $description
		];
		$this->db->insert('tasks', $task);
	}

	public function updateTask($id, $name, $usdReward, $energyReward, $expReward, $requirement, $description)
	{
		$this->db->where('id', $id);
		$this->db->set('name', $name);
		$this->db->set('usd_reward', $usdReward);
		$this->db->set('energy_reward', $energyReward);
		$this->db->set('exp_reward', $expReward);
		$this->db->set('requirement', $requirement);
		$this->db->set('description', $description);
		$this->db->update('tasks');
	}

	public function deleteTask($id)
	{
		$this->db->delete('tasks', ['id' => $id]);
		$this->db->delete('task_submission', ['task_id' => $id]);
		$this->db->delete('task_history', ['task_id' => $id]);
	}

	public function getTaskSubmissions()
	{
		return $this->db->query("SELECT COUNT(*) as cnt, id, name FROM (SELECT tasks.name, tasks.id, task_submission.hide FROM task_submission LEFT JOIN tasks ON tasks.id = task_submission.task_id) as tmp WHERE hide = 0 GROUP BY name, id")->result_array();
	}

	public function getSubmissionsByTask($taskId, $skip)
	{
		return $this->db->query("SELECT * FROM (SELECT task_submission.proof, task_submission.claim_time, task_submission.id, tasks.name, users.id AS userId, users.username FROM task_submission JOIN users ON task_submission.user_id = users.id JOIN tasks ON tasks.id = task_submission.task_id AND task_submission.hide = 0 AND tasks.id = " . $taskId . ") as tmpp ORDER BY id ASC LIMIT 50 OFFSET " . $skip)->result_array();
	}

	public function countSubmissionsByTask($taskId)
	{
		return $this->db->query("SELECT COUNT(*) as cnt FROM task_submission WHERE task_submission.hide = 0 AND task_id = " . $taskId)->result_array()[0]['cnt'];
	}
	public function getSubmission($subId)
	{
		$check = $this->db->query("SELECT task_submission.proof, task_submission.user_id, tasks.* FROM task_submission, tasks WHERE task_submission.id = " . $subId . " AND tasks.id = task_submission.task_id");
		if ($check->num_rows() == 0) {
			return false;
		}
		return $check->result_array()[0];
	}
	public function countPendingSubmissions()
	{
		return $this->db->query("SELECT COUNT(*) as cnt FROM task_submission WHERE hide = 0")->result_array()[0]['cnt'];
	}
	public function hideSubmission($id)
	{
		$this->db->where('id', $id);
		$this->db->set('hide', 1);
		$this->db->update('task_submission');
	}
	public function releaseUser($id)
	{
		$this->db->where('id', $id);
		$this->db->where('status<>', 'banned');
		$this->db->set('status', 'active');
		$this->db->set('last_suspect', time());
		$this->db->update('users');
	}
	public function getPrizes()
	{
		return $this->db->get('wheel_prizes')->result_array();
	}
	public function getLogs()
	{
		return $this->db->query("SELECT cheat_logs.*, users.username FROM cheat_logs JOIN users ON cheat_logs.user_id = users.id ORDER BY id DESC LIMIT 30")->result_array();
	}
}
