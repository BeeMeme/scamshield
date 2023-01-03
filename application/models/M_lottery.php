<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Lottery extends CI_Model{
    public function get_lotteries($userId) {
        $this->db->order_by('id', "desc")->limit(10);
        return $this->db->get_where('lotteries', array('user_id' => $userId))->result_array();
    }

    public function get_winners() {
        return $this->db->query("SELECT lottery_winners.*, users.username FROM lottery_winners, users WHERE lottery_winners.user_id = users.id ORDER BY id DESC LIMIT 10")->result_array();
    }

    public function duplicate($number) {
        $find = $this->db->get_where('lotteries', array('numner', $number));
        return ($find->num_rows() == 1);
    }

	public function reduce_energy($id) {
		$this->db->where('id', $id);
		$this->db->set('energy', 'energy-10', FALSE);
		$this->db->update('users');
    }

	public function reduce_balance($id, $amount) {
		$this->db->where('id', $id);
		$this->db->set('balance', 'balance-'.$amount, FALSE);
		$this->db->update('users');
    }

    public function insert_lottery($userId, $number) {
        $insert = array(
            'user_id' => $userId,
            'number' => $number,
            'create_time' => time()
        );

        $this->db->insert('lotteries', $insert);
    }
}