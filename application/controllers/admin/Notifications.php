<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifications extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->data['page'] = 'Recent Notifications';
        $this->data['notifications'] = $this->m_admin->getRecentNotifications();

        $this->render('recent_notifications', $this->data);
    }
}
