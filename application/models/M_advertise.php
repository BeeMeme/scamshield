<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_advertise extends CI_Model
{
    public function getOptions()
    {
        return $this->db->get('ptc_option')->result_array();
    }

    public function validOption($id)
    {
        $option = $this->db->get_where('ptc_option', array('id' => $id));

        if ($option->num_rows() == 0) {
            return false;
        }

        return $option->result_array()[0];
    }

    public function add($owner, $name, $description, $reward, $timer, $url, $total_view, $optionId, $status = 'pending')
    {
        $insert = array(
            'owner' => $owner,
            'name' => $name,
            'description' => $description,
            'reward' => $reward,
            'timer' => $timer,
            'url' => $url,
            'total_view' => $total_view,
            'views' => 0,
            'option_id' => $optionId,
            'status' => $status
        );

        $this->db->insert('ptc_ads', $insert);
    }

    public function reduceBalance($userId, $amount)
    {
        $this->db->where('id', $userId);
        $this->db->set('dep_balance', 'dep_balance-' . $amount, FALSE);
        $this->db->update('users');
    }

    public function getAds($userId)
    {
        return $this->db->query("SELECT ptc_ads.*, ptc_option.price FROM ptc_ads, ptc_option WHERE ptc_ads.option_id = ptc_option.id AND ptc_ads.owner = " . $userId)->result_array();
    }

    public function validAds($userId, $adId)
    {
        $ad = $this->db->query("SELECT ptc_ads.*, ptc_option.price FROM ptc_ads, ptc_option WHERE ptc_ads.option_id = ptc_option.id AND ptc_ads.owner = " . $userId . " AND ptc_ads.id = " . $adId);

        if ($ad->num_rows() == 0) {
            return false;
        }

        return $ad->result_array()[0];
    }

    public function pause($id)
    {
        $this->db->where('id', $id);
        $this->db->set('status', 'paused');
        $this->db->update('ptc_ads');
    }

    public function start($id)
    {
        $this->db->where('id', $id);
        $this->db->set('status', 'active');
        $this->db->update('ptc_ads');
    }

    public function delete($id, $owner, $refund)
    {
        $this->db->where('id', $owner);
        $this->db->set('dep_balance', 'dep_balance+' . $refund, FALSE);
        $this->db->update('users');

        $this->db->delete('ptc_ads', array('id' => $id));
    }

    public function addView($adId, $view)
    {
        $this->db->where('id', $adId);
        $this->db->set('total_view', 'total_view+' . $view, FALSE);
        $this->db->update('ptc_ads');
    }

    public function getAdFromId($adId)
    {
        $ad = $this->db->query("SELECT ptc_ads.*, ptc_option.price FROM ptc_ads, ptc_option WHERE ptc_ads.option_id = ptc_option.id AND ptc_ads.id = " . $adId);
        if ($ad->num_rows() == 0) {
            return false;
        }
        return $ad->result_array()[0];
    }
}
