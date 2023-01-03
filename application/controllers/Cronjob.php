<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cronjob extends Guess_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['m_admin', 'm_cronjob', 'm_leaderboard']);
    }
    public function fiveminutes()
    {
        if (time() >= $this->data['settings']['leaderboard_date']) {

            $topClaimer = $this->m_leaderboard->getTopClaimer($this->data['settings']['admin_username']);
            $topReferral = $this->m_leaderboard->getTopReferral($this->data['settings']['admin_username']);
            $topFaucet = $this->m_leaderboard->getTopFaucet($this->data['settings']['admin_username']);
            $topShortlink = $this->m_leaderboard->getTopShortlink($this->data['settings']['admin_username']);
            $topOfferwall = $this->m_leaderboard->getTopOfferwall($this->data['settings']['admin_username']);

            $activityRewards = explode('|', $this->data['settings']['activity_contest_reward']);
            $referralRewards = explode('|', $this->data['settings']['referral_contest_reward']);
            $faucetRewards = explode('|', $this->data['settings']['faucet_contest_reward']);
            $shortlinkRewards = explode('|', $this->data['settings']['shortlink_contest_reward']);
            $offerwallRewards = explode('|', $this->data['settings']['offerwall_contest_reward']);

            $nextTime = (date("Y-m-d", strtotime('Sunday')) == date("Y-m-d", time())) ? strtotime('Sunday') + 7 * 86400 : strtotime('Sunday');
            $this->m_cronjob->updateLeaderboardDate($nextTime);
            $this->m_cronjob->resetLeaderboard();
            $this->cache->delete('leaderboard_info');

            if (!empty($this->data['settings']['activity_contest_reward'])) {
                for ($i = 0; $i < min(count($activityRewards), count($topClaimer)); ++$i) {
                    $this->m_core->addNotification($topClaimer[$i]['id'], currency($activityRewards[$i], $this->data['settings']['currency_rate']) . " from Activity Contest was credited to your balance.", 1);
                    $this->m_cronjob->updateUserBalance($topClaimer[$i]['id'], trim($activityRewards[$i]));
                    $this->m_core->addOtherLog($topClaimer[$i]['id'], 'Activity contest #' . ($i + 1), trim($activityRewards[$i]));
                }
            }
            if (!empty($this->data['settings']['referral_contest_reward'])) {
                for ($i = 0; $i < min(count($referralRewards), count($topReferral)); ++$i) {
                    $this->m_core->addNotification($topReferral[$i]['id'], currency($referralRewards[$i], $this->data['settings']['currency_rate']) . " from Referral Contest was credited to your balance.", 1);
                    $this->m_cronjob->updateUserBalance($topReferral[$i]['id'], trim($referralRewards[$i]));
                    $this->m_core->addOtherLog($topReferral[$i]['id'], 'Referral contest #' . ($i + 1), trim($referralRewards[$i]));
                }
            }
            if (!empty($this->data['settings']['faucet_contest_reward'])) {
                for ($i = 0; $i < min(count($faucetRewards), count($topFaucet)); ++$i) {
                    $this->m_core->addNotification($topFaucet[$i]['id'], currency($faucetRewards[$i], $this->data['settings']['currency_rate']) . " from Faucet Contest was credited to your balance.", 1);
                    $this->m_cronjob->updateUserBalance($topFaucet[$i]['id'], trim($faucetRewards[$i]));
                    $this->m_core->addOtherLog($topFaucet[$i]['id'], 'Faucet contest #' . ($i + 1), trim($faucetRewards[$i]));
                }
            }
            if (!empty($this->data['settings']['shortlink_contest_reward'])) {
                for ($i = 0; $i < min(count($shortlinkRewards), count($topShortlink)); ++$i) {
                    $this->m_core->addNotification($topShortlink[$i]['id'], currency($shortlinkRewards[$i], $this->data['settings']['currency_rate']) . " from Shortlink Contest was credited to your balance.", 1);
                    $this->m_cronjob->updateUserBalance($topShortlink[$i]['id'], trim($shortlinkRewards[$i]));
                    $this->m_core->addOtherLog($topShortlink[$i]['id'], 'Shortlink contest #' . ($i + 1), trim($shortlinkRewards[$i]));
                }
            }
            if (!empty($this->data['settings']['offerwall_contest_reward'])) {
                for ($i = 0; $i < min(count($offerwallRewards), count($topOfferwall)); ++$i) {
                    $this->m_core->addNotification($topOfferwall[$i]['id'], currency($offerwallRewards[$i], $this->data['settings']['currency_rate']) . " from Offerwall Contest was credited to your balance.", 1);
                    $this->m_cronjob->updateUserBalance($topOfferwall[$i]['id'], trim($offerwallRewards[$i]));
                    $this->m_core->addOtherLog($topOfferwall[$i]['id'], 'Offerwall contest #' . ($i + 1), trim($offerwallRewards[$i]));
                }
            }
            echo 'ok 1';
        }

        if ($this->data['settings']['lottery_duration'] > 0) {
            if (time() >= $this->data['settings']['lottery_date']) {
                $lotteries = $this->m_cronjob->getAllLottery();
                if (count($lotteries) > 0) {
                    $luckyNumber = rand(0, count($lotteries) - 1);

                    $reward = count($lotteries) * $this->data['settings']['lottery_reward'] + $this->data['settings']['lottery_base_reward'];
                    $this->m_cronjob->updateUserBalance($lotteries[$luckyNumber]['user_id'], $reward);
                    $this->m_cronjob->insertLotteryHistory($lotteries[$luckyNumber]['user_id'], $lotteries[$luckyNumber]['number'], $reward);

                    $user = $this->m_core->get_user_from_id($lotteries[$luckyNumber]['user_id']);
                    $this->m_core->addNotification($user['id'], currency($reward, $this->data['settings']['currency_rate']) . " from Lottery was credited to your balance.", 1);
                    $this->m_core->addOtherLog($user['id'], 'Lottery', $reward);
                }
                $this->m_cronjob->updateLotteryDate(time() + 86400 * $this->data['settings']['lottery_duration']);
                $this->m_cronjob->resetLottery();
                echo 'ok 2';
            }
        }

        $offerHistory = $this->m_cronjob->getAvailableOffers();

        foreach ($offerHistory as $history) {
            $this->m_cronjob->updateUserBalance($history['user_id'], $history['amount']);
            $this->m_cronjob->updateOfferwallHistoryStatus($history['id']);

            $user = $this->m_core->get_user_from_id($history['user_id']);
            $this->m_core->addExp($user['id'], $this->data['settings']['offerwall_exp_reward']);
            $user['exp'] += $this->data['settings']['offerwall_exp_reward'];
            if ($user['exp'] >= ($user['level'] + 1) * 100) {
                $this->m_core->levelUp($user['id']);
            }
        }
        echo 'ok 3';

        $currencies = $this->m_cronjob->getCurrencyName();
        $currencyName = [];
        foreach ($currencies as $currency) {
            array_push($currencyName, $currency['currency_name']);
        }
        if (!in_array("bitcoin", $currencyName)) {
            array_push($currencyName, 'bitcoin');
        }
        $query = urlencode(implode(',', $currencyName));
        $apiUrl = 'https://api.coingecko.com/api/v3/simple/price?ids=' . $query . '&vs_currencies=usd';
        $result = @json_decode(get_data($apiUrl), TRUE);

        foreach ($result as $name => $price) {
            $this->m_cronjob->updatePrice($name, $price['usd']);
        }
        if (isset($result['bitcoin']) && isset($result['bitcoin']['usd'])) {
            $this->m_cronjob->updateBtcPrice($result['bitcoin']['usd']);
        }

        echo 'ok 4';
    }
    public function daily()
    {
        $yesterday = strtotime('yesterday midnight');
        $today = strtotime('today midnight');
        $date = date("Y-m-d", strtotime('yesterday midnight'));

        $todayData = [
            'date' => date("Y-m-d", $today)
        ];
        $yesterdayData = [
            'date' => $date
        ];
        if ($this->m_cronjob->isYesterdayExist($date)) {
            $this->db->insert('faucet_stats', $yesterdayData);
        }
        if ($this->m_cronjob->checkYesterdayLog($date)) {
            $yesterdayData['active_users'] = $this->m_cronjob->countActiveUsers($yesterday, $today);
            $yesterdayData['new_users'] = $this->m_cronjob->countNewUsers($yesterday, $today);

            $faucetStat = $this->m_cronjob->faucetStat($yesterday, $today);
            $yesterdayData['faucet_count'] = $faucetStat['cnt'];
            $yesterdayData['faucet_amount'] = $faucetStat['amount'];

            $shortlinkStat = $this->m_cronjob->shortlinkStat($yesterday, $today);
            $yesterdayData['shortlink_count'] = $shortlinkStat['cnt'];
            $yesterdayData['shortlink_amount'] = $shortlinkStat['amount'];

            $offerwallStat = $this->m_cronjob->offerwallStat($yesterday, $today);
            $yesterdayData['offerwall_count'] = $offerwallStat['cnt'];
            $yesterdayData['offerwall_amount'] = $offerwallStat['amount'];

            $offerwallStat = $this->m_cronjob->ptcStat($yesterday, $today);
            $yesterdayData['ptc_count'] = $offerwallStat['cnt'];
            $yesterdayData['ptc_amount'] = $offerwallStat['amount'];

            $diceStat = $this->m_cronjob->diceStat($yesterday, $today);
            $yesterdayData['dice_count'] = $diceStat['cnt'];
            $yesterdayData['dice_amount'] = $diceStat['amount'];

            $depositStat = $this->m_cronjob->depositStat($yesterday, $today);
            $yesterdayData['deposit_count'] = $depositStat['cnt'];
            $yesterdayData['deposit_amount'] = $depositStat['amount'];

            $depositStat = $this->m_cronjob->withdrawStat($yesterday, $today);
            $yesterdayData['withdraw_count'] = $depositStat['cnt'];
            $yesterdayData['withdraw_amount'] = $depositStat['amount'];

            $coinflipStat = $this->m_cronjob->coinflipStat($yesterday, $today);
            $yesterdayData['coinflip_count'] = $coinflipStat['cnt'];
            $yesterdayData['coinflip_amount'] = $coinflipStat['amount'];

            $achievementStat = $this->m_cronjob->achievementStat($yesterday, $today);
            $yesterdayData['achievement_count'] = $achievementStat['cnt'];
            $yesterdayData['achievement_amount'] = $achievementStat['amount'];

            $wheelStat = $this->m_cronjob->wheelStat($yesterday, $today);
            $yesterdayData['wheel_count'] = $wheelStat['cnt'];
            $yesterdayData['wheel_amount'] = $wheelStat['amount'];

            $this->db->set('active_users', $yesterdayData['active_users']);
            $this->db->set('new_users', $yesterdayData['new_users']);
            $this->db->set('faucet_count', $yesterdayData['faucet_count']);
            $this->db->set('faucet_amount', $yesterdayData['faucet_amount']);
            $this->db->set('shortlink_count', $yesterdayData['shortlink_count']);
            $this->db->set('shortlink_amount', $yesterdayData['shortlink_amount']);
            $this->db->set('ptc_count', $yesterdayData['ptc_count']);
            $this->db->set('ptc_amount', $yesterdayData['ptc_amount']);
            $this->db->set('offerwall_count', $yesterdayData['offerwall_count']);
            $this->db->set('offerwall_amount', $yesterdayData['offerwall_amount']);
            $this->db->set('dice_count', $yesterdayData['dice_count']);
            $this->db->set('dice_amount', $yesterdayData['dice_amount']);
            $this->db->set('coinflip_count', $yesterdayData['coinflip_count']);
            $this->db->set('coinflip_amount', $yesterdayData['coinflip_amount']);
            $this->db->set('achievement_count', $yesterdayData['achievement_count']);
            $this->db->set('achievement_amount', $yesterdayData['achievement_amount']);
            $this->db->set('deposit_amount', $yesterdayData['deposit_amount']);
            $this->db->set('deposit_count', $yesterdayData['deposit_count']);
            $this->db->set('deposit_amount', $yesterdayData['deposit_amount']);
            $this->db->set('withdraw_amount', $yesterdayData['withdraw_amount']);
            $this->db->set('wheel_amount', $yesterdayData['wheel_amount']);
            $this->db->set('wheel_count', $yesterdayData['wheel_count']);
            $this->db->set('is_done', 1);
            $this->db->where('date', $date);
            $this->db->update('faucet_stats');
            $this->db->insert('faucet_stats', $todayData);

            $this->m_cronjob->clearHistory();

            $this->db->set('wheel_cnt', 0);
            $this->db->set('today_faucet', 0);
            $this->db->update('users');
            echo 'ok daily';
        }
    }
}
