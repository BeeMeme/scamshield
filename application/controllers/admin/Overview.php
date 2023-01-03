<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Overview extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->data['totalPendingAds'] = $this->m_admin->countPendingAds();
    }

    public function index()
    {
        $this->data['page'] = 'Overview';

        $todayTime = strtotime('today midnight');

        $todayStat = [];
        $todayStat[0]['date'] = 'Today';
        $todayStat[0]['active_users'] = $this->m_admin->countActiveUsers($todayTime);
        $todayStat[0]['new_users'] = $this->m_admin->countNewUsers($todayTime);

        $autoFaucetStat = $this->m_admin->getTodayStat();
        if ($autoFaucetStat) {
            $todayStat[0]['autofaucet_count'] = $autoFaucetStat['autofaucet_count'];
            $todayStat[0]['autofaucet_amount'] = $autoFaucetStat['autofaucet_amount'];
        } else {
            $todayStat[0]['autofaucet_count'] = 0;
            $todayStat[0]['autofaucet_amount'] = 0;
        }
        $faucetStat = $this->m_admin->faucetStat($todayTime);
        $todayStat[0]['faucet_count'] = $faucetStat['cnt'];
        $todayStat[0]['faucet_amount'] = $faucetStat['amount'];

        $shortlinkStat = $this->m_admin->shortlinkStat($todayTime);
        $todayStat[0]['shortlink_count'] = $shortlinkStat['cnt'];
        $todayStat[0]['shortlink_amount'] = $shortlinkStat['amount'];

        $offerwallStat = $this->m_admin->offerwallStat($todayTime);
        $todayStat[0]['offerwall_count'] = $offerwallStat['cnt'];
        $todayStat[0]['offerwall_amount'] = $offerwallStat['amount'];

        $offerwallStat = $this->m_admin->ptcStat($todayTime);
        $todayStat[0]['ptc_count'] = $offerwallStat['cnt'];
        $todayStat[0]['ptc_amount'] = $offerwallStat['amount'];

        $diceStat = $this->m_admin->diceStat($todayTime);
        $todayStat[0]['dice_count'] = $diceStat['cnt'];
        $todayStat[0]['dice_amount'] = $diceStat['amount'];

        $coinflipStat = $this->m_admin->coinflipStat($todayTime);
        $todayStat[0]['coinflip_count'] = $coinflipStat['cnt'];
        $todayStat[0]['coinflip_amount'] = $coinflipStat['amount'];

        $achievementStat = $this->m_admin->achievementStat($todayTime);
        $todayStat[0]['achievement_count'] = $achievementStat['cnt'];
        $todayStat[0]['achievement_amount'] = $achievementStat['amount'];

        $depositStat = $this->m_admin->depositStat($todayTime);
        $todayStat[0]['deposit_count'] = $depositStat['cnt'];
        $todayStat[0]['deposit_amount'] = $depositStat['amount'];

        $withdrawStat = $this->m_admin->withdrawStat($todayTime);
        $todayStat[0]['withdraw_count'] = $withdrawStat['cnt'];
        $todayStat[0]['withdraw_amount'] = $withdrawStat['amount'];

        $wheelStat = $this->m_admin->wheelStat($todayTime);
        $todayStat[0]['wheel_count'] = $wheelStat['cnt'];
        $todayStat[0]['wheel_amount'] = $wheelStat['amount'];

        $stats = $this->m_admin->getStats();

        $stats = array_reverse(array_merge($todayStat, $stats));

        $this->data['stats'] = [];
        foreach ($stats[0] as $key => $value) {
            $this->data['stats'][$key] = [];
        }
        $this->data['stats']['total'] = [];

        foreach ($stats as $day) {
            $total = 0;
            foreach ($day as $type => $value) {
                if (!in_array($type, ['id', 'is_done', 'withdraw_count'])) {
                    array_push($this->data['stats'][$type], $value);
                    if (strpos($type, 'amount')) {
                        $total += $value;
                    }
                }
            }
            array_push($this->data['stats']['total'], $total);
        }
        $this->data['pendingSubmissions'] = $this->m_admin->countPendingSubmissions();
        $this->data['pendingWithdrawal'] = $this->m_admin->countPendingWithdrawal();
        $this->data['pendingOfferwall'] = $this->m_admin->countPendingOfferwall();
        $this->data['pendingCampaigns'] = $this->m_admin->countPendingAds();
        $this->data['info'] = $this->m_admin->info();
        $linkStats = $this->m_admin->shortLinkStatic();
        $this->data['linkStatic'] = [];
        $this->data['mapNameToId'] = [];
        foreach ($linkStats[0] as $link) {
            $this->data['linkStatic'][$link['name']] = [
                'cnt' => [],
                'amount' => []
            ];
            $this->data['mapNameToId'][$link['name']] = $link['id'];
        }
        foreach ($linkStats as $linkStat) {
            foreach ($linkStat as $link) {
                array_push($this->data['linkStatic'][$link['name']]['cnt'], $link['cnt']);
                array_push($this->data['linkStatic'][$link['name']]['amount'], $link['amount']);
            }
        }
        $this->data['todayDeposit'] = $this->m_admin->getTodayDeposit();
        $this->data['logs'] = $this->m_admin->getLogs();
        $this->render('overview', $this->data);
    }
    public function clear_history()
    {
        $this->m_admin->clear_history();
        redirect(site_url('/admin/overview'));
    }
}
