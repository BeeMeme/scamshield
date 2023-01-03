<div class="ads">
    <?= $settings['dashboard_top_ad'] ?>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 text-center">Transfer</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                } ?>
                <div class="alert alert-warning text-center">You can only transfer from main balance to deposit balance. This process can't be reversed!</div>
                <form action="<?= site_url('/account/transfer_balance') ?>" method="POST">
                    <label>Amount</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="number" class="form-control form-control-icon-img" name="amount" autocomplete="off" min="0.000001" max="<?= $user['balance'] / $settings['currency_rate'] ?>" step="0.000001" required>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" id="token" value="<?= $csrf_hash ?>">
                    <button type="submit" class="btn btn-success btn-block">Transfer</button>
                </form>
            </div>
        </div>
    </div>
</div>