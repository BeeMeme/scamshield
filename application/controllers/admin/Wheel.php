<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wheel extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->data['page'] = 'Wheel';
        $this->data['prizes'] = $this->m_admin->getPrizes();
        $this->render('wheel', $this->data);
    }

    public function add()
    {
        $this->form_validation->set_rules('text', 'Text', 'trim|required|min_length[1]|max_length[10]');
        $this->form_validation->set_rules('color', 'Url', 'trim|required|min_length[1]|max_length[10]');
        $this->form_validation->set_rules('usd_reward', 'USD Reward', 'trim|required|is_numeric|greater_than[0]');
        $this->form_validation->set_rules('exp_reward', 'EXP Reward', 'trim|required|is_numeric|greater_than[0]');
        $this->form_validation->set_rules('probability', 'Probability', 'trim|required|is_numeric|greater_than[0]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', faucet_alert('danger', validation_errors()));
            return redirect(site_url('/admin/wheel'));
        }
        $text = $this->db->escape_str($this->input->post('text'));
        $color = $this->db->escape_str($this->input->post('color'));
        $usdReward = $this->db->escape_str($this->input->post('usd_reward'));
        $expReward = $this->db->escape_str($this->input->post('exp_reward'));
        $probability = $this->db->escape_str($this->input->post('probability'));
        $this->m_admin->addPrize($text, $color, $usdReward, $expReward, $probability);
        redirect(site_url('/admin/wheel'));
    }

    public function update($id)
    {
        $this->form_validation->set_rules('text', 'Text', 'trim|required|min_length[1]|max_length[10]');
        $this->form_validation->set_rules('color', 'Url', 'trim|required|min_length[1]|max_length[10]');
        $this->form_validation->set_rules('usd_reward', 'USD Reward', 'trim|required|is_numeric|greater_than[0]');
        $this->form_validation->set_rules('exp_reward', 'EXP Reward', 'trim|required|is_numeric|greater_than[0]');
        $this->form_validation->set_rules('probability', 'Probability', 'trim|required|is_numeric|greater_than[0]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', faucet_alert('danger', validation_errors()));
            return redirect(site_url('/admin/wheel'));
        }
        $text = $this->db->escape_str($this->input->post('text'));
        $color = $this->db->escape_str($this->input->post('color'));
        $usdReward = $this->db->escape_str($this->input->post('usd_reward'));
        $expReward = $this->db->escape_str($this->input->post('exp_reward'));
        $probability = $this->db->escape_str($this->input->post('probability'));
        $this->m_wheel->updatePrize($id, $text, $color, $usdReward, $expReward, $probability);
        redirect(site_url('/admin/wheel'));
    }

    public function delete($id)
    {
        $id = $this->db->escape_str($id);
        $this->db->delete('wheel_prizes', array('id' => $id));
        redirect(site_url('/admin/wheel'));
    }
}
