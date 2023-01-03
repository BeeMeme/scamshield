<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_page');
	}

	public function index()
	{
		$this->data['all_pages'] = $this->m_page->get_all_pages();
		$this->data['page'] = 'All Pages';
		$this->load->view('user_template/pages', $this->data);
	}

	public function proof()
	{
		$this->data['page'] = 'Payment Proofs';
		$this->db->order_by('id', "desc")->limit(20);
		$this->data['proofs'] = $this->db->get('withdraw_history')->result_array();
		$this->load->view('user_template/proof', $this->data);
	}

	public function maintenance()
	{
		if ($this->data['settings']['status'] != 'off') {
			return redirect(site_url());
		}
		$this->load->view('user_template/maintenance', $this->data);
	}

	public function show($slug)
	{
		$slug = $this->db->escape_str($slug);
		if (!preg_match("/^[a-zA-Z0-9-]+$/", $slug)) {
			show_404();
		} else {
			$this->data['this_page'] = $this->m_page->get_page($slug);
			if ($this->data['this_page']) {
				$this->data['page'] = strip_tags($this->data['this_page']['title']);
				$this->load->view('user_template/page', $this->data);
			} else {
				show_404();
			}
		}
	}
}
