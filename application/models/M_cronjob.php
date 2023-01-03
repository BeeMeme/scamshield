<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Cronjob extends CI_Model
{

    public function getAllLottery()
    {
        return $this->db->query("SELECT user_id, number FROM lotteries")->result_array();
    }

    public function updateUserBalance($userId, $amount)
    {
        $this->db->where('id', $userId);
        $this->db->set('balance', 'balance+' . $amount, FALSE);
        $this->db->set('total_earned', 'total_earned+' . $amount, FALSE);
        $this->db->update('users');
    }

    public function insertLotteryHistory($userId, $luckyNumber, $amount)
    {
        $insert = array(
            'user_id' => $userId,
            'number' => $luckyNumber,
            'amount' => $amount,
            'create_time' => time()
        );
        $this->db->insert('lottery_winners', $insert);
    }
    public function updateLotteryDate($newTime)
    {
        $this->db->set('value', $newTime);
        $this->db->where('name', 'lottery_date');
        $this->db->update('settings');
    }
    public function updateBtcPrice($price)
    {
        $this->db->set('value', $price);
        $this->db->where('name', 'btc_price');
        $this->db->update('settings');
    }
    public function updateLeaderboardDate($newTime)
    {
        $this->db->set('value', $newTime);
        $this->db->where('name', 'leaderboard_date');
        $this->db->update('settings');
    }
    public function getCurrencyName()
    {
        return $this->db->query("SELECT DISTINCT currency_name FROM currencies")->result_array();
    }
    public function updatePrice($name, $price)
    {
        $this->db->set('price', $price);
        $this->db->where('currency_name', $name);
        $this->db->update('currencies');
    }
    public function resetLeaderBoard()
    {
        $this->db->set('ref_count', 0);
        $this->db->set('claims', 0);
        $this->db->set('faucet_count_tmp', 0);
        $this->db->set('shortlink_count_tmp', 0);
        $this->db->set('offerwall_count_tmp', 0);
        $this->db->update('users');
    }
    public function resetLottery()
    {
        $this->db->empty_table('lotteries');
    }
    public function getAvailableOffers()
    {
        return $this->db->get_where('offerwall_history', ['status' => 0, 'available_at<' => time()])->result_array();
    }
    public function updateOfferwallHistoryStatus($historyId)
    {
        $this->db->set('status', '2');
        $this->db->set('available_at', time());
        $this->db->where('id', $historyId);
        $this->db->update('offerwall_history');
    }
    public function clearHistory()
    {
        $date = date("Y-m-d", time() - 86400 * 15);
        $this->db->delete('faucet_stats', array('date<' => $date));
        $this->db->delete('faucet_history', array('claim_time<' => time() - 86400 * 2));
        $this->db->delete('other_history', array('claim_time<' => time() - 86400 * 14));
        $this->db->delete('achievement_history', array('claim_time<' => time() - 86400 * 2));
        $this->db->delete('dice_history', array('claim_time<' => time() - 86400 * 2, 'open' => 0));
        $this->db->delete('coinflip_history', array('claim_time<' => time() - 86400 * 2));
        $this->db->delete('link_history', array('claim_time<' => time() - 86400 * 7));
        $this->db->delete('ptc_history', array('claim_time<' => time() - 86400));
        $this->db->delete('offerwall_history', array('claim_time<' => time() - 86400 * 7, 'status' => '2'));
        $this->db->delete('withdraw_history', array('claim_time<' => time() - 86400 * 30));
        $this->db->delete('deposit', array('create_time<' => time() - 86400 * 7));
        $this->db->delete('notifications', array('create_time<' => time() - 86400 * 3));
        $this->db->delete('ip_addresses', array('last_use<' => time() - 86400 * 2));
        $this->db->delete('cheat_logs', array('create_time<' => time() - 86400 * 14));
    }

    public function isYesterdayExist($date)
    {
        $check = $this->db->get_where('faucet_stats', ['date' => $date])->num_rows();
        return $check == 0;
    }

    public function checkYesterdayLog($date)
    {
        $check = $this->db->get_where('faucet_stats', ['date' => $date, 'is_done' => 0])->num_rows();
        return $check == 1;
    }

    public function countActiveUsers($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt FROM users WHERE last_active >= " . $yesterday)->result_array()[0]['cnt'];
    }

    public function countNewUsers($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt FROM users WHERE joined >= " . $yesterday . " AND joined <" . $today)->result_array()[0]['cnt'];
    }

    public function faucetStat($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM faucet_history WHERE claim_time >= " . $yesterday . " AND claim_time <" . $today)->result_array()[0];
    }

    public function shortlinkStat($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM link_history WHERE claim_time >= " . $yesterday . " AND claim_time <" . $today)->result_array()[0];
    }

    public function ptcStat($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM ptc_history WHERE claim_time >= " . $yesterday . " AND claim_time <" . $today)->result_array()[0];
    }

    public function offerwallStat($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM offerwall_history WHERE claim_time >= " . $yesterday . " AND claim_time <" . $today)->result_array()[0];
    }

    public function diceStat($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(profit), 0) AS amount FROM dice_history WHERE claim_time >= " . $yesterday . " AND claim_time <" . $today)->result_array()[0];
    }

    public function coinflipStat($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(profit), 0) AS amount FROM coinflip_history WHERE claim_time >= " . $yesterday . " AND claim_time <" . $today)->result_array()[0];
    }

    public function achievementStat($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM achievement_history WHERE claim_time >= " . $yesterday . " AND claim_time <" . $today)->result_array()[0];
    }

    public function wheelStat($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM wheel_history WHERE claim_time >= " . $yesterday . " AND claim_time <" . $today)->result_array()[0];
    }

    public function depositStat($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM deposit WHERE (type = 1 OR (type = 2 AND status = 'Confirmed')) AND create_time >= " . $yesterday . " AND create_time <" . $today)->result_array()[0];
    }

    public function withdrawStat($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM withdraw_history WHERE type <> 2 AND claim_time >= " . $yesterday . " AND claim_time <" . $today)->result_array()[0];
    }
}
