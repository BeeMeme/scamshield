<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wheel extends Member_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->data['settings']['wheel_status'] != 'on') {
            return redirect(site_url('dashboard'));
        }
        $this->load->helper('string');
        $this->load->model('m_wheel');
    }
    public function index()
    {
        $this->data['page'] = 'Wheel of fortunes';

        $this->data['prizes'] = $this->m_wheel->getPrizes();
        $this->data['wait'] = max(0, $this->data['settings']['wheel_timer'] - time() + $this->data['user']['wheel_claim']);
        $this->data['limit'] = $this->data['settings']['wheel_limit'] <= $this->data['user']['wheel_cnt'];

        if ($this->data['settings']['antibotlinks'] == 'on') {
            include APPPATH . 'third_party/antibot/antibotlinks.php';
            $antibotlinks = new antibotlinks(true, 'ttf,otf', array('abl_light_colors' => 'off', 'abl_background' => 'off', 'abl_noise' => 'on'));
            $antibotlinks->generate(3, true);
            $this->data['antibot_js'] = $antibotlinks->get_js();
            $this->data['antibot_show_info'] = $antibotlinks->show_info();
        }
        $this->data['captcha_display'] = get_captcha($this->data['settings'], base_url(), 'faucet_captcha');

        $this->data['anti_pos'] = [rand(0, 5), rand(0, 5), rand(0, 5)];
        $this->data['bonus'] = min($this->data['settings']['max_bonus'], $this->data['settings']['level_bonus'] * $this->data['user']['level']);
        $this->render('wheel', $this->data);
    }

    public function verify()
    {
        if ($this->data['settings']['antibotlinks'] == 'on') {
            #CHECK ANTIBOTLINKS
            if ((trim($_POST['antibotlinks']) !== $_SESSION['antibotlinks']['solution']) or (empty($_SESSION['antibotlinks']['solution']))) {
                if ($this->data['user']['fail'] == $this->data['settings']['captcha_fail_limit']) {
                    $this->m_core->insertCheatLog($this->data['user']['id'], 'Too many wrong captcha.', 0);
                } else if ($this->data['user']['fail'] < 4) {
                    $this->m_core->wrongCaptcha($this->data['user']['id']);
                }
                print_r(json_encode([
                    'status' => 'error',
                    'message' => 'Invalid Anti-Bot Links',
                ]));
                die();
            }
        }
        #Check captcha
        $captcha = $this->input->post('captcha');
        $Check_captcha = false;
        setcookie('captcha', $captcha, time() + 86400 * 10);
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
            if ($this->data['user']['fail'] == $this->data['settings']['captcha_fail_limit']) {
                $this->m_core->insertCheatLog($this->data['user']['id'], 'Too many wrong captcha.', 0);
            } else if ($this->data['user']['fail'] < 4) {
                $this->m_core->wrongCaptcha($this->data['user']['id']);
            }
            print_r(json_encode([
                'status' => 'error',
                'message' => 'Invalid captcha',
            ]));
            die();
        }

        if (time() - $this->data['user']['wheel_claim'] < $this->data['settings']['wheel_timer']) {
            print_r(json_encode([
                'status' => 'error',
                'message' => 'Invalid claim',
            ]));
            die();
        }

        if ($this->data['settings']['wheel_limit'] <= $this->data['user']['wheel_cnt']) {
            print_r(json_encode([
                'status' => 'error',
                'message' => 'Invalid claim',
            ]));
            die();
        }

        $prizes = $this->m_wheel->getPrizes();
        $totalWeight = 0;
        foreach ($prizes as $prize) {
            $totalWeight += $prize['probability'];
        }

        $r = mt_rand() / mt_getrandmax();
        $t = 0;
        foreach ($prizes as $idx => $prize) {
            $t += $prize['probability'] / $totalWeight;
            if ($t > $r) {
                break;
            }
        }

        $this->m_wheel->updateUser($this->data['user']['id'], $prize['usd_reward'], $this->data['settings']['wheel_energy']);

        $this->m_core->addExp($this->data['user']['id'], $prize['exp_reward']);
        if (($this->data['user']['exp'] + $prize['exp_reward']) >= ($this->data['user']['level'] + 1) * 100) {
            $this->m_core->levelUp($this->data['user']['id']);
        }

        if ($this->data['user']['referred_by'] != 0 && time() - $this->m_core->lastActive($this->data['user']['referred_by']) < 86400) {
            $amount = $prize['usd_reward'] * $this->data['settings']['referral'] / 100;
            if ($amount > 0) {
                $this->m_core->update_referral($this->data['user']['referred_by'], $amount);
            }
        }

        if ($this->data['user']['fail'] > 0) {
            $this->m_core->resetFail($this->data['user']['id']);
        }

        $angPerPrize = intval(360 / count($prizes));
        $stopAngle = 3600 + $idx * $angPerPrize + rand(1, $angPerPrize);

        $this->m_wheel->insertHistory($this->data['user']['id'], $prize['usd_reward']);

        $result = [
            'status' => 'success',
            'reward' => currency($prize['usd_reward'], $this->data['settings']['currency_rate']),
            'stopAngle' => $stopAngle,
        ];
        print_r(json_encode($result));
    }
}
