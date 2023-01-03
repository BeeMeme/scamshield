<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Achievements extends Member_Controller
{
  public function __construct()
  {
    parent::__construct();
    if ($this->data['settings']['achievement_status'] != 'on') {
      return redirect(site_url('dashboard'));
    }
    $this->load->model('m_achievements');
  }

  public function index()
  {
    $this->data['page'] = 'Achievements';
    $this->data['achievements'] = $this->m_achievements->getAchievements($this->data['user']['id']);

    $this->data['categoried'] = [];
    for ($i = 0; $i < count($this->data['achievements']); ++$i) {
      if ($this->data['achievements'][$i]['type'] == 0) {
        $this->data['achievements'][$i]['completed'] = $this->m_achievements->checkFaucet($this->data['user']['id']);
        $this->data['achievements'][$i]['description'] = 'Complete ' . $this->data['achievements'][$i]['condition'] . ' faucet claims';
      } else if ($this->data['achievements'][$i]['type'] == 1) {
        $this->data['achievements'][$i]['completed'] = $this->m_achievements->checkLink($this->data['user']['id']);
        $this->data['achievements'][$i]['description'] = 'Complete ' . $this->data['achievements'][$i]['condition'] . ' shortlinks';
      } else if ($this->data['achievements'][$i]['type'] == 2) {
        $this->data['achievements'][$i]['completed'] = $this->m_achievements->checkPtc($this->data['user']['id']);
        $this->data['achievements'][$i]['description'] = 'View ' . $this->data['achievements'][$i]['condition'] . ' PTC ads';
      } else {
        $this->data['achievements'][$i]['completed'] = $this->m_achievements->checkLottery($this->data['user']['id']);
        $this->data['achievements'][$i]['description'] = 'Buy ' . $this->data['achievements'][$i]['condition'] . ' lotteries';
      }

      $this->data['achievements'][$i]['progress'] = min(100, $this->data['achievements'][$i]['completed'] * 100 / $this->data['achievements'][$i]['condition']);
    }

    $this->render('achievements', $this->data);
  }

  public function claim($id = 0)
  {

    if (!is_numeric($id)) {
      return redirect('achievements');
    }

    $achievement = $this->m_achievements->getAchievementFromId($id);
    if (!$achievement) {
      return redirect('achievements');
    }

    if (!$this->m_achievements->checkHistory($id, $this->data['user']['id'])) {
      return redirect('achievements');
    }

    if ($achievement['type'] == 0) {
      if ($achievement['condition'] > $this->m_achievements->checkFaucet($this->data['user']['id'])) {
        return redirect(site_url('achievements'));
      }
    } else if ($achievement['type'] == 1) {
      if ($achievement['condition'] > $this->m_achievements->checkLink($this->data['user']['id'])) {
        return redirect(site_url('achievements'));
      }
    } else if ($achievement['type'] == 2) {
      if ($achievement['condition'] > $this->m_achievements->checkPtc($this->data['user']['id'])) {
        return redirect(site_url('achievements'));
      }
    } else {
      if ($achievement['condition'] > $this->m_achievements->checkLottery($this->data['user']['id'])) {
        return redirect(site_url('achievements'));
      }
    }

    $this->m_achievements->updateUser($this->data['user']['id'], $achievement['reward_usd'], $achievement['reward_energy']);
    $this->m_core->addExp($this->data['user']['id'], $this->data['settings']['achievement_exp_reward']);
    if (($this->data['user']['exp'] + $this->data['settings']['achievement_exp_reward']) >= ($this->data['user']['level'] + 1) * 100) {
      $this->m_core->levelUp($this->data['user']['id']);
    }
    $this->m_achievements->insertHistory($this->data['user']['id'], $achievement['id'], $achievement['reward_usd']);
    $this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', currency($achievement['reward_usd'], $this->data['settings']['currency_rate']) . ' and ' . $achievement['reward_energy'] . ' engergy have been added to your balance'));
    return redirect(site_url('/achievements'));
  }
}
