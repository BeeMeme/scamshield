<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mining extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->load->helper('date');
        $this->data['page'] = 'Mining';
        $this->render('mining', $this->data);
    }
}
