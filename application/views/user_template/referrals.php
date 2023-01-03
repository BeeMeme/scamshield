<div class="ads">
    <?= $settings['dashboard_top_ad'] ?>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 text-center">Your Last 100 Referrals</h4>
                <div class="alert alert-success text-center">Invite your friends and earn <?= $settings['referral'] ?>% of their earning. Your referral links is: <code><?= site_url('/?r=' . $user['id']) ?></code>.</div>
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Last active</th>
                                <th scope="col">Total earned</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($referrals as $referral) {
                                echo '<tr><th scope="row">' . $referral["username"] . '</th><td>' . timespan($referral["last_active"], time(), 2) . ' ago</td><td>' . format_money($referral["total_earned"]) . '</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>