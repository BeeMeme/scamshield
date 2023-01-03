<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">User info</h4>
                <form action="<?= site_url('admin/users/update/' . $user['id']) ?>" method="POST" autocomplete="off">
                    <div class="table-responsive">
                        <table class="table table-striped text-center table-bordered">
                            <tbody>
                                <tr>
                                    <th>Id:</th>
                                    <th><?= $user['id'] ?></th>
                                    <th>Email:</th>
                                    <th><input class="form-control form-control-sm" type="email" name="email" value="<?= $user['email'] ?>" required></th>
                                    <th>Username:</th>
                                    <th><input class="form-control form-control-sm" type="text" name="username" value="<?= $user['username'] ?>" required></th>
                                    <th>Ip Address:</th>
                                    <th><input class="form-control form-control-sm" type="text" name="ip_address" value="<?= $user['ip_address'] ?>" required></th>
                                </tr>
                                <tr>
                                    <th>Exp:</th>
                                    <th><input class="form-control form-control-sm" type="number" name="exp" value="<?= $user['exp'] ?>" required></th>
                                    <th>Level:</th>
                                    <th><input class="form-control form-control-sm" type="number" name="level" value="<?= $user['level'] ?>" required></th>
                                    <th>Reffered By:</th>
                                    <th>
                                        <div class="input-group"><input class="form-control form-control-sm" type="number" name="referred_by" value="<?= $user['referred_by'] ?>" required><span class="input-group-btn input-group-append"><a class="btn btn-info btn-sm" href="<?= site_url('admin/users/details/' . $user['referred_by']) ?>"><i class="fas fa-external-link-alt"></i></a></span></div>
                                    </th>
                                    <th>Verified:</th>
                                    <th>
                                        <div class="input-group"><input class="form-control form-control-sm" type="number" name="verified" value="<?= $user['verified'] ?>" required><span class="input-group-btn input-group-append"><button type="button" class="btn btn-info btn-sm"><?= ($user['verified'] == '1') ? 'Yes' : 'No' ?></button></span></div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <th>
                                        <select name="status" style="max-width: 100px">
                                            <option value="active" <?= $user['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="suspect" <?= $user['status'] == 'suspect' ? 'selected' : '' ?>>Suspect</option>
                                            <option value="banned" <?= $user['status'] == 'banned' ? 'selected' : '' ?>>Banned</option>
                                        </select>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Wallet:</th>
                                    <th><input class="form-control form-control-sm" type="text" name="wallet" value="<?= $user['wallet'] ?>"></th>
                                    <th>Balance:</th>
                                    <th><input class="form-control form-control-sm" type="number" min="0" step="0.000001" name="balance" value="<?= $user['balance'] ?>" required></th>
                                    <th>Deposit Balance:</th>
                                    <th><input class="form-control form-control-sm" type="number" min="0" step="0.000001" name="dep_balance" value="<?= $user['dep_balance'] ?>" required></th>
                                    <th>Energy:</th>
                                    <th><input class="form-control form-control-sm" type="number" min="0" name="energy" value="<?= $user['energy'] ?>" required></th>
                                </tr>
                                <tr>
                                    <th>Faucet claims:</th>
                                    <th><input class="form-control form-control-sm" type="number" name="faucet_count" value="<?= $user['faucet_count'] ?>" required></th>
                                    <th>Shortlink claims:</th>
                                    <th><input class="form-control form-control-sm" type="number" name="shortlink_count" value="<?= $user['shortlink_count'] ?>" required></th>
                                    <th>Offerwall claims:</th>
                                    <th><input class="form-control form-control-sm" type="number" name="offerwall_count" value="<?= $user['offerwall_count'] ?>" required></th>
                                    <th>Referral count:</th>
                                    <th><input class="form-control form-control-sm" type="number" name="ref_count" value="<?= $user['ref_count'] ?>" required></th>
                                </tr>
                                <tr>
                                    <th>Total earned:</th>
                                    <th><input class="form-control form-control-sm" type="number" min="0" step="0.000001" name="total_earned" value="<?= $user['total_earned'] ?>" required></th>
                                    <th>Country:</th>
                                    <th><?= ($user['isocode'] != 'N/A') ? '<img src="' . base_url() . 'assets/images/flags/' . $user['isocode'] . '.png" title="' . $user['country'] . '">' : 'N/A' ?></th>
                                    <th>Joined:</th>
                                    <th><?= timespan($user['joined'], time(), 2) ?> ago</th>
                                    <th>Last Active:</th>
                                    <th><?= timespan($user['last_active'], time(), 2) ?> ago</th>
                                </tr>
                                <tr>
                                    <th>Referral Source:</th>
                                    <th>
                                        <?php if ($user['referral_source'] != 'direct') { ?>
                                            <a href="<?= $user['referral_source'] ?>"><?= $user['referral_source'] ?></a>
                                        <?php } else {
                                            echo '<b>direct</b>';
                                        } ?>
                                    </th>
                                    <th>Total lotteries:</th>
                                    <th><?= $countLotteries ?> <?= $countLotteries > 0 ? 'lotteries' : 'lottery' ?></th>
                                    <th>Total referrals:</th>
                                    <th><?= $countReferrals ?> <?= $countReferrals > 0 ? 'referrals' : 'referral' ?></th>
                                    <th>Actions:</th>
                                    <th><a href="<?= site_url("/admin/users/unban/" . $user['id']) ?>" class="btn btn-success btn-sm" title="Unban"><i class="fas fa-ban"></i></a><a href="<?= site_url("/admin/users/active/" . $user['id']) ?>" class="btn btn-primary btn-sm" title="Active"><i class="fas fa-user-check"></i></a><a href="<?= site_url("/admin/users/delete_logs/" . $user['id']) ?>" class="btn btn-warning btn-sm" title="Delete Logs"><i class="fas fa-eraser"></i></a><button type="submit" class="btn btn-primary">Update</button></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Ban User</h4>

                <form action="<?= site_url('admin/users/ban/' . $user['id']) ?>" method="POST">
                    <div class="form-group">
                        <label>Reason (Default: Banned by admin)</label>
                        <textarea class="form-control" rows="3" name="reason"></textarea>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                    <button class="btn btn-danger btn-block"><i class="fas fa-ban"></i> Ban</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Message User</h4>

                <form action="<?= site_url('admin/users/send_message/' . $user['id']) ?>" method="POST">
                    <div class="form-group">
                        <label>Message</label>
                        <textarea class="form-control" rows="3" name="message"></textarea>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                    <button class="btn btn-success btn-block">Send</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">User activity</h4>
                <div class="nav-wrapper">
                    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-faucet" data-toggle="tab" href="#faucet" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">Faucet</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-wheel" data-toggle="tab" href="#wheel" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">Wheel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-other_history" data-toggle="tab" href="#other_history" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">Other</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-shortlinks" data-toggle="tab" href="#shortlinks" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">Shortlinks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-ptc" data-toggle="tab" href="#ptc" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false">PTC</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-offerwall" data-toggle="tab" href="#offerwall" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false">Offerwall</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-withdrawals" data-toggle="tab" href="#withdrawals" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false">Withdrawals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-deposit" data-toggle="tab" href="#deposit" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false">Deposit</a>
                        </li>
                    </ul>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="faucet" role="tabpanel" aria-labelledby="tabs-faucet">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">IP Address</th>
                                                <th scope="col">Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($faucet_history as $value) {
                                                echo '<tr><th scope="row">' . $value["id"] . '</th><td>' . $value["amount"] . '</td><td>' . $value["ip_address"] . '</td><td>' . timespan($value["claim_time"], time(), 2) . ' ago</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="wheel" role="tabpanel" aria-labelledby="tabs-wheel">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($wheel_history as $value) {
                                                echo '<tr><th scope="row">' . $value["id"] . '</th><td>' . $value["amount"] . '</td><td>' . timespan($value["claim_time"], time(), 2) . ' ago</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="other_history" role="tabpanel" aria-labelledby="tabs-other_history">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($other_history as $value) {
                                                echo '<tr><th scope="row">' . $value["id"] . '</th><td>' . $value["name"] . '</td><td>' . $value["amount"] . '</td><td>' . timespan($value["claim_time"], time(), 2) . ' ago</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="shortlinks" role="tabpanel" aria-labelledby="tabs-shortlinks">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">IP Address</th>
                                                <th scope="col">Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($shortlinks_history as $value) {
                                                echo '<tr><th scope="row">' . $value["id"] . '</th><td>' . $value["amount"] . '</td><td>' . $value["ip_address"] . '</td><td>' . timespan($value["claim_time"], time(), 2) . ' ago</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="ptc" role="tabpanel" aria-labelledby="tabs-ptc">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">IP Address</th>
                                                <th scope="col">Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($ptc_history as $value) {
                                                echo '<tr><th scope="row">' . $value["id"] . '</th><td>' . $value["amount"] . '</td><td>' . $value["ip_address"] . '</td><td>' . timespan($value["claim_time"], time(), 2) . ' ago</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="offerwall" role="tabpanel" aria-labelledby="tabs-offerwall">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Offerwall</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Complete on</th>
                                                <th scope="col">Release in</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($offerwall_history as $value) {
                                                $release =  timespan(time(), $value["available_at"], 2);
                                                if ($release == '1 Second') {
                                                    $release = '<span class="badge badge-success">Released</span>';
                                                }
                                                switch ($value['status']) {
                                                    case 0:
                                                        $value['status'] = '<span class="badge badge-pill badge-info">Pending</span>';
                                                        break;
                                                    case 1:
                                                        $value['status'] = '<span class="badge badge-pill badge-danger">Cancelled</span>';
                                                        break;
                                                    case 2:
                                                        $value['status'] = '<span class="badge badge-pill badge-success">Approved</span>';
                                                        break;
                                                }
                                                echo '<tr><th scope="row">' . $value["id"] . '</th><td>' . ucfirst($value["offerwall"]) . '</td><td>' . format_money($value["amount"]) . '</td><td>' . $value["status"] . '</td><td>' . timespan($value["claim_time"], time(), 2) . ' ago</td><td>' . $release . '</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="deposit" role="tabpanel" aria-labelledby="tabs-deposit">

                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">Code</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($deposit_history as $deposit) {
                                                if ($deposit['type'] == 1) {
                                                    echo '<tr><td scope="row">Faucetpay: ' . $deposit["code"] . '</td><td>' . $deposit["status"] . '</td><td>' . $deposit["amount"] . ' USD</td><td>' . timespan($deposit["create_time"], time(), 2) . ' ago</td></tr>';
                                                } else {
                                                    echo '<tr><td scope="row">Coinbase: <a target="_blank" href="https://commerce.coinbase.com/charges/' . $deposit["code"] . '">' . $deposit["code"] . '</a></td><td>' . $deposit["status"] . '</td><td>' . $deposit["amount"] . ' USD</td><td>' . timespan($deposit["create_time"], time(), 2) . ' ago</td></tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="withdrawals" role="tabpanel" aria-labelledby="tabs-withdrawals">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">IP Address</th>
                                                <th scope="col">Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($withdrawals_history as $value) {
                                                switch ($value['type']) {
                                                    case 0:
                                                        $value['type'] = '<span class="badge badge-pill badge-warning">Pending Withdraw</span>';
                                                        break;
                                                    case 1:
                                                        $value['type'] = '<span class="badge badge-pill badge-info">Approved Withdraw</span>';
                                                        break;
                                                }
                                                echo '<tr><th scope="row">' . $value["id"] . '</th><td>' . $value["type"] . '</td><td>' . $value["amount"] . '</td><td>' . $value["ip_address"] . '</td><td>' . timespan($value["claim_time"], time(), 2) . ' ago</td></tr>';
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
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Cheat logs</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center" style="font-size: 15px;">
                        <thead>
                            <tr>
                                <th scope="col">Logs</th>
                                <th scope="col">IP Address</th>
                                <th scope="col">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $log) { ?>
                                <tr>
                                    <th scope="row"><?= $log['log'] ?></th>
                                    <th><a target="_blank" href="<?= site_url('admin/users/find_ip/' . $log['ip_address']) ?>"><?= $log['ip_address'] ?> <i class="fas fa-search"></i></a></th>
                                    <td><?= timespan($log["create_time"], time(), 2) ?> ago</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Referrals</h4>
                <div class="table-responsive">
                    <table class="table table-striped" style="font-size: 15px;">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Email</th>
                                <th scope="col">Username</th>
                                <th scope="col">Balance</th>
                                <th scope="col">Ip Address</th>
                                <th scope="col">Level</th>
                                <th scope="col">Verified</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 12px;">
                            <?php foreach ($referrals as $referral) { ?>
                                <tr>
                                    <th scope="row"><?= $referral['id'] ?></th>
                                    <td><?= $referral['email'] ?></td>
                                    <td><?= $referral['username'] ?></td>
                                    <td><?= $referral['balance'] ?></td>
                                    <td><?= $referral['ip_address'] ?></td>
                                    <td><?= $referral['level'] ?></td>
                                    <td><?= $referral['verified'] ?></td>
                                    <td><a href="<?= site_url("/admin/users/unban/" . $referral['id']) ?>" class="btn btn-success btn-sm" title="Unban"><i class="fas fa-ban"></i></a><a href="<?= site_url("/admin/users/ban/" . $referral['id']) ?>" class="btn btn-danger btn-sm" title="Ban"><i class="fas fa-ban"></i></a><a href="<?= site_url("/admin/users/active/" . $referral['id']) ?>" class="btn btn-default btn-sm" title="Active"><i class="fas fa-user-check"></i></a><a href="<?= site_url("/admin/users/details/" . $referral['id']) ?>" class="btn btn-default btn-sm" title="Detail"><i class="fas fa-user-cog"></i></a><a href="<?= site_url("/admin/users/delete_logs/" . $referral['id']) ?>" class="btn btn-default btn-sm" title="Delete Logs"><i class="fas fa-eraser"></i></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>