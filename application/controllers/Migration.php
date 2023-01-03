<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration extends Member_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_migration');
		$this->load->library('form_validation');
		if($this->data['user']['username'] != '') {
			return redirect(site_url('dashboard'));
		}
	}
	public function index()
	{
		$this->data['page'] = 'Migration';

		$this->render('migration', $this->data);
	}

	public function update()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[15]|is_unique[users.username]', array('is_unique' => 'This username already exists'));

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', faucet_alert('danger', validation_errors()));
			return redirect(site_url('migration'));
		}
		$username = $this->db->escape_str($this->input->post('username'));
		$this->m_migration->updateUsername($this->data['user']['id'], $username);
		$this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', 'Your username has been updated'));
		redirect(site_url('dashboard'));
	}
}
