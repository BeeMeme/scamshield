<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Firewall extends Member_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_migration');
        $this->load->library('form_validation');
        if ($this->data['user']['status'] != 'firewall') {
            return redirect(site_url('dashboard'));
        }
    }
    public function index()
    {
        $this->data['page'] = 'Firewall';

        $availableCaptcha = [];
        $captchaNames = [];

        if (!empty($this->data['settings']['recaptcha_v2_site_key'])) {
            array_push($availableCaptcha, '<script src="https://www.google.com/recaptcha/api.js" async defer></script><div id="recaptchav2" class="captcha">
            <div class="g-recaptcha" data-sitekey="' . $this->data['settings']["recaptcha_v2_site_key"] . '"></div></div>');
            array_push($captchaNames, 'recaptchav2');
        }
        if (!empty($this->data['settings']['c_key'])) {
            include APPPATH . 'third_party/solvemedia.php';
            array_push($availableCaptcha, solvemedia_get_html($this->data['settings']['c_key'], $error = null, $use_ssl = true));
            array_push($captchaNames, 'solvemedia');
        }
        if (!empty($this->data['settings']['hcaptcha_site_key'])) {
            array_push($availableCaptcha, '<script src="https://hcaptcha.com/1/api.js" async defer></script>
            <div class="h-captcha" data-sitekey="' . $this->data['settings']["hcaptcha_site_key"] . '"></div>');
            array_push($captchaNames, 'hcaptcha');
        }

        $rnd = rand(0, count($availableCaptcha) - 1);
        $this->data['captcha'] = [
            'name' => $captchaNames[$rnd],
            'code' => $availableCaptcha[$rnd]
        ];
        $this->render('firewall', $this->data);
    }

    public function verify()
    {
        $checkCaptcha = false;
        switch ($this->input->post('captchaType')) {
            case "recaptchav3":
                $checkCaptcha = verifyRecaptchaV3($this->input->post('recaptchav3'), $this->data['settings']['recaptcha_v3_secret_key']);
                break;
            case "recaptchav2":
                $checkCaptcha = verifyRecaptchaV2($this->input->post('g-recaptcha-response'), $this->data['settings']['recaptcha_v2_secret_key']);
                break;
            case "solvemedia":
                $checkCaptcha = verifySolvemedia($this->data['settings']['v_key'], $this->data['settings']['h_key'], $this->input->ip_address(), $this->input->post('adcopy_challenge'), $this->input->post('adcopy_response'));
                break;
            case "hcaptcha":
                $checkCaptcha = verifyHcaptcha($this->input->post('h-captcha-response'), $this->data['settings']['hcaptcha_secret_key'], $this->input->ip_address());
                break;
        }
        if (!$checkCaptcha) {
            if ($this->data['user']['fail'] == $this->data['settings']['captcha_fail_limit']) {
                $this->m_core->insertCheatLog($this->data['user']['id'], 'Too many wrong captcha.', 0);
            } else if ($this->data['user']['fail'] < 4) {
                $this->m_core->wrongCaptcha($this->data['user']['id']);
            }
            $this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Captcha'));
            return redirect(site_url('firewall'));
        }
        if ($this->data['user']['fail'] > 0) {
            $this->m_core->resetFail($this->data['user']['id']);
        }
        $this->m_core->unlockFirewall($this->data['user']['id']);
        redirect(site_url('dashboard'));
    }
}
