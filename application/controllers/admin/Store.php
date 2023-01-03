<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Store extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data['page'] = 'Addons/Templates Store';
        $this->render('store', $this->data);
    }
}
