<div class="ads">
  <?= $settings['dashboard_top_ad'] ?>
</div>
<?php
if ($user['verified'] == 0) {
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        Please confirm your email address to be able to withdraw, <a href="' . site_url('dashboard/resend') . '">Resend</a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true"><i class="far fa-window-close"></i></span>
        </button>
      </div>';
}
?>
<div class="row">
  <div class="col-xl-4">
    <div class="card overflow-hidden">
      <div class="bg-soft-primary">
        <div class="row">
          <div class="col-7">
            <div class="text-primary p-3">
              <h5 class="text-primary">Welcome Back !</h5>
              <p><?= $user['username'] ?></p>
            </div>
          </div>
          <div class="col-5 align-self-end">
            <img src="<?= base_url() ?>assets/images/profile-img.png" alt="" class="img-fluid">
          </div>
        </div>
      </div>
      <div class="card-body pt-0">
        <div class="row">
          <div class="col-sm-4">
            <div class="avatar-md profile-user-wid mb-4">
              <img src="<?= base_url() ?>assets/images/users/user.png" alt="" class="img-thumbnail rounded-circle">
            </div>
            <h5 class="font-size-15 text-truncate"><?= $user['username'] ?></h5>
            <p class="text-muted mb-0 text-truncate">Level <?= $user['level'] ?></p>
          </div>

          <div class="col-sm-8">
            <div class="pt-4">
              <div class="row">
                <div class="col-6">
                  <h5 class="font-size-15">Total earned</h5>
                  <p class="text-muted mb-0"><?= currency($user["total_earned"], $settings['currency_rate']) ?></p>
                </div>
                <div class="col-6">
                  <h5 class="font-size-15">Referrals</h5>
                  <p class="text-muted mb-0"><?= $referralCount ?></p>
                </div>
              </div>
              <div class="mt-4">
                <a href="<?= site_url('profile') ?>" class="btn btn-primary waves-effect waves-light btn-sm">Profile <i class="mdi mdi-arrow-right ml-1"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4">Your Progress</h4>
        <div class="row">
          <div class="col-sm-6">
            <p class="text-muted">Your Exp</p>
            <h3><?= $user['exp'] ?></h3>
            <p class="text-muted"><span class="text-success mr-2"> <?= ($user['level'] + 1) * 100 - $user['exp'] ?> exp </span> needed for the next level</p>
            <?php
            if ($bonus + $settings['level_bonus'] <= $settings['max_bonus']) { ?>
              <p class="text-muted"><span class="text-success me-2"> <?= $settings['level_bonus'] ?>% <i class="mdi mdi-arrow-up"></i> </span> Bonus for the next level</p>
            <?php }
            ?>
            <p class="text-muted"><span class="text-success me-2"> <?= $bonus ?>% </span> Bonus on Faucet</p>
          </div>
          <div class="col-sm-6">
            <div class="mt-4 mt-sm-0">
              <div id="radialBar-chart" class="apex-charts"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-8">
    <div class="row">
      <div class="col-md-4">
        <div class="card mini-stats-wid">
          <div class="card-body">
            <div class="media">
              <div class="media-body">
                <p class="text-muted font-weight-medium">Balance</p>
                <h4 class="mb-0"><?= currency($user['balance'], $settings['currency_rate']) ?></h4>
              </div>
              <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                <span class="avatar-title">
                  <i class="fas fa-wallet fa-2x"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mini-stats-wid">
          <div class="card-body">
            <div class="media">
              <div class="media-body">
                <p class="text-muted font-weight-medium">Energy</p>
                <h4 class="mb-0"><?= $user['energy'] ?></h4>
              </div>

              <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                <span class="avatar-title rounded-circle bg-primary">
                  <i class="fas fa-bolt fa-2x"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mini-stats-wid">
          <div class="card-body">
            <div class="media">
              <div class="media-body">
                <p class="text-muted font-weight-medium">Deposit Balance</p>
                <h4 class="mb-0"><?= currency($user['dep_balance'], $settings['currency_rate']) ?></h4>
              </div>

              <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                <span class="avatar-title rounded-circle bg-primary">
                  <i class="fas fa-money-check fa-2x"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->


    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4">Withdraw</h4>
        <div class="ads">
          <?= $settings['dashboard_header_ad'] ?>
        </div>
        <form action="<?= site_url('dashboard/withdraw') ?>" method="POST" autocomplete="off">
          <?php
          if (isset($_SESSION['withdraw_message'])) {
            echo $_SESSION['withdraw_message'];
          }
          ?>
          <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">
          <div class="mb-2">
            <label>Currency :</label>
            <div class="row">
              <script>
                var currencies = [];
                var minimumWithdrawals = [];
                var rate = <?= $settings['currency_rate'] ?>;
              </script>
              <?php foreach ($methods as $method) { ?>
                <div class="col-xl-4 col-sm-6">
                  <div class="mb-3">
                    <label class="card-radio-label mb-2">
                      <input type="radio" name="method" value="<?= $method['id'] ?>" class="card-radio-input" checked="" required>
                      <div class="card-radio">
                        <div>
                          <img class="currency-dashboard" src="<?= site_url('assets/images/currencies/' . strtolower($method['code']) . '.png') ?>" />
                          <span><?= $method['name'] ?></span>
                        </div>
                      </div>
                    </label>
                    <script>
                      currencies['<?= $method['id'] ?>'] = {
                        price: <?= $method['price'] ?>,
                        code: '<?= $method['code'] ?>',
                        minimumWithdrawal: <?= $method['minimum_withdrawal'] ?>
                      };
                    </script>
                    <div>
                      <p class="text-muted mb-1">Current rate:</p>
                      <h5 class="font-size-14">1 <?= $method['code'] ?> = <?= currency($method['price'], $settings['currency_rate']) ?></h5>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label>Amount :</label>
            <div class="row">
              <div class="col-sm-6">
                <div class="input-group mb-2 currency-value">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Token Balance</span>
                  </div>
                  <input type="number" name="amount" id="tokenBalance" value="<?= $user['balance'] / $settings['currency_rate'] ?>" class="form-control" min="0.000001" max="<?= $user['balance'] / $settings['currency_rate'] ?>" step="0.000001">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="input-group mb-2">
                  <input type="text" id="converted" class="form-control text-sm-right" disabled>

                  <div class="input-group-append">
                    <span class="input-group-text" id="targetCurrency">You will receive</span>
                  </div>
                </div>
              </div>
            </div>
            <small id="minimumWithdrawal"></small>
          </div>
          <div class="ads">
            <?= $settings['dashboard_bottom_ad'] ?>
          </div>
          <div class="form-group">
            <label>Wallet Address :</label>
            <input type="text" name="wallet" class="form-control" value="<?= $user['wallet'] ?>">
          </div>
          <div class="text-center mt-4">
            <button type="submit" class="btn btn-success">Withdraw</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>