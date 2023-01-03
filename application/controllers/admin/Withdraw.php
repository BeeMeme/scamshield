<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Withdraw extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function today()
    {
        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;

        $this->data['page'] = 'Withdraw today';

        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');

        $this->data['history'] = $this->m_admin->getTotalWithdrawals($skip);
        $config['base_url'] = site_url('admin/withdraw/today/');
        $config['total_rows'] = $this->m_admin->countTotalWithdrawals();

        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->render('withdraw_history', $this->data);
    }

    public function yesterday()
    {
        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;

        $this->data['page'] = 'Yesterday withdrawals';

        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');

        $this->data['history'] = $this->m_admin->getTotalWithdrawalsYesterday($skip);
        $config['base_url'] = site_url('admin/withdraw/yesterday/');
        $config['total_rows'] = $this->m_admin->countTotalWithdrawalsYesterday();

        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->render('withdraw_history', $this->data);
    }

    public function recent()
    {
        $this->data['page'] = 'Recent withdrawals';
        $this->data['history'] = $this->m_admin->getRecentWithdrawals();
        $this->data['pagination'] = '';
        $this->render('withdraw_history', $this->data);
    }

    public function pending()
    {
        $this->data['page'] = 'Pending Withdrawals';
        $this->data['pendingWithdrawal'] = $this->m_admin->getPendingWithdrawal();
        $this->render('withdrawals', $this->data);
    }

    public function accept($id)
    {
        $this->load->model('m_dashboard');
        $id = $this->db->escape_str($id);
        $data = $this->m_admin->get_withdrawal($id);
        $method = $this->m_core->getCurrency($data['method']);
        $amount = $data['amount'];
        $coinAmount = number_format($amount / $method['price'], 8);
        $satoshiAmount = floor($amount * 100000000 / $method['price']);

        if ($method['wallet'] == 'faucetpay') {
            $result = faucetpay($data['wallet'], $data['ip_address'], $satoshiAmount, $method['api'], $method['code'], $referral = false);
            if ($result["status"] == 200) {
                $this->m_dashboard->processPayment($id);
                $this->session->set_flashdata('message', faucet_alert('success', $coinAmount . ' ' . $method['code'] . ' has been sent to ' . $data['wallet']));
                $this->m_core->addNotification($data['user_id'], "Your pending withdrawal #" . $id . " was processed.", 1);
            } else {
                $this->session->set_flashdata('message', faucet_alert('warning', $result['message']));
            }
        } else if ($method['wallet'] == 'expresscrypto') {
            include APPPATH . 'third_party/expresscrypto.php';
            $expresscrypto = new ExpressCryptoV2($method['api'], $method['token'], $data['ip_address']);
            $result = $expresscrypto->sendPayment($data['wallet'], $method['code'], $satoshiAmount);
            if ($result["status"] == 200) {
                $this->m_dashboard->processPayment($id);
                $this->session->set_flashdata('message', faucet_alert('success', $coinAmount . ' ' . $method['code'] . ' has been sent to ' . $data['wallet']));
                $this->m_core->addNotification($data['user_id'], "Your pending withdrawal #" . $id . " was processed.", 1);
            } else {
                $this->session->set_flashdata('message', faucet_alert('warning', $result['message']));
            }
        } else if ($method['wallet'] == 'payeer') {
            include APPPATH . 'third_party/payeer.php';
            $payeer = new CPayeer($method['account_number'], $method['api_id'], $method['api']);
            if ($payeer->isAuth()) {
                $arTransfer = $payeer->transfer(array(
                    'curIn' => 'USD',
                    'sum' => $amount,
                    'curOut' => $method['code'],
                    //'sumOut' => 1,
                    'to' => $data['wallet'],
                    'comment' => 'Payment from' . $this->data['settings']['name']
                ));
                if (empty($arTransfer['errors'])) {
                    $this->m_dashboard->processPayment($id);
                    $this->session->set_flashdata('message', faucet_alert('success', $coinAmount . ' ' . $method['code'] . ' has been sent to ' . $data['wallet']));
                    $this->m_core->addNotification($data['user_id'], "Your pending withdrawal #" . $id . " was processed.", 1);
                } else {
                    $this->session->set_flashdata('withdraw_message', faucet_alert('warning', 'Error! Please try again (' . $arTransfer["errors"][0] . ')'));
                }
            } else {
                $this->session->set_flashdata('withdraw_message', faucet_alert('warning', 'Error! Please try again (' . $payeer->getErrors()[0] . ')'));
            }
        } else if ($method['wallet'] == 'custom') {
            $this->m_dashboard->processPayment($id);
            $this->m_core->addNotification($data['user_id'], "Your pending withdrawal #" . $id . " was processed.", 1);
            $this->session->set_flashdata('message', faucet_alert('success', 'Done'));
        }
        return redirect(site_url('/admin/withdraw/pending'));
    }

    public function deny($id)
    {
        $this->load->model('m_dashboard');
        $data = $this->m_admin->get_withdrawal($id);
        $this->m_admin->rewardUser($data['user_id'], $data['amount'], 0, 0);
        $this->m_admin->denyPayment($id);
        $this->m_core->addNotification($data['user_id'], "Your pending withdrawal #" . $id . " was denied.", 2);
        return redirect(site_url('/admin/withdraw/pending'));
    }
}
