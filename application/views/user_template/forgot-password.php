<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Reset Password | <?= $settings['name'] ?> - <?= $settings['description'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="<?= $settings['description'] ?>" name="description" />
    <meta content="Vie Faucet Script" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <?php if ($settings['theme'] == 'light') {
        echo '<link href="' . base_url() . 'assets/css/bootstrap.min.css?v=' . VIE_VERSION . '" id="bootstrap-style" rel="stylesheet" type="text/css" />';
        echo '<link href="' . base_url() . 'assets/css/app.min.css?v=' . VIE_VERSION . '" id="bootstrap-style" rel="stylesheet" type="text/css" />';
    } else {
        echo '<link href="' . base_url() . 'assets/css/bootstrap-dark.min.css?v=' . VIE_VERSION . '" id="bootstrap-style" rel="stylesheet" type="text/css" />';
        echo '<link href="' . base_url() . 'assets/css/app-dark.min.css?v=' . VIE_VERSION . '" id="bootstrap-style" rel="stylesheet" type="text/css" />';
    }
    ?>
    <!-- Icons Css -->
    <link href="<?= base_url() ?>assets/css/icons.min.css?v=<?= VIE_VERSION ?>" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-soft-primary">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary"> Reset Password</h5>
                                        <p>Re-Password with <?= $settings['name'] ?>.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="<?= base_url() ?>assets/images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="<?= site_url() ?>">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="<?= base_url() ?>assets/images/logo.png" alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>

                            <div class="p-2">
                                <?php
                                if (isset($_SESSION['message'])) {
                                    echo $_SESSION['message'];
                                }
                                ?>
                                <form class="form-horizontal" action="<?= site_url('auth/forgot_password') ?>" method="POST">

                                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                                    </div>

                                    <center>
                                        <?= $captcha_display ?>
                                    </center>

                                    <div class="form-group row mb-0">
                                        <div class="col-12 text-right">
                                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Reset</button>
                                        </div>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>Remember It ? <a href="<?= site_url('login') ?>" class="font-weight-medium text-primary"> Sign In here</a> </p>
                        <p>&copy <?= date('Y') ?> <a href="<?= base_url() ?>"><?= $settings['name'] ?></a> | <i class="fas fa-clock"></i> Server Time: <?= date('H:i') ?>.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?= $settings['footer_code'] ?>
    <!-- JAVASCRIPT -->
    <script src="<?= base_url() ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/node-waves/waves.min.js"></script>

    <!-- App js -->
    <script src="<?= base_url() ?>assets/js/app.js?v=<?= VIE_VERSION ?>"></script>
    <script src="<?= base_url() ?>assets/js/vie/captcha.js"></script>
</body>

</html>