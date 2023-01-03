<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tasks extends Member_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->data['settings']['tasks_status'] != 'on') {
            return redirect(site_url('dashboard'));
        }
        $this->load->helper('string');
        $this->load->model('m_tasks');
    }
    public function index()
    {
        $this->data['page'] = 'Tasks';
        $this->data['availableTasks'] = $this->m_tasks->getAvailableTasks($this->data['user']['id']);
        $this->data['pendingTasks'] = $this->m_tasks->getPendingTasks($this->data['user']['id']);
        $this->render('tasks', $this->data);
    }

    public function complete($id = 0)
    {
        $this->load->library('form_validation');
        $this->load->helper('security');

        $this->form_validation->set_rules('proof', 'Proof', 'trim|required|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', faucet_alert('danger', validation_errors()));
            return redirect(site_url('/tasks'));
        }

        if (!is_numeric($id) || $id == 0 || $this->m_tasks->isSubmitted($this->data['user']['id'], $id) || $this->m_tasks->isCompleted($this->data['user']['id'], $id)) {
            return redirect(site_url('tasks'));
        }
        $proof = $this->db->escape_str($this->input->post('proof'));
        $this->m_tasks->addSubmission($id, $this->data['user']['id'], $proof);
        $this->session->set_flashdata('message', faucet_alert('success', 'You have uploaded proof successful'));
        redirect(site_url('/tasks'));
    }
}
