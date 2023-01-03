<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Register | <?= $settings['name'] ?> - <?= $settings['description'] ?></title>
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
    <link href="<?= base_url() ?>assets/css/styles.css?v=<?= VIE_VERSION ?>" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="home-btn d-none d-sm-block">
        <a href="<?= base_url() ?>" class="text-dark"><i class="mdi mdi-home-variant h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-soft-primary">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Welcome Back !</h5>
                                        <p>Get your free <?= $settings['name'] ?> account now.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="<?= base_url() ?>assets/images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="<?= base_url() ?>">
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

                                <form class="form-horizontal" action="<?= site_url('auth/register') ?>" autocomplete="on" method="POST">

                                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" pattern="^[a-zA-Z]{1,1}[a-zA-Z0-9_]{2,13}[a-zA-Z0-9]{1,1}$" title="Username should only contain lowercase letters, numbers and _. e.g. tungaqhd_1234" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Enter password" required>
                                    </div>

                                    <div class="ads">
                                        <?= $settings['register_ad'] ?>
                                    </div>

                                    <center>
                                        <?= $captcha_display ?>
                                    </center>

                                    <div class="mt-3">
                                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Register</button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">

                        <div>
                            <p>Already have an account ? <a href="<?= site_url('login') ?>" class="font-weight-medium text-primary"> Login </a> </p>
                            <p class="mb-2">&copy <?= date('Y') ?> <a href="<?= base_url() ?>"><?= $settings['name'] ?></a> | <i class="fas fa-clock"></i> Server Time: <?= date('H:i') ?>.</p>
                        </div>
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
    <script src="<?= base_url() ?>assets/js/vie/captcha.js?v=<?= VIE_VERSION ?>"></script>

    <!-- App js -->
    <script src="<?= base_url() ?>assets/js/app.js?v=<?= VIE_VERSION ?>"></script>
</body>

</html>