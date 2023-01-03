<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Firewall</h4>
                <div class="alert alert-warning text-center">Please solve the captcha to continue!</div>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('firewall/verify') ?>" method="POST">
                    <center>
                        <?= $captcha['code'] ?>
                    </center>
                    <input type="hidden" name="captchaType" value="<?= $captcha['name'] ?>">
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary w-md">Unlock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>