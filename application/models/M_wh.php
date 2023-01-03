<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Wh extends CI_Model
{

    public function getOfferwalls()
    {
        $oferwalls = $this->db->get('offerwalls')->result_array();
        foreach ($oferwalls as $value) {
            $result[$value['name']] = $value['value'];
        }
        return $result;
    }

    public function getTransaction($transId, $offerwallName)
    {
        $trans = $this->db->get_where('offerwall_history', ['trans_id' => $transId, 'offerwall' => $offerwallName]);
        if ($trans->num_rows() == 0) {
            return false;
        }
        return $trans->result_array()[0];
    }

    public function insertTransaction($userId, $offerwall, $amount, $transId, $status, $availableAt)
    {
        $insert = array(
            'user_id' => $userId,
            'offerwall' => $offerwall,
            'amount' => $amount,
            'trans_id' => $transId,
            'status' => $status,
            'available_at' => $availableAt,
            'claim_time' => time()
        );
        $this->db->insert('offerwall_history', $insert);
    }

    // 0 pending approval, 1 cancelled by advertisers, 2 approved
    public function confirmTransaction($transId)
    {
        $this->db->where('trans_id', $transId);
        $this->db->set('status', 2);
        $this->db->update('offerwall_history');
    }
    public function updateUserBalance($userId, $amount)
    {
        $this->db->where('id', $userId);
        $this->db->set('balance', 'balance+' . $amount, FALSE);
        $this->db->set('total_earned', 'total_earned+' . $amount, FALSE);
        $this->db->set('last_active', time());
        $this->db->update('users');
    }
    public function reduceUserBalance($userId, $amount)
    {
        $this->db->where('id', $userId);
        $this->db->set('balance', 'balance-' . $amount, FALSE);
        $this->db->set('total_earned', 'total_earned-' . $amount, FALSE);
        $this->db->update('users');
    }
}
