<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_deposit extends CI_Model
{
    public function addDeposit($userId, $amount, $code, $type, $status = 'Creating')
    {
        $insert = array(
            'user_id' => $userId,
            'code' => $code,
            'status' => $status,
            'amount' => $amount,
            'type' => $type,
            'create_time' => time()
        );
        $this->db->insert('deposit', $insert);
    }

    public function getDepositByUser($userId)
    {
        $this->db->limit(10);
        $this->db->order_by('id', 'DESC');
        return $this->db->get_where('deposit', array('user_id' => $userId))->result_array();
    }

    public function deleteDeposit($code)
    {
        $this->db->delete('deposit', array('code' => $code));
    }

    public function updateStatus($code, $status)
    {
        $this->db->where('code', $code);
        $this->db->set('status', $status);
        $this->db->update('deposit');
    }

    public function depositSuccess($code)
    {
        $deposit = $this->getDeposit($code);
        if ($deposit) {
            $this->updateUser($deposit['user_id'], $deposit['amount']);
        }
    }

    private function getDeposit($code)
    {
        $deposit = $this->db->get_where('deposit', array('code' => $code));
        if ($deposit->num_rows() == 0) {
            return false;
        }
        return $deposit->result_array()[0];
    }

    public function updateUser($userId, $amount)
    {
        $this->db->where('id', $userId);
        $this->db->set('dep_balance', 'dep_balance+' . $amount, FALSE);
        $this->db->update('users');
    }
}
