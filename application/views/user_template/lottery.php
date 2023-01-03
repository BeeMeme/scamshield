<div class="ads">
    <?= $settings['lottery_top_ad'] ?>
</div>
<div class="row">
    <div class="col-md-6 col-xl-6 mb-1 mb-xl-6">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <p class="lh-1 mb-1 font-weight-bold"><?= timespan(time(), $settings['lottery_date'], 2) ?></p>
                        <p class="mb-0">until roll</p>
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
    <div class="col-md-6 col-xl-6 mb-2 mb-xl-6">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <p class="lh-1 mb-1 font-weight-bold"><?= currency($current_reward, $settings['currency_rate']) ?></p>
                        <p class="mb-0">reward for lucky ticket</p>
                    </div>

                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                        <span class="avatar-title">
                            <i class="fas fa-star text-white fa-2x"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-8 col-lg-6 order-md-2 mb-4">

        <?php if (time() >= $settings['lottery_date']) { ?>
            <div class="alert alert-info text-center">This round has ended</div>
        <?php } else { ?>
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title mb-4">Buy tickets</h4>
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                    ?>
                    <form action="<?= site_url('/lottery/buy') ?>" method="POST" autocomplete="off">
                        <input type="hidden" name="<?= $csrf_name ?>" id="token" value="<?= $csrf_hash ?>">
                        <input type="number" class="form-control lottery-amount" id="lotteryAmount" name="amount" type="text" placeholder="Amount of tickets" min="1" value="1" required />
                        <button class="btn btn-success" id="buyButton">Buy 1 ticket with <?= currency($settings['lottery_price'], $settings['currency_rate']) ?></button>
                    </form>
                    <script>
                        var lotteryPrice = <?= $settings['lottery_price'] / $settings['currency_rate'] ?>;
                    </script>
                </div>
            </div>
        <?php } ?>
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Your last 10 Lotteries</h4>
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Number</th>
                                <th scope="col">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($lotteries as $value) {
                                echo '<tr><th scope="row">' . $value["id"] . '</th><td><span class="badge badge-success">' . $value["number"] . '</span></td><td>' . timespan($value["create_time"], time(), 2) . ' ago</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Last 10 winners</h4>
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Number</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($winners as $value) {
                                echo '<tr><th scope="row">' . $value["username"] . '</th><td><span class="badge badge-success">' . $value["number"] . '</span></td><td>' . currency($value["amount"], $settings['currency_rate']) . '</td><td>' . timespan($value["create_time"], time(), 2) . ' ago</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2 col-lg-3 order-md-1 p-0 left-ads"><?= $settings['lottery_left_ad'] ?></div>
    <div class="col-6 col-md-2 col-lg-3 order-md-3 p-0 right-ads"><?= $settings['lottery_right_ad'] ?></div>
</div>