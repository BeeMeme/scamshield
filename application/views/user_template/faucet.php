<div class="ads">
    <?= $settings['faucet_top_ad'] ?>
</div>
<div class="row">
    <div class="col-md-6 col-xl-3 mb-3 mb-xl-3">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <?php
                        if ($wait) { ?>
                            <h4 class="lh-1 mb-1 font-weight-bold"><b id="minute"><?= floor($wait / 60) ?></b>:<b id="second"><?= $wait % 60 ?></b></h4>
                        <?php } else { ?>
                            <h4 class="lh-1 mb-1 font-weight-bold">READY</h4>
                        <?php } ?>
                    </div>

                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                        <span class="avatar-title">
                            <i class="fas fa-stopwatch text-white fa-2x"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-3 mb-xl-3">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <p class="lh-1 mb-1 font-weight-bold"><?= floor($settings['timer'] / 60) ?></p>
                        <p class="mb-0">minutes</p>
                    </div>

                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                        <span class="avatar-title">
                            <i class="far fa-clock text-white fa-2x"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-3 mb-xl-3">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <p class="lh-1 mb-1 font-weight-bold"><?= currency($settings['reward'], $settings['currency_rate']) ?> <sup></sup></p>
                        <p class="mb-0"><span class="text-success me-2">+<?= $bonus ?>% bonus</span></p>
                    </div>

                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                        <span class="avatar-title">
                            <i class="fas fa-gifts text-success fa-2x"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-3 mb-xl-3">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <p class="lh-1 mb-1 font-weight-bold"><?= $countHistory ?>/<?= $settings['daily_limit'] ?></p>
                        <p class="mb-0">claims left</p>
                    </div>

                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                        <span class="avatar-title">
                            <i class="fas fa-fire text-warning fa-2x"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-8 col-lg-6 order-md-2 mb-4 text-center">
        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
        ?>
        <div class="ads">
            <?= $settings['faucet_header_ad'] ?>
        </div>
        <?php if ($limit) { ?>
            <div class="alert alert-warning text-center">Daily limit reached, claim from Shortlink Wall to earn energy</div>
            <div class="ads">
                <?= $settings['faucet_bottom_ad'] ?>
            </div>
        <?php } else if ($wait) { ?>
            <div class="ads">
                <?= $settings['faucet_bottom_ad'] ?>
            </div>
            <script type="text/javascript">
                var wait = <?= $wait ?> - 1;
            </script>
        <?php } ?>
        <?php if (!$limit && !$wait) { ?>
            <form action="<?= site_url('/faucet/verify') ?>" method="POST">
                <div class="atb">
                    <?php
                    if ($anti_pos[0] == 0) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[1] == 0) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[2] == 0) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    ?>
                </div>
                <?php if ($settings['antibotlinks'] == 'on') {
                    echo $antibot_show_info;
                }
                ?>
                <div class="atb">
                    <?php
                    if ($anti_pos[0] == 1) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[1] == 1) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[2] == 1) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    ?>
                </div>
                <input type="hidden" name="<?= $csrf_name ?>" id="token" value="<?= $csrf_hash ?>">
                <input type="hidden" name="token" value="<?= $user['token'] ?>">
                <div class="atb">
                    <?php
                    if ($anti_pos[0] == 2) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[1] == 2) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[2] == 2) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    ?>
                </div>
                <center>
                    <?= $captcha_display ?>
                </center>
                <div class="atb">
                    <?php
                    if ($anti_pos[0] == 3) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[1] == 3) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[2] == 3) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    ?>
                </div>
                <div class="ads">
                    <?= $settings['faucet_bottom_ad'] ?>
                </div>
                <div class="atb">
                    <?php
                    if ($anti_pos[0] == 4) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[1] == 4) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[2] == 4) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    ?>
                </div>
                <button type="submit" class="btn btn-primary btn-lg claim-button" disabled><i class="far fa-check-circle"></i> Collect your reward <?= ($useEnergy) ? ' (-' . $settings['faucet_cost'] . 'energy)' : '' ?></button>
                <div class="atb">
                    <?php
                    if ($anti_pos[0] == 5) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[1] == 5) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[2] == 5) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    ?>
                </div>
            </form>
        <?php } ?>
    </div>
    <div class="col-6 col-md-2 col-lg-3 order-md-1 p-0 left-ads"><?= $settings['faucet_left_ad'] ?></div>
    <div class="col-6 col-md-2 col-lg-3 order-md-3 p-0 right-ads"><?= $settings['faucet_right_ad'] ?></div>
</div>
<div class="ads">
    <?= $settings['faucet_footer_ad'] ?>
</div>