<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4"><?= $page ?></h4>
                <?php if ($wait > 0) { ?>
                    <div class="alert alert-warning text-center">Money will be credited to you within <?= $wait ?> <?= ($wait == 1) ? 'day' : 'days' ?>. You can track the transactions at <a href="<?= site_url('history') ?>">History</a>.</div>
                <?php }
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                } ?>
                <?= $iframe ?>
            </div>
        </div>
    </div>
</div>