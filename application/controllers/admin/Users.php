<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('m_hidden');
    }
    public function index()
    {
        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;

        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');

        $this->data['page'] = 'Users';

        $this->data['users'] = $this->m_admin->get_users($skip);
        $config['base_url'] = site_url('admin/users/');
        $config['total_rows'] = $this->m_admin->count_all_users();

        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->render('users', $this->data);
    }
    public function find()
    {
        $this->data['page'] = 'Users';
        $user = $this->db->escape_str($this->input->post('user'));
        $type = $this->input->post('type');
        if ($this->input->get('ip') != NULL) {
            $type = 'ip';
            $user = $this->input->get('ip');
        }

        switch ($type) {
            case 'id':
                $this->data['users'] = $this->m_admin->getUserFromId($user);
                break;
            case 'username':
                $this->data['users'] = $this->m_admin->getUserFromUsername($user);
                break;
            case 'email':
                $this->data['users'] = $this->m_admin->getUserFromEmail($user);
                break;
            case 'ip':
                $this->data['users'] = $this->m_admin->getUserFromIp($user);
                break;
            default:
                $this->data['users'] = $this->m_admin->getUserFromId($user);
        };
        $this->data['pagination'] = '';
        $this->render('users', $this->data);
    }
    public function details($id = 0)
    {

        $this->data['page'] = 'User Detail';

        $this->data['user'] = $this->m_admin->get_user($id);
        $this->data['referrals'] = $this->m_admin->get_referrals($id);

        $this->data['faucet_history'] = $this->m_account->get_faucet_history($id);
        $this->data['other_history'] = $this->m_account->get_other_history($id);
        $this->data['wheel_history'] = $this->m_account->get_wheel_history($id);
        $this->data['shortlinks_history'] = $this->m_account->get_shortlinks_history($id);
        $this->data['ptc_history'] = $this->m_account->get_ptc_history($id);
        $this->data['offerwall_history'] = $this->m_account->get_offerwall_history($this->data['user']['id']);
        $this->data['withdrawals_history'] = $this->m_account->get_withdrawals_history($id);
        $this->data['deposit_history'] = $this->m_deposit->getDepositByUser($id);
        $this->data['countLotteries'] = $this->m_admin->countLotteries($id);
        $this->data['countReferrals'] = $this->m_admin->countReferrals($id);
        $this->data['logs'] = $this->m_admin->cheatLogs($id);
        $this->render('user_detail', $this->data);
    }
    public function send_message($userId)
    {
        $content = $this->db->escape_str($this->input->post('message'));
        $this->m_core->addNotification($userId, $content, 3);
        redirect(site_url('admin/users/details/' . $userId));
    }
    public function update($userId)
    {
        $email = $this->db->escape_str($this->input->post('email'));
        $username = $this->db->escape_str($this->input->post('username'));
        $ipAddress = $this->db->escape_str($this->input->post('ip_address'));
        $exp = $this->db->escape_str($this->input->post('exp'));
        $level = $this->db->escape_str($this->input->post('level'));
        $referredBy = $this->db->escape_str($this->input->post('referred_by'));
        $verified = $this->db->escape_str($this->input->post('verified'));
        $status = $this->db->escape_str($this->input->post('status'));
        $wallet = $this->db->escape_str($this->input->post('wallet'));
        $balance = $this->db->escape_str($this->input->post('balance'));
        $depBalance = $this->db->escape_str($this->input->post('dep_balance'));
        $energy = $this->db->escape_str($this->input->post('energy'));
        $faucetCount = $this->db->escape_str($this->input->post('faucet_count'));
        $shortlinkCount = $this->db->escape_str($this->input->post('shortlink_count'));
        $offerwallCount = $this->db->escape_str($this->input->post('offerwall_count'));
        $refCount = $this->db->escape_str($this->input->post('ref_count'));
        $totalEarned = $this->db->escape_str($this->input->post('total_earned'));

        $this->m_admin->updateUser($userId, $email, $username, $ipAddress, $exp, $level, $referredBy, $verified, $status, $wallet, $balance, $depBalance, $energy, $faucetCount, $shortlinkCount, $offerwallCount, $refCount, $totalEarned);
        redirect(site_url('admin/users/details/' . $userId));
    }
    public function same_password()
    {
        if (isset($_GET['inactive'])) {
            if ($_GET['inactive'] == 1) {
                $this->session->set_userdata('inactive', 1);
            } else {
                $this->session->set_userdata('inactive', null);
            }
            return redirect('admin/users/same_password');
        }
        if (isset($_GET['banned'])) {
            if ($_GET['banned'] == 1) {
                $this->session->set_userdata('banned', 1);
            } else {
                $this->session->set_userdata('banned', null);
            }
            return redirect('admin/users/same_password');
        }
        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;

        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');

        $this->data['page'] = 'Users have same password';
        $this->data['fraudContent'] = 'Password hash';

        $this->data['users'] = [];
        $passwords = $this->m_hidden->getSamePassword($skip);
        foreach ($passwords as $password) {
            $this->data['users'][$password['password'] . '-' . $password['country']] = $this->m_hidden->getUsersByPassword($password['password'], $password['country'], $this->session->inactive, $this->session->banned);
        }
        $config['base_url'] = site_url('admin/users/same_password/');
        $config['total_rows'] = $this->m_hidden->countSamePassword();

        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->render('same_password', $this->data);
    }

    public function same_ip()
    {
        if (isset($_GET['inactive'])) {
            if ($_GET['inactive'] == 1) {
                $this->session->set_userdata('inactive_ip', 1);
            } else {
                $this->session->set_userdata('inactive_ip', null);
            }
            return redirect('admin/users/same_ip');
        }
        if (isset($_GET['banned'])) {
            if ($_GET['banned'] == 1) {
                $this->session->set_userdata('banned_ip', 1);
            } else {
                $this->session->set_userdata('banned_ip', null);
            }
            return redirect('admin/users/same_ip');
        }
        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');

        $this->data['page'] = 'Users have same IP Address';
        $this->data['fraudContent'] = 'Sub';

        $this->data['users'] = [];
        $subs = $this->m_hidden->getSameIpAddress($skip);
        foreach ($subs as $sub) {
            $this->data['users'][$sub['rs']] = $this->m_hidden->getUsersByIpAddress($sub['rs'], $this->session->inactive_ip, $this->session->banned_ip);
        }
        $config['base_url'] = site_url('admin/users/same_ip/');
        $config['total_rows'] = $this->m_hidden->countSameIpAddress();

        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->render('same_ip', $this->data);
    }

    public function similar_ip()
    {
        if (isset($_GET['inactive'])) {
            if ($_GET['inactive'] == 1) {
                $this->session->set_userdata('inactive_ip', 1);
            } else {
                $this->session->set_userdata('inactive_ip', null);
            }
            return redirect('admin/users/similar_ip');
        }
        if (isset($_GET['banned'])) {
            if ($_GET['banned'] == 1) {
                $this->session->set_userdata('banned_ip', 1);
            } else {
                $this->session->set_userdata('banned_ip', null);
            }
            return redirect('admin/users/similar_ip');
        }
        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');

        $this->data['page'] = 'Users have same IP Address';
        $this->data['fraudContent'] = 'Sub';

        $this->data['users'] = [];
        $subs = $this->m_hidden->getSameSub($skip);
        foreach ($subs as $sub) {
            $this->data['users'][$sub['rs']] = $this->m_hidden->getUsersBySub($sub['rs'], $this->session->inactive_ip, $this->session->banned_ip);
        }
        $config['base_url'] = site_url('admin/users/similar_ip/');
        $config['total_rows'] = $this->m_hidden->countSameSub();

        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->render('same_ip', $this->data);
    }

    public function find_ip($ip = '')
    {
        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');

        $this->data['page'] = 'Users have same IP Address';
        $this->data['fraudContent'] = 'Sub';

        $this->data['users'] = [];
        $subs = $this->m_hidden->findIp($ip, $skip);
        foreach ($subs as $sub) {
            $this->data['users'][$sub['rs']] = $this->m_hidden->getUsersBySub($sub['rs'], $this->session->inactive_ip, $this->session->banned_ip);
        }
        $config['base_url'] = site_url('admin/users/similar_ip/');
        $config['total_rows'] = $this->m_hidden->countFindIp($ip);

        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->render('same_ip', $this->data);
    }

    public function country()
    {
        if (isset($_GET['inactive'])) {
            if ($_GET['inactive'] == 1) {
                $this->session->set_userdata('inactive_user', 1);
            } else {
                $this->session->set_userdata('inactive_user', null);
            }
            return redirect('admin/users/country');
        }
        if (isset($_GET['banned'])) {
            if ($_GET['banned'] == 1) {
                $this->session->set_userdata('banned_user', 1);
            } else {
                $this->session->set_userdata('banned_user', null);
            }
            return redirect('admin/users/country');
        }

        $isocode = $this->input->get('iso');
        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;
        $isocode = strtolower(($isocode));
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');

        $this->data['page'] = 'Users by country';
        $this->data['fraudContent'] = 'IP Address';

        if ($isocode) {
            $this->data['users'] = $this->m_admin->getUsersByCountry($isocode, $skip, $this->session->inactive_user, $this->session->banned_user);
            $config['base_url'] = site_url('admin/users/country/?iso=' . $isocode);
            $config['total_rows'] = $this->m_admin->countUsersByCountry($isocode, $this->session->inactive_user, $this->session->banned_user);

            $config['page_query_string'] = TRUE;
            $this->pagination->initialize($config);
            $this->data['pagination'] = $this->pagination->create_links();
        } else {
            $this->data['users'] = [];
            $this->data['pagination'] = '';
        }

        $this->render('country', $this->data);
    }
    public function ban($id)
    {
        $id = $this->db->escape_str($id);
        $reason = $this->input->post('reason');
        if ($reason == NULL) {
            $reason = 'Banned by admin!';
        }
        $this->m_core->updateStatus($id, 'banned');
        $this->m_core->insertCheatLog($id, $reason, 0, 'Not available');
        redirect(site_url('admin/users/details/' . $id));
    }
    public function unban($id)
    {
        $id = $this->db->escape_str($id);
        $this->db->delete('cheat_logs', array('user_id' => $id));
        redirect(site_url('admin/users/details/' . $id));
    }
    public function active($id)
    {
        $id = $this->db->escape_str($id);
        $this->m_admin->active($id);
        return redirect(site_url('/admin/users/details/' . $id));
    }

    public function delete_logs($id)
    {
        $this->db->set('ip_address', 'removed');
        $this->db->where('id', $id);
        $this->db->update('users');

        $this->db->delete('faucet_history', array('user_id' => $id));
        $this->db->delete('link_history', array('user_id' => $id));
        $this->db->delete('ptc_history', array('user_id' => $id));

        $this->db->delete('cheat_logs', array('user_id' => $id));

        redirect(site_url('admin/users/details/' . $id));
    }

    public function banned()
    {
        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;

        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $config['base_url'] = site_url('admin/users/banned');
        $config['total_rows'] = $this->m_admin->count_banned_users();
        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['page'] = 'Banned Users';
        $this->data['users'] = $this->m_admin->get_banned_users($skip);
        $this->render('users', $this->data);
    }

    public function logs($id = 0)
    {
        $this->data['page'] = 'Relate Logs';
        $this->data['logs'] = $this->m_admin->getSameLogs($id);
        $this->render('logs', $this->data);
    }

    public function mass_ban()
    {
        $ids = $this->input->post('userId');
        foreach ($ids as $id) {
            $this->m_core->updateStatus($id, 'banned');
        }
        redirect($this->input->post('from'));
    }

    public function mass_release()
    {
        $ids = $this->input->post('userId');
        foreach ($ids as $id) {
            $this->m_admin->releaseUser($id);
        }
        redirect($this->input->post('from'));
    }

    public function delete_banned()
    {
        $this->m_admin->deleteBannedUsers();
        redirect('/admin/users');
    }

    public function delete_inactive()
    {
        $this->m_admin->deleteInactiveUsers();
        redirect('/admin/users');
    }

    public function suspected()
    {
        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');

        $this->data['page'] = 'Suspected Users';
        $this->data['fraudContent'] = 'Sub';

        $this->data['users'] = [];
        $subs = $this->m_hidden->getSameIpAddressSuspect($skip);
        foreach ($subs as $sub) {
            $this->data['users'][$sub['sub']] = $this->m_hidden->getUsersByIpAddressSuspect($sub['sub'], $this->session->inactive_ip, $this->session->banned_ip);
        }
        $config['base_url'] = site_url('admin/users/suspected/');
        $config['total_rows'] = $this->m_hidden->countSameIpAddressSuspect();

        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->render('suspect', $this->data);
    }
}
