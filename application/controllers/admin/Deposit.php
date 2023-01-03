<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Deposit extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->data['page'] = 'Deposit settings';
        $this->render('deposit', $this->data);
    }
}
