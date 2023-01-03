<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Achievements extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('m_achievements');
    }

    public function index()
    {
        $this->data['page'] = 'Achievements Settings';
        $this->data['achievements'] = $this->m_achievements->get();
        $this->render('achievements', $this->data);
    }
    public function add()
    {
        $type = $this->db->escape_str($this->input->post('type'));
        $condition = $this->db->escape_str($this->input->post('condition'));
        $rewardUsd = $this->db->escape_str($this->input->post('reward_usd'));
        $rewardEnergy = $this->db->escape_str($this->input->post('reward_energy'));
        $this->m_achievements->add($type, $condition, $rewardUsd, $rewardEnergy);
        redirect(site_url('admin/achievements'));
    }
    public function edit($id)
    {
        $type = $this->db->escape_str($this->input->post('type'));
        $condition = $this->db->escape_str($this->input->post('condition'));
        $rewardUsd = $this->db->escape_str($this->input->post('reward_usd'));
        $rewardEnergy = $this->db->escape_str($this->input->post('reward_energy'));
        $this->m_achievements->update($id, $type, $condition, $rewardUsd, $rewardEnergy);
        redirect(site_url('admin/achievements'));
    }
    public function delete($id = 0)
    {
        $this->db->delete('achievements', array('id' => $id));
        redirect(site_url('admin/achievements'));
    }
}
