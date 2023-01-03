<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Links extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->data['page'] = 'Links';
        $this->data['links'] = $this->m_links->get_link_list();
        $this->render('links', $this->data);
    }

    public function add()
    {
        $this->form_validation->set_rules('name', 'Text', 'trim|required|min_length[1]|max_length[20]');
        $this->form_validation->set_rules('url', 'Url', 'trim|required|min_length[1]|max_length[150]');
        $this->form_validation->set_rules('reward', 'Reward', 'trim|required|min_length[1]|max_length[20]');
        $this->form_validation->set_rules('energy', 'Energy', 'trim|required|min_length[1]|max_length[20]');
        $this->form_validation->set_rules('view_per_day', 'View Per Day', 'trim|required|min_length[1]|max_length[20]');

        if ($this->form_validation->run() == FALSE) {
            return redirect(site_url('/admin/links'));
        }
        $name = $this->db->escape_str($this->input->post('name'));
        $url = $this->db->escape_str($this->input->post('url'));
        $reward = $this->db->escape_str($this->input->post('reward'));
        $energy = $this->db->escape_str($this->input->post('energy'));
        $view = $this->db->escape_str($this->input->post('view_per_day'));
        $this->m_admin->add_link($name, $url, $reward, $energy, $view);
        redirect(site_url('/admin/links'));
    }

    public function update($id)
    {
        $this->form_validation->set_rules('name', 'Text', 'trim|required|min_length[1]|max_length[20]');
        $this->form_validation->set_rules('url', 'Url', 'trim|required|min_length[1]|max_length[150]');
        $this->form_validation->set_rules('reward', 'Reward', 'trim|required|min_length[1]|max_length[20]');
        $this->form_validation->set_rules('energy', 'Energy', 'trim|required|min_length[1]|max_length[20]');
        $this->form_validation->set_rules('view_per_day', 'View Per Day', 'trim|required|min_length[1]|max_length[20]');

        if ($this->form_validation->run() == FALSE) {
            return redirect(site_url('/admin/links'));
        }
        $name = $this->db->escape_str($this->input->post('name'));
        $url = $this->db->escape_str($this->input->post('url'));
        $reward = $this->db->escape_str($this->input->post('reward'));
        $energy = $this->db->escape_str($this->input->post('energy'));
        $view = $this->db->escape_str($this->input->post('view_per_day'));
        $this->m_admin->update_link($id, $name, $url, $reward, $energy, $view);
        redirect(site_url('/admin/links'));
    }

    public function delete($id)
    {
        $id = $this->db->escape_str($id);
        $this->db->delete('links', array('id' => $id));
        redirect(site_url('/admin/links'));
    }
}
