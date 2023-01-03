<a href="<?= site_url('admin/overview/clear_history') ?>" class="btn btn-danger bttn-lg mb-2">Clear History</a>
<div class="row">
    <div class="col-md-6 col-xl-3 mb-3 mb-xl-3">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <p class="lh-1 mb-1 font-weight-bold"><?= $info['totalUser'] ?></p>
                        <p class="mb-0">users</p>
                    </div>

                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                        <span class="avatar-title">
                            <i class="fas fa-users fa-2x text-white"></i>
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
                        <p class="lh-1 mb-1 font-weight-bold"><?= $info['totalBalance'] ?></p>
                        <p class="mb-0">USD</p>
                    </div>

                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                        <span class="avatar-title">
                            <i class="fas fa-wallet fa-2x text-white"></i>
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
                        <p class="lh-1 mb-1 font-weight-bold"><?= $info['activeToday'] ?></p>
                        <p class="mb-0">users active today</p>
                    </div>

                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                        <span class="avatar-title">
                            <i class="fas fa-user-check text-white fa-2x"></i>
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
                        <p class="lh-1 mb-1 font-weight-bold"><?= $info['registerToday'] ?></p>
                        <p class="mb-0">new users today</p>
                    </div>

                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                        <span class="avatar-title">
                            <i class="fas fa-user-plus fa-2x text-white"></i>
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
                        <p class="lh-1 mb-1 font-weight-bold"><?= $pendingWithdrawal ?></p>
                        <p class="mb-0">pending withdrawals <a target="_blank" class="btn btn-info btn-sm" href="<?= site_url('admin/withdraw/pending') ?>">Check</a></p>
                    </div>

                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                        <span class="avatar-title">
                            <i class="fas fa-hand-holding-usd fa-2x text-white"></i>
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
                        <p class="lh-1 mb-1 font-weight-bold"><?= $pendingSubmissions ?></p>
                        <p class="mb-0">pending task submissions <a target="_blank" class="btn btn-info btn-sm" href="<?= site_url('admin/tasks/submissions') ?>">Check</a></p>
                    </div>

                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                        <span class="avatar-title">
                            <i class="fas fa-tasks"></i>
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
                        <p class="lh-1 mb-1 font-weight-bold"><?= $pendingOfferwall ?></p>
                        <p class="mb-0">pending offerwalls <a target="_blank" class="btn btn-info btn-sm" href="<?= site_url('admin/offerwalls/pending') ?>">Check</a></p>
                    </div>

                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                        <span class="avatar-title">
                            <i class="far fa-newspaper fa-2x text-white"></i>
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
                        <p class="lh-1 mb-1 font-weight-bold"><?= $pendingCampaigns ?></p>
                        <p class="mb-0">pending campaigns <a target="_blank" class="btn btn-info btn-sm" href="<?= site_url('admin/advertise/pending') ?>">Check</a></p>
                    </div>

                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                        <span class="avatar-title">
                            <i class="fas fa-user-tie fa-2x text-white"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Last 7 days stats - Overall</h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="chart">
                            <canvas id="chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Last 5 days stats - Shortlink</h4>
                <div class="chart">
                    <canvas id="linkChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h4 class="card-title mb-4">Deposit history</h4>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Username</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($todayDeposit as $deposit) {
                                        if ($deposit['type'] == 1) {
                                            echo '<tr><td scope="row">' . $deposit["username"] . '</td><td>Faucetpay: ' . $deposit["code"] . '</td><td>' . $deposit["status"] . '</td><td>' . $deposit["amount"] . ' USD</td><td>' . timespan($deposit["create_time"], time(), 2) . ' ago</td></tr>';
                                        } else if ($deposit['type'] == 2) {
                                            echo '<tr><td scope="row">' . $deposit["username"] . '</td><td>Coinbase: <a target="_blank" href="https://commerce.coinbase.com/charges/' . $deposit["code"] . '">' . $deposit["code"] . '</a></td><td>' . $deposit["status"] . '</td><td>' . $deposit["amount"] . ' USD</td><td>' . timespan($deposit["create_time"], time(), 2) . ' ago</td></tr>';
                                        } else {
                                            echo '<tr><td scope="row">' . $deposit["username"] . '</td><td>Payeer: ' . $deposit["code"] . '</td><td>' . $deposit["status"] . '</td><td>' . $deposit["amount"] . ' USD</td><td>' . timespan($deposit["create_time"], time(), 2) . ' ago</td></tr>';
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h4 class="card-title mb-4">Recent cheat logs</h4>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Username</th>
                                        <th scope="col">Logs</th>
                                        <th scope="col">Ip Address</th>
                                        <th scope="col">Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($logs as $log) {
                                        echo '<tr>
                                        <td scope="row"><a href="' . site_url('/admin/users/details/' . $log['user_id']) . '" target="_blank">' . $log["username"] . '</a></td>
                                        <td>' . $log["log"] . '</td>
                                        <td><a target="_blank" href="' . site_url('admin/users/find_ip/' . $log['ip_address']) . '">' . $log['ip_address'] . ' <i class="fas fa-search"></i></a></td>
                                        <td>' . timespan($log["create_time"], time(), 2) . ' ago</td>
                                        </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>