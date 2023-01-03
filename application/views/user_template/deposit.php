<div class="ads">
    <?= $settings['dashboard_top_ad'] ?>
</div>
<?php
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
} ?>
<?php
if (isset($message)) {
    echo $message;
} ?>
<div class="alert alert-danger text-center">SPAMMING DEPOSIT FORM WILL LEAD TO IMMEDIATE SUSPENSION OF YOUR ACCOUNT!</div>
<div class="row">
    <?php if ($settings['coinbase_deposit_status'] == 'on' || $settings['payeer_status'] == 'on' || $settings['faucetpay_deposit_status'] == 'on') { ?>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-center">Deposit</h4>

                    <form action="" id="depForm" method="POST" autocomplete="off">
                        <?php
                        if (isset($_SESSION['withdraw_message'])) {
                            echo $_SESSION['withdraw_message'];
                        }
                        ?>
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

                        <div class="form-group">
                            <label>Amount :</label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group mb-2 currency-value">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">USD</span>
                                        </div>
                                        <input type="number" name="amount" id="usd" class="form-control" min="<?= $settings['coinbase_min_deposit'] ?>" step="0.000001">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="input-group mb-2">
                                        <input type="text" id="token" class="form-control text-sm-right" onchange="">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="targetCurrency">Token</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <small id="minDep"></small>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="method" id="method">
                                <?php if ($settings['faucetpay_deposit_status'] == 'on') echo '<option value="faucetpay">FaucetPay</option>'; ?>
                                <?php if ($settings['payeer_status'] == 'on') echo '<option value="payeer">Payeer</option>'; ?>
                                <?php if ($settings['coinbase_deposit_status'] == 'on') echo '<option value="coinbase">Coinbase</option>'; ?>
                            </select>
                        </div>
                    <?php }
                if ($settings['faucetpay_deposit_status'] == 'on') { ?>
                        <div id='fpCurrency'>
                            <?php if ($settings['faucetpay_currency'] == '') { ?>
                                <input type="hidden" name="currency2" value="<?= $settings['faucetpay_currency'] ?>">
                            <?php } else { ?>
                                <div class="form-group">
                                    <label for="option">Currency</label>
                                    <select class="form-control" id="currency2" name="currency2">
                                        <?php foreach ($faucetpayMethods as $method) { ?>
                                            <option value="<?= $method ?>"><?= $method ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <input type="hidden" name="merchant_username" value="<?= $settings['faucetpay_username'] ?>">
                            <input type="hidden" name="item_description" value="Deposit to <?= $settings['name'] ?>">
                            <input type="hidden" name="currency1" value="USD">
                            <input type="hidden" name="amount1" value="1">
                            <input type="hidden" name="custom" value="<?= $user['id'] ?>">
                            <input type="hidden" name="callback_url" value="<?= site_url('wh/faucetpay') ?>">
                            <input type="hidden" name="success_url" value="<?= site_url('deposit?success=true') ?>">
                            <input type="hidden" name="cancel_url" value="<?= site_url('deposit?success=false') ?>">
                        </div>
                    <?php } ?>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success">Deposit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title mb-4">Deposit history</h4>
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    } ?>
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
                                foreach ($deposits as $deposit) {
                                    if ($deposit['type'] == 1) {
                                        echo '<tr><td scope="row">Faucetpay: ' . $deposit["code"] . '</td><td>' . $deposit["status"] . '</td><td>' . currency($deposit["amount"], $settings['currency_rate']) . '</td><td>' . timespan($deposit["create_time"], time(), 2) . ' ago</td></tr>';
                                    } else if ($deposit['type'] == 2) {
                                        echo '<tr><td scope="row">Coinbase: <a target="_blank" href="https://commerce.coinbase.com/charges/' . $deposit["code"] . '">' . $deposit["code"] . '</a></td><td>' . $deposit["status"] . '</td><td>' . currency($deposit["amount"], $settings['currency_rate']) . '</td><td>' . timespan($deposit["create_time"], time(), 2) . ' ago</td></tr>';
                                    } else {
                                        echo '<tr><td scope="row">Payeer: ' . $deposit["code"] . '</td><td>' . $deposit["status"] . '</td><td>' . currency($deposit["amount"], $settings['currency_rate']) . ' USD</td><td>' . timespan($deposit["create_time"], time(), 2) . ' ago</td></tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>
<script>
    var rate = <?= $settings['currency_rate'] ?>;
    var methods = {
        faucetpay: {
            url: 'https://faucetpay.io/merchant/webscr',
            min: <?= $settings['faucetpay_min_deposit'] ?>
        },
        coinbase: {
            url: '<?= site_url('/deposit/coinbase') ?>',
            min: <?= $settings['coinbase_min_deposit'] ?>
        },
        payeer: {
            url: '<?= site_url('/deposit/payeer') ?>',
            min: <?= $settings['payeer_min_deposit'] ?>
        },
    }
</script>