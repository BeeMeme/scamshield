<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index($id = false)
    {
        $this->data['page'] = 'Pages';
        $this->data['pages'] = $this->m_admin->get_pages($id);
        $this->render('page', $this->data);
    }

    public function edit($id)
    {
        $this->data['page'] = 'Edit Page ' . $id;
        $this->data['this_page'] = $this->m_admin->get_pages($id);
        $this->render('edit_page', $this->data);
    }

    public function add()
    {
        $title = $this->input->post('title');
        $slug = $this->input->post('slug');
        $priority = $this->input->post('priority');
        $content = $this->input->post('content');
        $this->m_admin->add_page($title, $slug, $priority, $content);
        redirect(site_url('/admin/pages'));
    }
    public function delete($id = 0)
    {
        $this->m_admin->delete_page($id);
        redirect(site_url('/admin/pages'));
    }
    public function update()
    {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $slug = $this->input->post('slug');
        $priority = $this->input->post('priority');
        $content = $this->input->post('content');
        $this->m_admin->update_page($id, $title, $slug, $priority, $content);
        redirect(site_url('/admin/pages'));
    }
}
