<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Update your account</h4>
                <div class="alert alert-warning text-center">Dear users, we have updated the faucet to serve you better. Your balance has been converted to USD. Please update your <b>username</b> to continue using the faucet!<br>You don't lose anything include your referrals.</div>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('migration/update') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <input type="hidden" name="<?= $csrf_name ?>" id="token" value="<?= $csrf_hash ?>">
                        <label for="username" class="col-sm-3 col-form-label">Your username</label>
                        <div class="col-sm-9">
                            <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" pattern="^[a-zA-Z]{1,1}[a-zA-Z0-9_]{2,13}[a-zA-Z0-9]{1,1}$" title="Username should only contain lowercase letters, numbers and _. e.g. tungaqhd_1234" required>
                        </div>
                    </div>

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Change</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>