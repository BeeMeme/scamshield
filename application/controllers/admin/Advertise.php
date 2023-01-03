<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Advertise extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model(['m_advertise', 'm_ptc']);
    }

    public function index()
    {
        $this->data['page'] = 'Create campaign';
        $this->data['options'] = $this->m_advertise->getOptions();

        $this->render('advertise', $this->data);
    }

    public function accepted()
    {
        $this->data['page'] = 'Manage Accepted PTC Ads';

        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;

        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');

        $this->data['ads'] = $this->m_admin->getAcceptedAds($skip);
        $config['base_url'] = site_url('admin/advertise/accepted/');
        $config['total_rows'] = $this->m_admin->countAcceptedAds();

        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        $this->render('advertise_manage', $this->data);
    }

    public function pending()
    {
        $this->data['totalPendingAds'] = $this->m_admin->countPendingAds();
        $this->data['page'] = 'Manage Pending PTC Ads';

        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;

        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');

        $this->data['ads'] = $this->m_admin->getPendingAds($skip);
        $config['base_url'] = site_url('admin/advertise/accepted/');
        $config['total_rows'] = $this->data['totalPendingAds'];

        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        $this->render('advertise_manage', $this->data);
    }

    public function completed()
    {
        $this->data['page'] = 'Manage Completed PTC Ads';

        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;

        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');

        $this->data['ads'] = $this->m_admin->getCompletedAds($skip);
        $config['base_url'] = site_url('admin/advertise/accepted/');
        $config['total_rows'] = $this->m_admin->countCompletedAds();

        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        $this->render('advertise_manage', $this->data);
    }

    public function admin()
    {
        $this->data['page'] = 'Manage PTC ads created by admin';

        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;

        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');

        $this->data['ads'] = $this->m_admin->getAdsByAdmin($skip);
        $config['base_url'] = site_url('admin/advertise/accepted/');
        $config['total_rows'] = $this->m_admin->countAdminAds();

        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        $this->render('advertise_manage', $this->data);
    }

    public function pause($id = 0)
    {
        $this->m_advertise->pause($id);
        return redirect(site_url('/admin/advertise/accepted'));
    }

    public function start($id = 0)
    {
        $this->m_advertise->start($id);
        $ad = $this->m_ptc->get_ads_from_id($id);
        $this->m_core->addNotification($ad['owner'], "Your PTC campaign #" . $id . " was accepted.", 0);
        return redirect(site_url('/admin/advertise/pending'));
    }
    public function delete($id = 0)
    {
        $ad = $this->m_ptc->get_ads_from_id($id);
        $refund = ($ad['total_view'] - $ad['views']) * $ad['reward'];
        $this->m_advertise->delete($id, $ad['owner'], $refund);
        return redirect(site_url('/admin/advertise/accepted'));
    }

    // manage ptc options
    public function options()
    {
        $this->data['page'] = 'Advertise Options';
        $this->data['options'] = $this->m_advertise->getOptions();

        $this->render('advertise_options', $this->data);
    }

    public function option_add()
    {
        $timer = $this->input->post('timer');
        $price = $this->input->post('price');
        $reward = $this->input->post('reward');
        $minView = $this->input->post('min_view');

        $this->m_admin->addOption($price, $reward, $timer, $minView);
        return redirect(site_url('admin/advertise/options'));
    }

    public function option_update($id)
    {
        $timer = $this->input->post('timer');
        $price = $this->input->post('price');
        $reward = $this->input->post('reward');
        $minView = $this->input->post('min_view');

        $this->m_admin->updateOption($id, $price, $reward, $timer, $minView);
        return redirect(site_url('admin/advertise/options'));
    }

    public function option_delete($id)
    {

        $this->db->delete('ptc_option', array('id' => $id));
        return redirect(site_url('admin/advertise/options'));
    }

    public function create()
    {
        $this->load->helper('security');

        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[75]|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[0]|max_length[75]|xss_clean');
        $this->form_validation->set_rules('url', 'Url', 'trim|required|min_length[10]|max_length[100]|valid_url|xss_clean');
        $this->form_validation->set_rules('view', 'View', 'trim|required|greater_than[0]|integer');
        $this->form_validation->set_rules('option', 'Option', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', faucet_alert('danger', validation_errors()));
            return redirect(site_url('/advertise'));
        }

        $name = strip_tags($this->db->escape_str($this->input->post('name')));
        $description = strip_tags($this->db->escape_str($this->input->post('description')));
        $url = $this->db->escape_str($this->input->post('url'));
        $view = $this->db->escape_str($this->input->post('view'));
        $option = $this->db->escape_str($this->input->post('option'));

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Url'));
            return redirect(site_url('/advertise'));
        }

        $getOption = $this->m_advertise->validOption($option);
        if (!$getOption) {
            $this->session->set_flashdata('message', faucet_alert('danger', '??? :D ???'));
            return redirect(site_url('/advertise'));
        }

        $this->m_advertise->add(0, $name, $description, $getOption['reward'], $getOption['timer'], $url, $view, $option, 'active');

        redirect(site_url('admin/advertise/accepted'));
    }

    public function add_view($adId)
    {
        if (!is_numeric($adId)) {
            return redirect(site_url('/advertise/manage'));
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('view', 'View', 'trim|required|greater_than[0]|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', faucet_alert('danger', validation_errors()));
            return redirect(site_url('/admin/advertise/accepted'));
        }
        $view = $this->db->escape_str($this->input->post('view'));
        $ad = $this->m_advertise->getAdFromId($adId);
        if (!$ad) {
            return redirect(site_url('/admin/advertise/accepted'));
        }

        $this->m_advertise->addView($adId, $view);
        $this->session->set_flashdata('message', faucet_sweet_alert('success', 'You have added views to campaign #' . $adId . ' successful.'));
        return redirect(site_url('/admin/advertise/accepted'));
    }
}
