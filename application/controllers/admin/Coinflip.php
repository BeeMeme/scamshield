<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coinflip extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->data['page'] = 'Coin Flip Settings';
        $this->data['countLoose'] = $this->m_admin->countFlipLoose();
        $this->data['countWin'] = $this->m_admin->countFlipWin();
        $this->data['amountLoose'] = $this->m_admin->totalFlipLoose();
        $this->data['amountWin'] = $this->m_admin->totalFlipWin();

        $this->render('flip', $this->data);
    }
}
