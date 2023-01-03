<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->data['page'] = 'Login';
        #Captcha
        $this->data['captcha_display'] = get_captcha($this->data['settings'], base_url(), 'login_captcha');
        $this->load->view('admin_template/login', $this->data);
    }
    public function login()
    {
        if (!empty($this->data['settings']['authenticator_code'])) {
            include APPPATH . 'third_party/authenticator/vendor/autoload.php';
            $ga = new PHPGangsta_GoogleAuthenticator();
            $checkResult = $ga->verifyCode($this->data['settings']['authenticator_code'], $this->input->post('auth_code'), 2);
            if (!$checkResult) {
                $this->session->set_flashdata('message', faucet_alert('danger', 'Wrong code'));
                return redirect(site_url('admin'));
            }
        }
        #Check captcha
        $captcha = $this->input->post('captcha');
        $Check_captcha = false;
        switch ($captcha) {
            case "recaptchav3":
                $Check_captcha = verifyRecaptchaV3($this->input->post('recaptchav3'), $this->data['settings']['recaptcha_v3_secret_key']);
                break;
            case "recaptchav2":
                $Check_captcha = verifyRecaptchaV2($this->input->post('g-recaptcha-response'), $this->data['settings']['recaptcha_v2_secret_key']);
                break;
            case "solvemedia":
                $Check_captcha = verifySolvemedia($this->data['settings']['v_key'], $this->data['settings']['h_key'], $this->input->ip_address(), $this->input->post('adcopy_challenge'), $this->input->post('adcopy_response'));
                break;
            case "hcaptcha":
                $Check_captcha = verifyHcaptcha($this->input->post('h-captcha-response'), $this->data['settings']['hcaptcha_secret_key'], $this->input->ip_address());
                break;
        }
        if (!$Check_captcha) {
            $this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Captcha'));
            return redirect(site_url('admin'));
        }

        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[1]|max_length[100]');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', faucet_alert('danger', 'Login Failed'));
            return redirect(site_url('/admin'));
        }
        $username = $this->db->escape_str($this->input->post('username'));
        $password = hash("sha256", $this->db->escape_str($this->input->post('password')));
        $admin = md5($username . '-' . $password);
        if ($admin != md5($this->data['settings']['username'] . '-' . $this->data['settings']['password'])) {
            $this->session->set_flashdata('message', faucet_alert('danger', 'Login Failed'));
            return redirect(site_url('/admin'));
        } else {
            $this->session->set_userdata('admin', $admin);
        }

        redirect(site_url('/admin/overview'));
    }
}
