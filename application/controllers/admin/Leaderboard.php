<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leaderboard extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->data['page'] = 'Leaderboard settings';
        $this->render('leaderboard', $this->data);
    }
}
