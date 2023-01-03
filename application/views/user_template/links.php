<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Shorlinks Wall</h4>
                <div class="ads">
                    <?= $settings['links_top_ad'] ?>
                </div>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xl-4 mb-1 mb-xl-4">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <p class="lh-1 mb-1 font-weight-bold"><?= $countAvailableLinks ?></p>
                        <p class="mb-0">links available</p>
                    </div>

                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                        <span class="avatar-title">
                            <i class="fas fa-link text-white fa-2x"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4 mb-2 mb-xl-4">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <p class="lh-1 mb-1 font-weight-bold"><?= currency($totalReward, $settings['currency_rate']) ?></p>
                        <p class="mb-0"><?= currencyUnit($totalReward, $settings['currency_rate']) ?></p>
                    </div>

                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                        <span class="avatar-title">
                            <i class="fas fa-gifts text-white fa-2x"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4 mb-3 mb-xl-4">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <p class="lh-1 mb-1 font-weight-bold"><?= $totalEnergy ?></p>
                        <p class="mb-0">energy</p>
                    </div>

                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                        <span class="avatar-title">
                            <i class="fas fa-bolt text-warning fa-2x"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <?php
    foreach ($availableLinks as $link) { ?>
        <div class="col-lg-3">
            <div class="card card-body text-center">
                <h4 class="card-title mt-0"><?= $link['name'] ?></h4>
                <p class="card-text">Earn <?= currency($link['reward'], $settings['currency_rate']) ?> and <?= $link['energy'] ?> energy.</p>
                <?php if ($link['rmnViews'] > 0) { ?>
                    <a href="<?= base_url() . 'links/go/' . $link['id'] ?>" target="_blank" class="btn btn-primary waves-effect waves-light">Claim <span class="badge badge-info"><?= $link['rmnViews'] ?>/<?= $link['view_per_day'] ?></span></a>
                <?php } else { ?>
                    <button class="btn btn-primary waves-effect waves-light" disabled>Claim <span class="badge badge-info"><?= $link['rmnViews'] ?>/<?= $link['view_per_day'] ?></span></button>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>
<?php if (!count($availableLinks)) {
    echo '<div class="alert alert-warning text-center">There is no link left <i class="far fa-sad-cry fa-2x"></i> <i class="far fa-sad-cry fa-2x"></i> <i class="far fa-sad-cry fa-2x"></i></div>';
}
?>
<div class="ads">
    <?= $settings['links_footer_ad'] ?>
</div>