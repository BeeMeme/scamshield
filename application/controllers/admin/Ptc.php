<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ptc extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->data['page'] = 'PTC settings';
        $this->render('ptc', $this->data);
    }
}
