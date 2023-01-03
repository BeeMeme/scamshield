<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-md-6">
            <!-- begin general -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">General Settings</h3>
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                    ?>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('admin/update/favicon') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                        <div class="form-group">
                            <label for="favicon">Select your favicon</label>
                            <input type="file" class="form-control-file" id="favicon" name="favicon" accept=".ico">
                            <button type="submit" class="btn btn-sm btn-warning">Change</button>
                            <p>Generate your icon at <a href="https://www.favicon-generator.org/" target="_blank">favicon-generator.org</a></p>
                        </div>
                    </form>
                    <form action="<?= site_url('admin/update/logo') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                        <div class="form-group">
                            <label for="logo">Select your logo</label>
                            <input type="file" class="form-control-file" id="logo" name="logo" accept=".png, .jpg">
                            <button type="submit" class="btn btn-sm btn-warning">Change</button>
                        </div>
                        <p class="muted-text">Your changes might not affect immediately because of the cache.</p>
                    </form>
                    <form action="<?= site_url('admin/update/settings') ?>" method="post">
                        <div class="form-group">
                            <label for="status">Faucet Status</label>
                            <select class="form-control" name="status">
                                <option value="on" <?= ($settings['status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="theme">Faucet Theme</label>
                            <select class="form-control" name="theme">
                                <option value="light" <?= ($settings['theme'] == 'light') ? 'selected' : '' ?>>Light</option>
                                <option value="dark" <?= ($settings['theme'] == 'dark') ? 'selected' : '' ?>>Dark</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="home_page">Home Page Template</label>
                            <select class="form-control" name="home_page">
                                <option value="1" <?= ($settings['home_page'] == '1') ? 'selected' : '' ?>>Template 1</option>
                                <option value="2" <?= ($settings['home_page'] == '2') ? 'selected' : '' ?>>Template 2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Faucet Name</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="name" value="<?= $settings['name'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Currency Name</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="currency_name" value="<?= $settings['currency_name'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Currency Rate (1 token = ? usd)</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                    </div>
                                    <input type="number" min="0.00001" step="0.00001" class="form-control" name="currency_rate" value="<?= $settings['currency_rate'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Faucet Description</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-newspaper"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="description" value="<?= $settings['description'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Admin Username</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="admin_username" value="<?= $settings['admin_username'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Global Notification</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-bullhorn"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="global_notification" value="<?= $settings['global_notification'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="instant_withdraw"><i class="fas fa-hand-holding-usd"></i> Instant Withdraw</label>
                            <select class="form-control" id="instant_withdraw" name="instant_withdraw">
                                <option value="on" <?= ($settings['instant_withdraw'] == 'on') ? 'selected' : '' ?>>Yes</option>
                                <option value="off" <?= ($settings['instant_withdraw'] == 'off') ? 'selected' : '' ?>>No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Daily withdraw limit</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-funnel-dollar"></i></span>
                                    </div>
                                    <input type="number" min="0.000001" step="0.000001" class="form-control" name="withdraw_limit" value="<?= $settings['withdraw_limit'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Referral Comission (%)</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-users"></i></span>
                                    </div>
                                    <input type="number" class="form-control" name="referral" value="<?= $settings['referral'] ?>">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                        <button class="btn btn-success btn-lg btn-block" name="overview"><i class="fas fa-check"></i> Update</button>
                    </form>
                </div>
            </div>
            <!-- end general -->

            <!-- begin email -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Email Settings</h3>
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                    ?>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('admin/update/settings') ?>" method="post">
                        <div class="form-group">
                            <label for="mail_service"><i class="far fa-envelope"></i> Email Service</label>
                            <select class="form-control" name="mail_service">
                                <option value="mail" <?= ($settings['mail_service'] == 'mail') ? 'selected' : '' ?>>Mail Function</option>
                                <option value="smtp" <?= ($settings['mail_service'] == 'smtp') ? 'selected' : '' ?>>SMTP</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">SMTP Host (If you are using SMTP mail)</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-server"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="smtp_host" value="<?= $settings['smtp_host'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">SMTP Port (If you are using SMTP mail)</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-network-wired"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="smtp_port" value="<?= $settings['smtp_port'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">SMPT Username (If you are using SMTP mail)</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="smtp_username" value="<?= $settings['smtp_username'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">SMTP Password (If you are using SMTP mail)</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="smtp_password" value="<?= $settings['smtp_password'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Site Email</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@</span>
                                    </div>
                                    <input type="email" class="form-control" name="site_email" value="<?= $settings['site_email'] ?>">
                                </div>
                            </div>
                        </div>
                        <small>It should be admin@yourfauceturl.com</small>
                        <div class="form-group">
                            <label class="control-label">Admin Email</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@</span>
                                    </div>
                                    <input type="email" class="form-control" name="admin_email" value="<?= $settings['admin_email'] ?>">
                                </div>
                            </div>
                        </div>
                        <small>Your personal email address.</small>
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                        <button class="btn btn-success btn-lg btn-block" name="overview"><i class="fas fa-check"></i> Update</button>
                    </form>
                </div>
            </div>
            <!-- end general -->


            <!-- begin advertisement -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Advertisement Settings</h3>

                </div>
                <div class="card-body">
                    <form action="<?= site_url('admin/update/settings') ?>" method="post">
                        <div class="form-group">
                            <label for="footer">Dashboard Top Ad</label>
                            <textarea class="form-control" id="dashboard_top_ad" rows="6" name="dashboard_top_ad"><?= $settings['dashboard_top_ad'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="footer">Dashboard Header Ad</label>
                            <textarea class="form-control" id="dashboard_header_ad" rows="6" name="dashboard_header_ad"><?= $settings['dashboard_header_ad'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="footer">Dashboard Bottom Ad</label>
                            <textarea class="form-control" id="dashboard_bottom_ad" rows="6" name="dashboard_bottom_ad"><?= $settings['dashboard_bottom_ad'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="footer">Login Ad</label>
                            <textarea class="form-control" id="login_ad" rows="6" name="login_ad"><?= $settings['login_ad'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="footer">Register Ad</label>
                            <textarea class="form-control" id="register_ad" rows="6" name="register_ad"><?= $settings['register_ad'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="footer">Footer Code</label>
                            <textarea class="form-control" id="footer_code" rows="6" name="footer_code"><?= $settings['footer_code'] ?></textarea>
                        </div>
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                        <button class="btn btn-success btn-lg btn-block"><i class="fas fa-check"></i> Update</button>
                    </form>
                </div>
            </div>
            <!-- end advertisement -->


        </div>
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Security Settings</h3>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('admin/update/settings') ?>" method="post">
                        <div class="form-group">
                            <label for="firewall"><i class="fas fa-shield-alt"></i> Firewall</label>
                            <select class="form-control" name="firewall">
                                <option value="on" <?= ($settings['firewall'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['firewall'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                        <small>User has to solve a random captcha after 15-25 minutes!</small>
                        <hr>
                        <div class="form-group">
                            <label class="control-label">Captcha fail limit</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-robot"></i></span>
                                    </div>
                                    <input type="number" class="form-control" name="captcha_fail_limit" value="<?= $settings['captcha_fail_limit'] ?>" required>
                                </div>
                            </div>
                        </div>
                        <small>Users are banned if they make too many captcha fails in a row.</small>
                        <hr>
                        <div class="form-group">
                            <label class="control-label">Ban emails</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@</span>
                                    </div>
                                    <input type="text" class="form-control" name="banned_mails" placeholder="Example: rambler.ru,tinaksu.com" value="<?= $settings['banned_mails'] ?>">
                                </div>
                            </div>
                        </div>
                        <small>Each domain separated by a comma.</small>
                        <hr>
                        <p>Availabe captcha systems: <code>recaptchav3</code>|<code>recaptchav2</code>|<code>solvemedia</code>|<code>hcaptcha</code>, each captcha seperated by <code>|</code></p>
                        <div class="form-group">
                            <label class="control-label">Login Captcha</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="login_captcha" value="<?= $settings['login_captcha'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Register Captcha</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="register_captcha" value="<?= $settings['register_captcha'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Faucet Captcha</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="faucet_captcha" value="<?= $settings['faucet_captcha'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">PTC Captcha</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="ptc_captcha" value="<?= $settings['ptc_captcha'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Recaptcha V3 Site Key</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="recaptcha_v3_site_key" value="<?= $settings['recaptcha_v3_site_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Recaptcha V3 Secret Key</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="recaptcha_v3_secret_key" value="<?= $settings['recaptcha_v3_secret_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Recaptcha V2 Site Key (Don't work along with Hcaptcha)</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="recaptcha_v2_site_key" value="<?= $settings['recaptcha_v2_site_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Recaptcha V2 Secret Key</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="recaptcha_v2_secret_key" value="<?= $settings['recaptcha_v2_secret_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Hcaptcha Site Key (Don't work along with Recaptcha V2)</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="hcaptcha_site_key" value="<?= $settings['hcaptcha_site_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Hcaptcha Secret Key</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="hcaptcha_secret_key" value="<?= $settings['hcaptcha_secret_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Solvemedia C Key</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="c_key" value="<?= $settings['c_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Solvemedia V Key</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="v_key" value="<?= $settings['v_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Solvemedia H Key</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="h_key" value="<?= $settings['h_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Iphub API</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="iphub" value="<?= $settings['iphub'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">ProxyCheck API</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="proxycheck" value="<?= $settings['proxycheck'] ?>">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                        <button class="btn btn-success btn-lg btn-block" name="overview"><i class="fas fa-check"></i> Update</button>
                    </form>
                </div>
            </div>
            <!-- end services -->
            <!-- begin services -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Login</h3>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('admin/update/settings') ?>" method="POST">
                        <div class="form-group">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-user"></i></span>
                                    </div>
                                    <input type="text" name="username" class="form-control" value="<?= $settings['username'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control" value="" required>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                        <button class="btn btn-success btn-lg btn-block" name="overview"><i class="fas fa-check"></i> Update</button>
                        <a href="<?= site_url('admin/security') ?>" target="_blank">Setup Google Authenticator</a>
                    </form>
                </div>
            </div>
            <!-- end services -->
        </div>

    </div>

</div>