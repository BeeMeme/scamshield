<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Deposit settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/deposit') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Coinbase Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="coinbase_deposit_status">
                                <option value="on" <?= ($settings['coinbase_deposit_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['coinbase_deposit_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Coinbase API</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="coinbase_api" value="<?= $settings['coinbase_api'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="horizontal-email-input" class="col-sm-3 col-form-label">CoinBase secret</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="coinbase_secret" value="<?= $settings['coinbase_secret'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="horizontal-password-input" class="col-sm-3 col-form-label">CoinBase Minimum deposit</label>
                        <div class="col-sm-9">
                            <input type="number" min="0.000001" step="0.000001" class="form-control" name="coinbase_min_deposit" value="<?= $settings['coinbase_min_deposit'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="horizontal-email-input" class="col-sm-3 col-form-label">FaucetPay Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="faucetpay_deposit_status">
                                <option value="on" <?= ($settings['faucetpay_deposit_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['faucetpay_deposit_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="horizontal-email-input" class="col-sm-3 col-form-label">FaucetPay Username</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="faucetpay_username" value="<?= $settings['faucetpay_username'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="horizontal-email-input" class="col-sm-3 col-form-label">FaucetPay Supported Currency</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="faucetpay_currency" value="<?= $settings['faucetpay_currency'] ?>">
                            <small>Leave blank to accept all currencies! If you accept multiple currencies, separated them by comma like: BTC,ETH,DOGE</small>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="horizontal-password-input" class="col-sm-3 col-form-label">FaucetPay Minimum deposit</label>
                        <div class="col-sm-9">
                            <input type="number" min="0.000001" step="0.000001" class="form-control" name="faucetpay_min_deposit" value="<?= $settings['faucetpay_min_deposit'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Payeer Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="payeer_status">
                                <option value="on" <?= ($settings['payeer_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['payeer_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Payeer ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="payeer_id" value="<?= $settings['payeer_id'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="horizontal-email-input" class="col-sm-3 col-form-label">Payeer secret</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="payeer_secret" value="<?= $settings['payeer_secret'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="horizontal-password-input" class="col-sm-3 col-form-label">Payeer Minimum deposit</label>
                        <div class="col-sm-9">
                            <input type="number" min="0.001" step="0.001" class="form-control" name="payeer_min_deposit" value="<?= $settings['payeer_min_deposit'] ?>">
                        </div>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>