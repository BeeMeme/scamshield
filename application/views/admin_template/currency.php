<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 text-center">Currency</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/currencies/add') ?>" method="POST" autocomplete="off">
                    <input type="hidden" name="<?= $csrf_name ?>" id="token" value="<?= $csrf_hash ?>">
                    <div class="form-group">
                        <label for="name">Method Name</label>
                        <input type="text" class="form-control" id="name" name="name" id="name" placeholder="Bitcoin - FaucetPay" required="">
                    </div>
                    <div class="form-group">
                        <label for="currency_name">Currency Name</label>
                        <input type="text" class="form-control" id="currency_name" name="currency_name" placeholder="bitcoin">
                    </div>
                    <div class="form-group">
                        <label for="code">Currency Code</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="BTC">
                    </div>
                    <div class="form-group">
                        <label for="api">API</label>
                        <input type="text" class="form-control" id="api" name="api" placeholder="API for this currency">
                    </div>
                    <div class="form-group">
                        <label for="token">Token for Expresscrypto</label>
                        <input type="text" class="form-control" id="token" name="token" placeholder="Expresscrypto Token">
                    </div>
                    <div class="form-group">
                        <label for="api_id">API ID (For Payeer only)</label>
                        <input type="text" class="form-control" id="api_id" name="api_id" placeholder="Payeer API ID">
                    </div>
                    <div class="form-group">
                        <label for="account_number">Account Number (For Payeer only)</label>
                        <input type="text" class="form-control" id="account_number" name="account_number" placeholder="Payeer Account Number">
                    </div>
                    <div class="form-group">
                        <label for="wallet">Wallet</label>
                        <select class="form-control" id="wallet" name="wallet">
                            <option value="faucetpay">Faucetpay</option>
                            <option value="expresscrypto">Expresscrypto</option>
                            <option value="payeer">Payeer</option>
                            <option value="custom">Custom (You have to send it manually)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Price (in USD)</label>
                        <input type="text" class="form-control" id="price" name="price" placeholder="Price of this currency" required>
                    </div>
                    <small>The current price of the currency you are going to add, it will be updated by cronjob later.</small>
                    <div class="form-group">
                        <label for="minimum_withdrawal">Minimum Withdrawal (in USD)</label>
                        <input type="number" min="0.000001" step="0.000001" class="form-control" id="minimum_withdrawal" name="minimum_withdrawal" placeholder="Minimum Withdrawal" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg btn-block">Add</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Currencies</h4>
                <?php foreach ($currencies as $currency) { ?>
                    <form action="<?= site_url('admin/currencies/update/' . $currency['id']) ?>" method="POST">
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">
                        <div class="form-row mb-4">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" value="<?= $currency['name'] ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="currency_name">Currency Name</label>
                                    <input type="text" class="form-control" name="currency_name" value="<?= $currency['currency_name'] ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input type="text" class="form-control" name="code" value="<?= $currency['code'] ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="api">API</label>
                                    <input type="text" class="form-control" name="api" value="<?= $currency['api'] ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="token">Token</label>
                                    <input type="text" class="form-control" name="token" value="<?= $currency['token'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-row mb-4">
                            <div class="col">
                                <div class="form-group">
                                    <label for="api_id">API ID</label>
                                    <input type="text" class="form-control" name="api_id" value="<?= $currency['api_id'] ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="account_number">Account Number</label>
                                    <input type="text" class="form-control" name="account_number" value="<?= $currency['account_number'] ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="wallet">Wallet</label>
                                    <select class="form-control" id="wallet" name="wallet">
                                        <option value="faucetpay" <?= ($currency['wallet'] == 'faucetpay') ? 'selected' : '' ?>>Faucetpay</option>
                                        <option value="expresscrypto" <?= ($currency['wallet'] == 'expresscrypto') ? 'selected' : '' ?>>Expresscrypto</option>
                                        <option value="payeer" <?= ($currency['wallet'] == 'payeer') ? 'selected' : '' ?>>Payeer</option>
                                        <option value="custom" <?= ($currency['wallet'] == 'custom') ? 'selected' : '' ?>>Custom (You have to send it manually)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="statusc">Status</label>
                                    <select class="form-control" id="statusc" name="status">
                                        <option value="1" <?= ($currency['status'] == 1) ? 'selected' : '' ?>>On</option>
                                        <option value="0" <?= ($currency['status'] == 0) ? 'selected' : '' ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="token">Price</label>
                                    <input type="text" class="form-control" name="price" value="<?= $currency['price'] ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="minimum_withdrawal">Minimum Withdrawal</label>
                                    <input type="number" class="form-control" name="minimum_withdrawal" min="0.000001" step="0.000001" value="<?= $currency['minimum_withdrawal'] ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="wallet">Action</label>
                                    <div>
                                        <a type="submit" class="btn btn-danger" href="<?= site_url('admin/currencies/delete/' . $currency['id']) ?>">Delete</a>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-secondary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                <?php } ?>
            </div>
        </div>
    </div>
</div>