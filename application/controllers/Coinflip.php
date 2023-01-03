<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coinflip extends Member_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->data['settings']['coinflip_status'] != 'on') {
            return redirect(site_url('dashboard'));
        }
        $this->load->helper('string');
        $this->load->model('m_coinflip');
    }
    public function index()
    {
        $this->data['page'] = 'Coin Flip';
        $this->data['history'] = $this->m_coinflip->gethistory($this->data['user']['id']);
        $this->render('coinflip', $this->data);
    }
    public function flip()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('betAmount', 'Amount', 'trim|required|is_numeric');
        $this->form_validation->set_rules('coin', 'Coin', 'trim|required');

        $result = [
            'status' => 'false'
        ];
        if ($this->form_validation->run() == FALSE) {
            $result['status'] = 'false';
            $result['message'] = 'An error has occurred 1';
            echo json_encode($result);
            die();
        }

        $betAmount = $this->db->escape_str($this->input->post('betAmount') * $this->data['settings']['currency_rate']);
        $coin = $this->db->escape_str($this->input->post('coin'));
        if ($betAmount > $this->data['user']['balance'] || $betAmount <= 0) {
            $result['status'] = 'false';
            $result['message'] = 'You don\'t have enough balance';
            echo json_encode($result);
            die();
        }
        if ($coin != 'BTC' && $coin != 'ETH') {
            $result['status'] = 'false';
            $result['message'] = 'An error has occurred';
            echo json_encode($result);
            die();
        }
        if ($betAmount > $this->data['settings']['coinflip_max_bet'] || $betAmount < $this->data['settings']['coinflip_min_bet']) {
            $result['status'] = 'false';
            $result['message'] = "Bets must be between " . currency($this->data['settings']['coinflip_min_bet'], $this->data['settings']['currency_rate']) . " - " . currency($this->data['settings']['coinflip_max_bet'], $this->data['settings']['currency_rate']) . "";
            echo json_encode($result);
            die();
        }

        $result['recent'] = [];
        $result['status'] = 'success';
        $coins = ['BTC', 'ETH'];
        $winAmount = format_money($betAmount * (100 - $this->data['settings']['coinflip_edge']) / 100);
        $coinResult = $coins[mt_rand(1, 100) % 2];
        if ($coinResult == $coin) {
            $result['message'] = 'You Won ' . currency($winAmount, $this->data['settings']['currency_rate']);
            $lastGameId = $this->m_coinflip->insertHistory($this->data['user']['id'], strtoupper($coin), $coinResult, $winAmount, $winAmount);
            $this->m_coinflip->addBalance($this->data['user']['id'], $winAmount);
            $result['profit'] =  currency($winAmount, $this->data['settings']['currency_rate']);
        } else {
            $result['message'] = 'You Lose ' . currency($betAmount, $this->data['settings']['currency_rate']);
            $lastGameId = $this->m_coinflip->insertHistory($this->data['user']['id'], strtoupper($coin), $coinResult, $betAmount, -1 * $betAmount);
            $this->m_coinflip->reduceBalance($this->data['user']['id'], $betAmount);
            $result['profit'] = '-' . currency($betAmount, $this->data['settings']['currency_rate']);
            $result['status'] = 'lost';
        }

        $result['id'] = $lastGameId;
        $result['coin'] = $coin;
        $result['betAmount'] = currency($betAmount, $this->data['settings']['currency_rate']);
        $result['result'] = $coinResult;
        echo json_encode($result);
    }
}
