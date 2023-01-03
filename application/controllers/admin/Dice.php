<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dice extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->data['page'] = 'Dice Settings';
        $this->data['countLoose'] = $this->m_admin->countDiceLoose();
        $this->data['countWin'] = $this->m_admin->countDiceWin();
        $this->data['amountLoose'] = $this->m_admin->totalDiceLoose();
        $this->data['amountWin'] = $this->m_admin->totalDiceWin();

        $this->render('dice', $this->data);
    }
}
