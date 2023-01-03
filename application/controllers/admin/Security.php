<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Security extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->data['page'] = 'Protect your faucet!';
        include APPPATH . 'third_party/authenticator/vendor/autoload.php';
        $ga = new PHPGangsta_GoogleAuthenticator();
        $secret = $ga->createSecret();

        $this->data['auth'] = [
            'secret' => $secret,
            'qrCodeUrl' => $ga->getQRCodeGoogleUrl($this->data['settings']['name'] . ' Admin Panel', $secret)
        ];
        $this->render('security', $this->data);
    }

    public function authenticator()
    {
        if (!empty($this->data['settings']['authenticator_code'])) {
            return redirect(site_url('admin/security'));
        }
        include APPPATH . 'third_party/authenticator/vendor/autoload.php';
        $ga = new PHPGangsta_GoogleAuthenticator();
        $checkResult = $ga->verifyCode($this->input->post('secret'), $this->input->post('code'), 2);
        if ($checkResult) {
            $this->m_admin->addAuthenticator($this->input->post('secret'));
            $this->session->set_flashdata('message', faucet_alert('success', 'You have added Authenticator successful'));
        } else {
            $this->session->set_flashdata('message', faucet_alert('danger', 'Wrong code'));
        }
        redirect(site_url('admin/security'));
    }
}
