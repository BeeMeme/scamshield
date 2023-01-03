<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Update extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index($from)
    {
        $setting = [
            'status', 'name', 'description', 'site_email', 'minimum_deposit', 'instant_withdraw', 'timer', 'reward', 'daily_limit', 'coinbase_api',
            'coinbase_secret', 'rate', 'referral', 'iphub', 'proxycheck', 'antibotlinks', 'footer_code', 'username', 'password', 'login_captcha',
            'register_captcha', 'faucet_captcha', 'ptc_captcha', 'recaptcha_v3_site_key', 'recaptcha_v3_secret_key', 'recaptcha_v2_site_key',
            'recaptcha_v2_secret_key', 'c_key', 'v_key', 'h_key', 'hcaptcha_site_key', 'hcaptcha_secret_key', 'lottery_base_reward', 'lottery_price',
            'lottery_reward', 'lottery_date', 'autofaucet_timer', 'autofaucet_reward', 'autofaucet_cost', 'login_ad', 'register_ad', 'dashboard_top_ad',
            'dashboard_header_ad', 'dashboard_bottom_ad', 'achievements_top_ad', 'achievements_footer_ad', 'faucet_top_ad', 'faucet_header_ad', 'faucet_left_ad',
            'faucet_right_ad', 'faucet_bottom_ad', 'faucet_footer_ad', 'autofaucet_top_ad', 'links_top_ad', 'links_footer_ad', 'ptc_top_ad', 'ptc_footer_ad',
            'lottery_top_ad', 'lottery_bottom_ad', 'lottery_left_ad', 'lottery_right_ad', 'lottery_duration', 'achievement_exp_reward', 'autofaucet_exp_reward',
            'faucet_exp_reward', 'shortlink_exp_reward', 'ptc_exp_reward', 'lottery_exp_reward', 'offerwall_exp_reward', 'achievement_status', 'faucet_status',
            'autofaucet_status', 'shortlink_status', 'ptc_status', 'lottery_status', 'offerwall_status', 'dice_status', 'max_bet', 'min_bet', 'house_edge',
            'cpalead_status', 'wannads_status', 'offertoro_status', 'cpx_status', 'offerwall_min_level', 'offerwall_exp', 'wannads_api_key', 'wannads_secret_key',
            'wannads_hold', 'offertoro_pub_id', 'offertoro_app_id', 'offertoro_app_secret', 'offertoro_hold', 'cpx_app_id', 'cpx_hash', 'cpx_hold', 'faucetpay_username',
            'faucetpay_currency', 'mail_service', 'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password', 'withdraw_limit', 'admin_email',
            'activity_contest_reward', 'referral_contest_reward', 'faucet_contest_reward', 'shortlink_contest_reward', 'offerwall_contest_reward', 'firewall',
            'ayetstudios_status', 'ayetstudios_id', 'ayetstudios_api', 'ayetstudios_hold', 'offerdaddy_status', 'offerdaddy_hold', 'offerdaddy_app_key', 'offerdaddy_app_token',
            'personaly_status',  'personaly_hold', 'personaly_id', 'personaly_hash', 'personaly_secret_key', 'banned_mails', 'global_notification', 'captcha_fail_limit',
            'admin_username', 'pollfish_status', 'pollfish_hold', 'pollfish_api', 'pollfish_secret', 'bitswall_status', 'bitswall_hold', 'bitswall_api', 'bitswall_secret', 'theme', 'home_page',
            'tasks_status', 'tasks_top_ad', 'tasks_footer_ad', 'coinflip_status', 'coinflip_edge', 'coinflip_top_ad', 'coinflip_footer_ad',
            'coinflip_max_bet', 'coinflip_min_bet', 'faucetpay_deposit_status', 'coinbase_deposit_status', 'payeer_status', 'payeer_id', 'payeer_secret',
            'payeer_min_deposit', 'coinbase_min_deposit', 'faucetpay_min_deposit', 'level_bonus', 'max_bonus', 'currency_name', 'currency_rate',
            'wheel_status', 'wheel_energy', 'wheel_timer', 'wheel_limit', 'wheel_top_ad', 'wheel_header_ad', 'wheel_left_ad', 'wheel_right_ad', 'wheel_bottom_ad', 'wheel_footer_ad',
            'mining_status', 'mining_share', 'webminepool_site_key', 'webminepool_secret_key', 'btc_price', 'monlix_api', 'monlix_secret', 'monlix_hold', 'monlix_status', 'faucet_cost',
            'offerwall_min_hold'
        ];

        foreach ($setting as $key) {
            $newValue = $this->input->post($key);
            if ($key == 'password') {
                $newValue = hash("sha256", $this->input->post($key));
            }
            if (isset($_POST[$key]) && $_POST[$key] != $this->data['settings'][$key]) {
                $this->db->set('value', $newValue);
                $this->db->where('name', $key);
                $this->db->update('settings');
            }
        }
        $this->session->set_flashdata('message', faucet_alert('success', 'Updated'));
        return redirect(site_url('/admin/' . $from));
    }

    public function favicon()
    {
        $config = [
            'upload_path' => './assets/images',
            'allowed_types' => 'ico',
            'max_size' => 10240,
            'max_width' => 1024,
            'max_height' => 768,
            'file_name' => 'favicon.ico',
            'overwrite' => TRUE
        ];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('favicon')) {
            $this->session->set_flashdata('message', faucet_alert('danger', $this->upload->display_errors()));
        } else {
            $this->session->set_flashdata('message', faucet_alert('success', 'Upload success!'));
        }
        redirect(site_url('admin/settings'));
    }

    public function logo()
    {
        $config = [
            'upload_path' => './assets/images',
            'allowed_types' => 'png',
            'max_size' => 10240,
            'max_width' => 1024,
            'max_height' => 768,
            'file_name' => 'logo.png',
            'overwrite' => TRUE
        ];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('logo')) {
            $this->session->set_flashdata('message', faucet_alert('danger', $this->upload->display_errors()));
        } else {
            $this->session->set_flashdata('message', faucet_alert('success', 'Upload success!'));
        }
        redirect(site_url('admin/settings'));
    }
}
