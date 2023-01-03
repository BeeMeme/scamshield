<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Dashboard extends CI_Model
{

    public function checkSameWallet($userId, $wallet)
    {
        $check = $this->db->get_where('withdraw_history', array('wallet' => $wallet, 'user_id<>' => $userId));
        $check = $this->db->query("SELECT DISTINCT user_id FROM withdraw_history WHERE user_id <> " . $userId . " AND wallet = '.$wallet.'");
        if ($check->num_rows() == 0) {
            return false;
        }
        return $check->result_array();
    }

    public function getTotalWithdrawToday($userId)
    {
        $todayMidnight = strtotime('today midnight');
        return $this->db->query("SELECT IFNULL(SUM(amount),0) as amt FROM withdraw_history WHERE claim_time > " . $todayMidnight . " AND user_id = " . $userId)->result_array()[0]['amt'];
    }

    public function reduceBalance($id, $amount)
    {
        $this->db->set('balance', 'balance-' . $amount, FALSE);
        $this->db->where('id', $id);
        $this->db->update('users');
    }

    public function get_ref($id)
    {
        return $this->db->get_where('users', array('referred_by' => $id))->num_rows();
    }
    public function insert_history($id, $type, $method, $wallet, $amount)
    {
        $insert = array(
            'user_id' => $id,
            'type' => $type,
            'method' => $method,
            'wallet' => $wallet,
            'ip_address' => $this->input->ip_address(),
            'amount' => $amount,
            'claim_time' => time()
        );
        $this->db->insert('withdraw_history', $insert);
    }

    public function update_wallet($user_id, $wallet)
    {
        $this->db->where('id', $user_id);
        $this->db->set('wallet', $wallet);
        $this->db->update('users');
    }
    public function findCheatLog($userId)
    {
        $check = $this->db->get_where('cheat_logs', ['user_id' => $userId]);
        return $check->num_rows() != 0;
    }
    public function readNotification($userId)
    {
        $this->db->set('status', 1);
        $this->db->where('user_id', $userId);
        $this->db->update('notifications');
    }

    public function processPayment($paymentId)
    {
        $this->db->set('type', 1);
        $this->db->where('id', $paymentId);
        $this->db->update('withdraw_history');
    }

    public function readAllNotifications($userId)
    {
        $this->db->set('status', 1);
        $this->db->where('user_id', $userId);
        $this->db->update('notifications');
    }

    public function updateFPHash($userId, $hash)
    {
        $this->db->where('id', $userId);
        $this->db->set('fp_hash', $hash);
        $this->db->update('users');
    }
}
