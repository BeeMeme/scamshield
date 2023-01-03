<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title><?= $page ?> | <?= $settings['name'] ?> - <?= $settings['description'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="<?= $settings['description'] ?>" name="description" />
    <meta content="Vie Faucet Script" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>assets/images/favicon.ico">

    <!-- owl.carousel css -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/libs/owl.carousel/assets/owl.carousel.min.css?v=<?= VIE_VERSION ?>">

    <link rel="stylesheet" href="<?= base_url() ?>assets/libs/owl.carousel/assets/owl.theme.default.min.css?v=<?= VIE_VERSION ?>">

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

<body data-spy="scroll" data-target="#topnav-menu" data-offset="60">

    <nav class="navbar navbar-expand-lg navigation fixed-top sticky">
        <div class="container">
            <a class="navbar-logo" href="<?= base_url() ?>">
                <img src="<?= base_url() ?>assets/images/logo.png" alt="" height="50" class="logo logo-light">
                <img src="<?= base_url() ?>assets/images/logo.png" alt="" height="50" class="logo logo-dark">
            </a>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-toggle="collapse" data-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav ml-auto" id="topnav-menu">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= site_url('/#home') ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('/#features') ?>">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('/#statistics') ?>">Statistics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('/#methods') ?>">Payment Methods</a>
                    </li>
                </ul>

                <div class="ml-lg-2">
                    <a href="<?= site_url('login') ?>" class="btn btn-outline-success w-xs">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="section hero-section bg-ico-hero" id="home">
        <div class="bg-overlay bg-primary"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center">
                    <div class="text-white-50">
                        <h1 class="text-white font-weight-semibold mb-3 hero-title"><?= $settings['name'] ?></h1>
                        <p class="font-size-14"><?= $settings['description'] ?></p>

                        <div class="button-items mt-4">
                            <a href="<?= site_url('login') ?>" class="btn btn-success">Login</a>
                            <a href="<?= site_url('register') ?>" class="btn btn-light">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section pt-4 bg-white" id="methods">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h4><?= $this_page['title'] ?></h4>
                    </div>
                </div>
            </div>
            <div>
                <?= $this_page['content'] ?>
            </div>

        </div>
    </section>
    <footer class="landing-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <p class="mb-2">&copy <?= date('Y') ?> <a href="<?= base_url() ?>"><?= $settings['name'] ?></a> | <i class="fas fa-clock"></i> Server Time: <?= date('H:i') ?>.</p>
                </div>
                <div class="col-lg-6 text-right">
                    <p>Powered by <a href="https://shoppy.gg/product/099OPQ9">Vie Faucet Script</a></p>
                </div>

            </div>
        </div>
    </footer>
    <script>
        var nextRoll = moment.tz(<?= 1000 * $settings['lottery_date'] ?>, "<?= date_default_timezone_get() ?>").toDate();
    </script>
    <script src="<?= base_url() ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/node-waves/waves.min.js"></script>

    <script src="<?= base_url() ?>assets/libs/jquery.easing/jquery.easing.min.js"></script>

    <!-- owl.carousel js -->
    <script src="<?= base_url() ?>assets/libs/owl.carousel/owl.carousel.min.js"></script>

    <!-- ICO landing init -->
    <script src="<?= base_url() ?>assets/js/pages/ico-landing.init.js"></script>

    <script src="<?= base_url() ?>assets/js/app.js?v=<?= VIE_VERSION ?>"></script>
    <?php include 'adblock.php'; ?>
</body>

</html>