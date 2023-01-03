<div class="ads">
    <?= $settings['achievements_top_ad'] ?>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Achievements</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <?= faucet_alert('info', 'Progress will refresh at 00:00 UTC daily') ?>
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Achievement</th>
                                <th>Reward</th>
                                <th>Progress</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($achievements as $achievement) { ?>
                                <tr>
                                    <td><?= $achievement['description'] ?></td>
                                    <td>
                                        <span class="badge badge-secondary">Token : <?= currency($achievement['reward_usd'], $settings['currency_rate']) ?></span>
                                        <span class="badge badge-warning"><i class="fas fa-bolt"></i> : <?= $achievement['reward_energy'] ?></span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" role="progressbar" style="width: <?= $achievement['progress'] ?>%;" aria-valuenow="<?= $achievement['progress'] ?>" aria-valuemin="0" aria-valuemax="100"><?= $achievement['completed'] ?>/ <?= $achievement['condition'] ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="<?= site_url('achievements/claim/' . $achievement['id']) ?>" method="POST">
                                            <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">
                                            <?php if ($achievement['completed'] >= $achievement['condition']) { ?>
                                                <button type="submit" class="btn btn-dark mb-2 mr-2 rounded-circle"><i class="far fa-check-circle"></i></button>
                                            <?php } else { ?>
                                                <button disabled type="submit" class="btn btn-dark mb-2 mr-2 rounded-circle"><i class="far fa-check-circle"></i></button>
                                            <?php } ?>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
            </div>
        </div>
    </div>
</div>

<div class="ads">
    <?= $settings['achievements_footer_ad'] ?>
</div>