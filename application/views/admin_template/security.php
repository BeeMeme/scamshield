<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Google Authenticator</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <ul>
                    <li>Download <b>Google Authenticator</b> from <a target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=vi&gl=US">Chplay</a> or <a target="_blank" href="https://apps.apple.com/vn/app/google-authenticator/id388497605?l=vi">Appstore</a></li>
                    <li>Scan QR Code show bellow</li>
                    <div class="">
                        <img src="<?= $auth['qrCodeUrl'] ?>" alt="qr code">
                    </div>
                    <li>Get Auth Code from your app and put in the input bellow</li>
                    <li>Click Ok</li>
                </ul>
                <?php if (empty($settings['authenticator_code'])) { ?>
                    <form action="<?= site_url('admin/security/authenticator') ?>" method="post" autocomplete="off">
                        <div class="form-group row mb-4">
                            <label class="col-sm-3 col-form-label">Your Auth Code</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="code" required>
                            </div>
                        </div>
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                        <input type="hidden" name="secret" value="<?= $auth['secret'] ?>" />
                        <button type="submit" class="btn btn-success btn-lg btn-block"><i class="fas fa-check"></i> Ok</button>
                    </form>
                <?php } else { ?>
                    <div class="alert alert-warning text-center">You have already done it!</div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>