<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Offerwalls extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model(['m_cronjob', 'm_offerwall']);
    }
    public function index()
    {
        $this->data['page'] = 'Offerwall settings';
        $this->render('offerwall', $this->data);
    }

    public function pending()
    {
        $this->data['page'] = 'Pending offerwall';

        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;

        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');

        $this->data['records'] = $this->m_admin->getPendingOfferwall($skip);
        $config['base_url'] = site_url('admin/offerwalls/pending/');
        $config['total_rows'] = $this->m_admin->countPendingOfferwall();

        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->render('offerwall_pending', $this->data);
    }

    public function cancelled()
    {
        $this->data['page'] = 'Cancelled offerwall';

        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;

        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');

        $this->data['records'] = $this->m_admin->getCancelledOfferwall($skip);
        $config['base_url'] = site_url('admin/offerwalls/cancelled/');
        $config['total_rows'] = $this->m_admin->countCancelledOfferwall();

        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->render('offerwall_history', $this->data);
    }

    public function approved()
    {
        $this->data['page'] = 'Approved offerwall';

        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;

        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');

        $this->data['records'] = $this->m_admin->getApprovedOfferwall($skip);
        $config['base_url'] = site_url('admin/offerwalls/approved/');
        $config['total_rows'] = $this->m_admin->countApprovedOfferwall();

        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->render('offerwall_history', $this->data);
    }

    public function accept($id = 0)
    {
        $offer = $this->m_offerwall->getOfferwallFromId($id);
        if ($offer) {
            $this->m_offerwall->updateUserBalance($offer['user_id'], $offer['amount']);
            $this->m_cronjob->updateOfferwallHistoryStatus($offer['id']);
            $this->m_core->addNotification($offer['user_id'], format_money($offer['amount']) . " USD from " . $offer['offerwall'] . " Offerwall was credited to your balance.", 1);

            $user = $this->m_core->get_user_from_id($offer['user_id']);
            $this->m_core->addExp($user['id'], $this->data['settings']['offerwall_exp_reward']);
            $user['exp'] += $this->data['settings']['offerwall_exp_reward'];
            if ($user['exp'] >= ($user['level'] + 1) * 100) {
                $this->m_core->levelUp($user['id']);
            }
        }
        redirect(site_url('admin/offerwalls/pending'));
    }


    public function accept_by_ip($id = 0)
    {
        $offer = $this->m_offerwall->getOfferwallFromId($id);
        $offers = $this->m_offerwall->getOfferwallFromIp($offer['ip_address']);

        foreach ($offers as $of) {
            $this->m_offerwall->updateUserBalance($of['user_id'], $of['amount']);
            $this->m_cronjob->updateOfferwallHistoryStatus($of['id']);
            $this->m_core->addNotification($of['user_id'], format_money($of['amount']) . " USD from " . $of['offerwall'] . " Offerwall was credited to your balance.", 1);

            $user = $this->m_core->get_user_from_id($of['user_id']);
            $this->m_core->addExp($user['id'], $this->data['settings']['offerwall_exp_reward']);
            $user['exp'] += $this->data['settings']['offerwall_exp_reward'];
            if ($user['exp'] >= ($user['level'] + 1) * 100) {
                $this->m_core->levelUp($user['id']);
            }
        }
        redirect(site_url('admin/offerwalls/pending'));
    }

    public function deny($id = 0)
    {
        $offer = $this->m_offerwall->getOfferwallFromId($id);
        $this->m_core->addNotification($offer['user_id'], "Your pending Offerwall #" . $offer['id'] . " was denied.", 2);
        $this->m_offerwall->denyOffer($id);
        redirect(site_url('admin/offerwalls/pending'));
    }

    public function deny_by_ip($id = 0)
    {
        $offer = $this->m_offerwall->getOfferwallFromId($id);
        $offers = $this->m_offerwall->getOfferwallFromIp($offer['ip_address']);
        foreach ($offers as $of) {
            $this->m_offerwall->denyOffer($of['id']);
            $this->m_core->addNotification($of['user_id'], "Your pending Offerwall #" . $of['id'] . " was denied.", 2);
        }
        redirect(site_url('admin/offerwalls/pending'));
    }
}
