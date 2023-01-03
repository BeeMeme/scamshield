<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lottery extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->load->helper('date');
        $this->data['page'] = 'Lottery';

        $this->data['countLottery'] = $this->m_admin->countLottery();
        $this->render('lottery', $this->data);
    }

    public function new_round()
    {
        $this->load->model('m_cronjob');
        $this->m_cronjob->updateLotteryDate(time() + $this->data['settings']['lottery_duration'] * 86400);
        redirect(site_url('/admin/lottery'));
    }
}
