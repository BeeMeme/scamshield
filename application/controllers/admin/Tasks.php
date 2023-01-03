<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tasks extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model(['m_tasks']);
    }

    public function index()
    {
        $this->data['page'] = 'Manage Tasks';
        $this->data['tasks'] = $this->m_admin->getTasks();

        $this->render('tasks', $this->data);
    }

    public function add()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[75]');
        $this->form_validation->set_rules('usd_reward', 'Reward', 'trim|required|min_length[1]|max_length[20]');
        $this->form_validation->set_rules('energy_reward', 'Energy', 'trim|required|min_length[1]|max_length[20]');
        $this->form_validation->set_rules('exp_reward', 'Energy', 'trim|required|min_length[1]|max_length[20]');
        $this->form_validation->set_rules('requirement', 'Requirement', 'trim|required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[1]|max_length[600]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', faucet_alert('danger', validation_errors()));
            return redirect(site_url('/admin/tasks'));
        }
        $name = $this->db->escape_str($this->input->post('name'));
        $usdReward = $this->db->escape_str($this->input->post('usd_reward'));
        $energyReward = $this->db->escape_str($this->input->post('energy_reward'));
        $expReward = $this->db->escape_str($this->input->post('exp_reward'));
        $requirement = $this->db->escape_str($this->input->post('requirement'));
        $description = $this->input->post('description');

        $this->m_admin->addTask($name, $usdReward, $energyReward, $expReward, $requirement, $description);
        redirect(site_url('/admin/tasks'));
    }

    public function update($id = 0)
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[75]');
        $this->form_validation->set_rules('usd_reward', 'Reward', 'trim|required|min_length[1]|max_length[20]');
        $this->form_validation->set_rules('energy_reward', 'Energy', 'trim|required|min_length[1]|max_length[20]');
        $this->form_validation->set_rules('exp_reward', 'Energy', 'trim|required|min_length[1]|max_length[20]');
        $this->form_validation->set_rules('requirement', 'Requirement', 'trim|required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[1]|max_length[600]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', faucet_alert('danger', validation_errors()));
            return redirect(site_url('/admin/tasks'));
        }
        $id = $this->db->escape_str($id);
        $name = $this->db->escape_str($this->input->post('name'));
        $usdReward = $this->db->escape_str($this->input->post('usd_reward'));
        $energyReward = $this->db->escape_str($this->input->post('energy_reward'));
        $expReward = $this->db->escape_str($this->input->post('exp_reward'));
        $requirement = $this->db->escape_str($this->input->post('requirement'));
        $description = $this->input->post('description');

        $this->m_admin->updateTask($id, $name, $usdReward, $energyReward, $expReward, $requirement, $description);
        redirect(site_url('/admin/tasks'));
    }

    public function delete($id = 0)
    {
        $this->m_admin->deleteTask($id);
        redirect(site_url('/admin/tasks'));
    }

    public function hide($id = 0)
    {
        $submission = $this->m_admin->getSubmission($id);
        if (!$submission) {
            return redirect(site_url('admin/tasks'));
        }
        $this->m_admin->hideSubmission($id);
        $this->m_core->addNotification($submission['user_id'], 'Your proof for task <b>' . $submission['name'] . '</b> was denied.', 2);
        redirect(site_url('admin/tasks/submissions/' . $submission['id']));
    }

    public function submissions($id = 0)
    {
        $this->data['page'] = 'Task Submissions';
        $this->data['taskId'] = $id;
        $this->data['tasks'] = $this->m_admin->getTaskSubmissions();
        $this->data['submissions'] = [];
        $this->data['pagination'] = '';
        if ($id != 0) {
            $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;

            $this->load->library('pagination');
            $this->load->config('pagination');
            $config = $this->config->item('pagination_config');

            $this->data['submissions'] = $this->m_admin->getSubmissionsByTask($id, $skip);
            $config['base_url'] = site_url('admin/tasks/submissions/' . $id);
            $config['total_rows'] = $this->m_admin->countSubmissionsByTask($id);

            $config['page_query_string'] = TRUE;
            $this->pagination->initialize($config);
            $this->data['pagination'] = $this->pagination->create_links();
        }
        $this->render('submissions', $this->data);
    }

    public function accept($id)
    {
        $submission = $this->m_admin->getSubmission($id);
        if (!$submission) {
            return redirect(site_url('admin/tasks'));
        }
        $this->m_tasks->deleteSubmission($id);
        $this->m_tasks->insertHistory($submission['user_id'], $submission['id'], $submission['usd_reward']);

        $user = $this->m_core->get_user_from_id($submission['user_id']);
        $this->m_tasks->updateUser($user['id'], $submission['usd_reward'], $submission['energy_reward']);
        $this->m_core->addOtherLog($user['id'], 'Task', $submission['usd_reward']);
        $this->m_core->addExp($user['id'], $submission['exp_reward']);
        $user['exp'] += $submission['exp_reward'];
        if ($user['exp'] >= ($user['level'] + 1) * 100) {
            $this->m_core->levelUp($user['id']);
        }
        $this->m_core->addNotification($submission['user_id'], currency($submission['usd_reward'], $this->data['settings']['currency_rate']) . ' has been credited to your balance from task <b>' . $submission['name'] . '</b>', 1);
        return redirect(site_url('admin/tasks/submissions/' . $submission['id']));
    }

    public function deny($id)
    {
        $submission = $this->m_admin->getSubmission($id);
        if (!$submission) {
            return redirect(site_url('admin/tasks'));
        }
        $this->m_tasks->deleteSubmission($id);
        $this->m_core->addNotification($submission['user_id'], 'Your proof for task <b>' . $submission['name'] . '</b> was denied.', 2);
        return redirect(site_url('admin/tasks/submissions/' . $submission['id']));
    }
}
