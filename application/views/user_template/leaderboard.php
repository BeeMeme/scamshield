<div class="ads">
    <?= $settings['dashboard_top_ad'] ?>
</div>
<div class="alert alert-warning text-center">Weekly Leaderboard Resets In <?= timespan(time(), $settings["leaderboard_date"], 2) ?> and updated every 10 minutes!</div>
<div class="row">
    <div class="col-12 col-md-6 col-lg-6 order-md-1 mb-4 text-center">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Level leaderboard</h4>
                <p>Top 20 highest level users!</p>
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Username</th>
                                <th scope="col">Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rank = 1;
                            foreach ($topLevel as $u) {
                                echo '<tr><th scope="row">' . $rank++ . '</th><td class="username-rank">' . $u["username"] . '</td><td>' . $u["level"] . '</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php if ($settings['activity_contest_reward'] != "") {
        $rewards = explode('|', $settings['activity_contest_reward'])
    ?>
        <div class="col-12 col-md-6 col-lg-6 order-md-1 mb-4 text-center">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title mb-4">Activity contest leaderboard</h4>
                    <p>Top 20 claimers of this week! Your exp earned this week: <?= $user['claims'] ?></p>
                    <div class="table-responsive">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Level</th>
                                    <th scope="col">Exp</th>
                                    <th scope="col">Reward</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rank = 0;
                                foreach ($topClaimer as $u) {
                                    $reward = $rank < count($rewards) ? $rewards[$rank] : 0;
                                    echo '<tr><th scope="row">' . ++$rank . '</th><td class="username-rank">' . $u["username"] . '</td><td>' . $u["level"] . '</td><td>' . $u["claims"] . '</td><td>' . currency($reward, $settings['currency_rate']) . '</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($settings['referral_contest_reward'] != "") {
        $rewards = explode('|', $settings['referral_contest_reward'])
    ?>
        <div class="col-12 col-md-6 col-lg-6 order-md-1 mb-4 text-center">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title mb-4">Referral contest leaderboard</h4>
                    <p>Top 20 users of referral contest! Your referrals this week: <?= $user['ref_count'] ?></p>
                    <div class="table-responsive">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Level</th>
                                    <th scope="col">Referral</th>
                                    <th scope="col">Reward</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rank = 0;
                                foreach ($topReferral as $u) {
                                    $reward = $rank < count($rewards) ? $rewards[$rank] : 0;
                                    echo '<tr><th scope="row">' . ++$rank . '</th><td class="username-rank">' . $u["username"] . '</td><td>' . $u["level"] . '</td><td>' . $u["ref_count"] . '</td><td>' . currency($reward, $settings['currency_rate']) . '</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($settings['faucet_contest_reward'] != "") {
        $rewards = explode('|', $settings['faucet_contest_reward'])
    ?>
        <div class="col-12 col-md-6 col-lg-6 order-md-1 mb-4 text-center">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title mb-4">Faucet contest leaderboard</h4>
                    <p>Top 20 users of faucet contest! Your faucet claim this week: <?= $user['faucet_count_tmp'] ?></p>
                    <div class="table-responsive">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Level</th>
                                    <th scope="col">Claims</th>
                                    <th scope="col">Reward</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rank = 0;
                                foreach ($topFaucet as $u) {
                                    $reward = $rank < count($rewards) ? $rewards[$rank] : 0;
                                    echo '<tr><th scope="row">' . ++$rank . '</th><td class="username-rank">' . $u["username"] . '</td><td>' . $u["level"] . '</td><td>' . $u["faucet_count_tmp"] . '</td><td>' . currency($reward, $settings['currency_rate']) . '</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($settings['shortlink_contest_reward'] != "") {
        $rewards = explode('|', $settings['shortlink_contest_reward'])
    ?>
        <div class="col-12 col-md-6 col-lg-6 order-md-1 mb-4 text-center">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title mb-4">Shortlink contest leaderboard</h4>
                    <p>Top 20 users of shortlink contest! Your shortlink claim this week: <?= $user['shortlink_count_tmp'] ?></p>
                    <div class="table-responsive">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Level</th>
                                    <th scope="col">Claims</th>
                                    <th scope="col">Reward</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rank = 0;
                                foreach ($topShortlink as $u) {
                                    $reward = $rank < count($rewards) ? $rewards[$rank] : 0;
                                    echo '<tr><th scope="row">' . ++$rank . '</th><td class="username-rank">' . $u["username"] . '</td><td>' . $u["level"] . '</td><td>' . $u["shortlink_count_tmp"] . '</td><td>' . currency($reward, $settings['currency_rate']) . '</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($settings['offerwall_contest_reward'] != "") {
        $rewards = explode('|', $settings['offerwall_contest_reward'])
    ?>
        <div class="col-12 col-md-6 col-lg-6 order-md-1 mb-4 text-center">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title mb-4">Offerwall contest leaderboard</h4>
                    <p>Top 20 users of offerwall contest! Your offerwall claim this week: <?= $user['offerwall_count_tmp'] ?></p>
                    <div class="table-responsive">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Level</th>
                                    <th scope="col">Claims</th>
                                    <th scope="col">Reward</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rank = 0;
                                foreach ($topOfferwall as $u) {
                                    $reward = $rank < count($rewards) ? $rewards[$rank] : 0;
                                    echo '<tr><th scope="row">' . ++$rank . '</th><td class="username-rank">' . $u["username"] . '</td><td>' . $u["level"] . '</td><td>' . $u["offerwall_count_tmp"] . '</td><td>' . currency($reward, $settings['currency_rate']) . '</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>