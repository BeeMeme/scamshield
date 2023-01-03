<div class="ads">
    <?= $settings['ptc_top_ad'] ?>
</div>
<div class="row">
    <div class="col-md-6 col-xl-6 mb-1 mb-xl-6">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <p class="lh-1 mb-1 font-weight-bold"><?= $totalAds ?></p>
                        <p class="mb-0">ads available</p>
                    </div>

                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                        <span class="avatar-title">
                            <i class="fas fa-mouse text-white fa-2x"></i>
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
</div>
<div class="layout-px-spacing">
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
    }
    ?>
    <div class="row">
        <?php
        foreach ($ptcAds as $ads) { ?>
            <div class="col-sm-6" style="margin-bottom: 5px;">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $ads['name'] ?></h5>
                        <p class="card-text"><?= $ads['description'] ?></p>
                        <div class="row text-center">
                            <div class="col-md-6">
                                <span><i class="fas fa-gift"></i>: <?= currency($ads['reward'], $settings['currency_rate']) ?></span>
                            </div>
                            <div class="col-md-6">
                                <span><i class="fas fa-stopwatch"></i>: <?= $ads['timer'] ?> seconds</span>
                            </div>
                        </div>
                        <button onclick="window.location = '<?= site_url('ptc/view/' . $ads['id']) ?>'" class="btn btn-primary btn-block">Go</button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php if (!count($ptcAds)) {
        echo '<div class="alert alert-warning text-center">There is PTC Ad left <i class="far fa-sad-cry fa-2x"></i> <i class="far fa-sad-cry fa-2x"></i> <i class="far fa-sad-cry fa-2x"></i></div>';
    }
    ?>
</div>
<div class="ads">
    <?= $settings['ptc_footer_ad'] ?>
</div>