<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $page ?> | <?= $settings['name'] ?> - <?= $settings['description'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta content="<?= $settings['description'] ?>" name="description" />
    <link rel="shortcut icon" href="<?= base_url() ?>assets/images/favicon.ico">

    <link rel="stylesheet" href="<?= site_url('assets/css/home/main.min.css') ?>">
    <link href="<?= base_url() ?>assets/css/icons.min.css?v=<?= VIE_VERSION ?>" rel="stylesheet" type="text/css" />
</head>

<body>
    <div id="preloader">
        <div class="preloader-wrap">
            <img src="<?= site_url('assets/images/logo.png') ?>" alt="logo" class="img-fluid" style="max-width: 50px" />
            <div class="thecube">
                <div class="cube c1"></div>
                <div class="cube c2"></div>
                <div class="cube c4"></div>
                <div class="cube c3"></div>
            </div>
        </div>
    </div>
    <header class="header">
        <nav class="navbar navbar-expand-lg fixed-top bg-transparent">
            <div class="container">
                <a class="navbar-brand" href="<?= site_url() ?>">
                    <img src="<?= site_url('assets/images/logo.png') ?>" alt="logo" class="img-fluid" style="max-width: 50px;" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="ti-menu"></span>
                </button>

                <div class="collapse navbar-collapse h-auto" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto menu">
                        <li><a href="<?= site_url() ?>" class="page-scroll active"><i class="fas fa-home"></i> Home</a></li>
                        <li><a href="#proofs" class="page-scroll"><i class="fas fa-money-check-alt"></i> Payment Proofs</a></li>
                        <li><a href="#faq" class="page-scroll"><i class="far fa-question-circle"></i> FAQ</a></li>
                        <li><a href="#features" class="page-scroll">Features</a></li>
                        <li><a href="#whyjoinus" class="page-scroll">Why join us?</a></li>
                        <li><a href="#currencies" class="page-scroll">Payment Method</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="main">
        <section class="position-relative bg-image pt-100" image-overlay="10">
            <div class="background-image-wraper"></div>
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-10 col-lg-6">
                        <div class="section-heading text-white py-5">
                            <h1 class="text-white font-weight-bold"><?= $settings['name'] ?> - <?= $settings['description'] ?></h1>
                            <p>Start earning cryptocurrency on the best faucet site in the world by doing tasks, offerwalls, faucet, shortlinks, ptc.</p>
                            <div class="action-btns mt-4">
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <a href="<?= site_url('login') ?>" class="d-flex align-items-center app-download-btn btn btn-info btn-rounded">
                                            <i class="fas fa-sign-in-alt fa-2x"></i>
                                            <div class="download-text text-left">
                                                <h5 class="mb-0">Login</h5>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="<?= site_url('register') ?>" class="d-flex align-items-center app-download-btn btn btn-brand-02 btn-rounded">
                                            <i class="fas fa-user-plus fa-2x"></i>
                                            <div class="download-text text-left pl-1">
                                                <h5 class="mb-0">Register</h5>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9 col-lg-5">
                        <div class="img-wrap">
                            <img src="<?= site_url('assets/images/home/cryptocurrency.png') ?>" alt="shape" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <ul class="list-inline counter-wrap bg-white">
                        <li class="list-inline-item">
                            <div class="single-counter text-center count-data">
                                <span class="color-primary count-number"><?= number_format($stat['total_user']) ?></span>
                                <h6>Happy Users</h6>
                            </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="single-counter text-center count-data">
                                <span class="color-primary count-number"><?= number_format($stat['earning']) ?></span>
                                <h6>USD Earned</h6>
                            </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="single-counter text-center count-data">
                                <span class="color-primary count-number"><?= number_format($stat['withdrawals']) ?></span>
                                <h6>Withdrawals</h6>
                            </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="single-counter text-center count-data">
                                <span class="color-primary count-number"><?= !$stat['dayOnline'] ? '0' : $stat['dayOnline'] ?></span>
                                <h6>Days Online</h6>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <section id="features" class="promo-section ptb-100 position-relative overflow-hidden">
            <div class="container">
                <div class="section-heading">
                    <h2 class="text-center">Features</h2>
                </div>
                <div class="row">
                    <?php if ($settings['faucet_status'] == 'on') { ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-0 single-promo-card single-promo-hover-2 p-2 mt-4">
                                <div class="card-body">
                                    <div class="pb-2">
                                        <span class="fas fa-faucet icon-size-md color-secondary"></span>
                                    </div>
                                    <div class="pt-2 pb-3">
                                        <h5>Faucet</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($settings['autofaucet_status'] == 'on') { ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-0 single-promo-card single-promo-hover-2 p-2 mt-4">
                                <div class="card-body">
                                    <div class="pb-2">
                                        <span class="fas fa-robot icon-size-md color-secondary"></span>
                                    </div>
                                    <div class="pt-2 pb-3">
                                        <h5>Auto Faucet</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($settings['shortlink_status'] == 'on') { ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-0 single-promo-card single-promo-hover-2 p-2 mt-4">
                                <div class="card-body">
                                    <div class="pb-2">
                                        <span class="fas fa-link icon-size-md color-secondary"></span>
                                    </div>
                                    <div class="pt-2 pb-3">
                                        <h5>Shortlink</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($settings['ptc_status'] == 'on') { ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-0 single-promo-card single-promo-hover-2 p-2 mt-4">
                                <div class="card-body">
                                    <div class="pb-2">
                                        <span class="fas fa-mouse icon-size-md color-secondary"></span>
                                    </div>
                                    <div class="pt-2 pb-3">
                                        <h5>PTC</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($settings['lottery_status'] == 'on') { ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-0 single-promo-card single-promo-hover-2 p-2 mt-4">
                                <div class="card-body">
                                    <div class="pb-2">
                                        <span class="fas fa-ticket-alt icon-size-md color-secondary"></span>
                                    </div>
                                    <div class="pt-2 pb-3">
                                        <h5>Lottery</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($settings['achievement_status'] == 'on') { ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-0 single-promo-card single-promo-hover-2 p-2 mt-4">
                                <div class="card-body">
                                    <div class="pb-2">
                                        <span class="fas fa-ticket-alt icon-size-md color-secondary"></span>
                                    </div>
                                    <div class="pt-2 pb-3">
                                        <h5>Achievement</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($settings['tasks_status'] == 'on') { ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-0 single-promo-card single-promo-hover-2 p-2 mt-4">
                                <div class="card-body">
                                    <div class="pb-2">
                                        <span class="fas fa-tasks icon-size-md color-secondary"></span>
                                    </div>
                                    <div class="pt-2 pb-3">
                                        <h5>Task</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($settings['offerwall_status'] == 'on') { ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-0 single-promo-card single-promo-hover-2 p-2 mt-4">
                                <div class="card-body">
                                    <div class="pb-2">
                                        <span class="fas fa-columns icon-size-md color-secondary"></span>
                                    </div>
                                    <div class="pt-2 pb-3">
                                        <h5>Offerwall</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 single-promo-card single-promo-hover-2 p-2 mt-4">
                            <div class="card-body">
                                <div class="pb-2">
                                    <span class="fas fa-trophy icon-size-md color-secondary"></span>
                                </div>
                                <div class="pt-2 pb-3">
                                    <h5>Level System</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 single-promo-card single-promo-hover-2 p-2 mt-4">
                            <div class="card-body">
                                <div class="pb-2">
                                    <span class="fas fa-award icon-size-md color-secondary"></span>
                                </div>
                                <div class="pt-2 pb-3">
                                    <h5>Weekly Contest</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($settings['dice_status'] == 'on') { ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-0 single-promo-card single-promo-hover-2 p-2 mt-4">
                                <div class="card-body">
                                    <div class="pb-2">
                                        <span class="fas fa-dice icon-size-md color-secondary"></span>
                                    </div>
                                    <div class="pt-2 pb-3">
                                        <h5>Dice</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($settings['coinflip_status'] == 'on') { ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-0 single-promo-card single-promo-hover-2 p-2 mt-4">
                                <div class="card-body">
                                    <div class="pb-2">
                                        <span class="fas fa-ticket-alt icon-size-md color-secondary"></span>
                                    </div>
                                    <div class="pt-2 pb-3">
                                        <h5>Coin Flip</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        <section id="whyjoinus" class="about-us ptb-100 position-relative gray-light-bg">
            <div class="container">
                <div class="row align-items-center justify-content-lg-between justify-content-md-center">
                    <div class="col-md-5 col-lg-4">
                        <div class="about-content-right">
                            <img src="<?= site_url('assets/images/home/cryptocurrency.png') ?>" alt="about us" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-7">
                        <div class="about-content-left section-heading">
                            <h2>Why join us?</h2>

                            <ul class="check-list-wrap pt-3">
                                <li><strong>Easy To Earn Money</strong> - There are many ways to earn money in our site such as faucet, shortlinks, ptc, tasks, offerwalls, ...</li>
                                <li><strong>Level System</strong> – Level up your account and climb the leaderboard to earn more money and unlock new features.</li>
                                <li><strong>Fast Withdrawal</strong> – We pay you instantly or daily to your wallet or microwallet addresses.</li>
                                <li><strong>User Friendly</strong> – The website is user friendly and compatible with all browsers and devices.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="currencies" class="screenshots-section pb-100 ptb-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-9 col-lg-8">
                        <div class="section-heading text-center mb-5">
                            <h2>Currencies Supported</h2>
                        </div>
                    </div>
                </div>
                <div class="screenshot-wrap">
                    <div class="screenshot-frame"></div>
                    <div class="screen-carousel owl-carousel owl-theme dot-indicator">
                        <?php foreach ($methods as $method) { ?>
                            <img src="<?= site_url('assets/images/currencies/' . strtolower($method['code']) . '.png') ?>" class="img-fluid" alt="<?= $method['name'] ?>" style="max-width: 80px;" />
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>

        <section id="proofs" class="screenshots-section pb-100 ptb-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-9 col-lg-8">
                        <div class="section-heading text-center mb-5">
                            <h2>Payment Proofs</h2>
                        </div>
                    </div>
                </div>
                <div class="screenshot-wrap">

                    <div class="table-responsive">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Method</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($withdrawHistory as $wd) {
                                    $img = site_url('assets/images/currencies/' . strtolower($wd["code"]) . '.png');
                                    echo '<tr>
                                    <th scope="row">' . $wd["id"] . '</th>
                                    <td>' . $wd["username"] . '</td><td>' . $wd["wallet"] . '</td>
                                    <td><img src="' . $img . '" width="50px" /></td>
                                    <td>' . format_money($wd["amount"]) . ' USD</td>
                                    </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="position-relative gradient-bg ptb-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-lg-5 mb-4 mb-sm-4 mb-md-0 mb-lg-0">
                        <div class="testimonial-heading text-white">
                            <h2 class="text-white">What Our User Say About <?= $settings['name'] ?></h2>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="testimonial-content-wrap">
                            <div class="owl-carousel owl-theme client-testimonial-1 dot-indicator testimonial-shape">
                                <div class="item">
                                    <div class="testimonial-quote-wrap">
                                        <div class="media author-info mb-3">
                                            <div class="author-img mr-3">
                                                <img src="<?= site_url('assets/images/staff.png') ?>" alt="client" class="img-fluid">
                                            </div>
                                            <div class="media-body text-white">
                                                <h5 class="mb-0 text-white">Mr.T</h5>
                                                <span>Head Of Admin</span>
                                            </div>
                                            <i class="fas fa-quote-right text-white"></i>
                                        </div>
                                        <div class="client-say text-white">
                                            <p>We work hard daily to improve it and bring you the most exciting faucet.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="ptb-100 gray-light-bg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-9 col-lg-8">
                        <div class="section-heading text-center mb-5">
                            <h2>Frequently Asked Queries</h2>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-12 col-lg-6 mb-5 mb-md-5 mb-sm-5 mb-lg-0">
                        <div class="img-wrap">
                            <img src="<?= site_url('assets/images/home/faq.png') ?>" alt="download" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div id="accordion" class="accordion faq-wrap">
                            <div class="card mb-3">
                                <a class="card-header " data-toggle="collapse" href="#collapse0" aria-expanded="false">
                                    <h6 class="mb-0 d-inline-block">Can I create multiple accounts?</h6>
                                </a>
                                <div id="collapse0" class="collapse show" data-parent="#accordion" style="">
                                    <div class="card-body white-bg">
                                        <p>You are not allowed to create multiple accounts or have multiple accounts in the same network. All violated accounts will be banned.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card my-3">
                                <a class="card-header collapsed" data-toggle="collapse" href="#collapse1" aria-expanded="false">
                                    <h6 class="mb-0 d-inline-block">Am I benefit from referring my friends?</h6>
                                </a>
                                <div id="collapse1" class="collapse " data-parent="#accordion" style="">
                                    <div class="card-body white-bg">
                                        <p>We share up to <?= $settings['referral'] ?>% of your friend earning for referring them. You can get your referral link in <b>Refferal Tab</b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card my-3">
                                <a class="card-header collapsed" data-toggle="collapse" href="#collapse2" aria-expanded="false">
                                    <h6 class="mb-0 d-inline-block">Can I use Bots or VPN/Proxy?</h6>
                                </a>
                                <div id="collapse2" class="collapse " data-parent="#accordion" style="">
                                    <div class="card-body white-bg">
                                        <p>Bots, VPN/Proxy are not allowed on this site. We will ban all violated accounts.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer class="footer-1 gradient-bg ptb-60">

        <div class="container">
        </div>
    </footer>
    <div class="footer-bottom py-3 gray-light-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-7">
                    <div class="copyright-wrap small-text">
                        <p class="mb-0">&copy <?= date('Y') ?> <a href="<?= base_url() ?>"><?= $settings['name'] ?></a> | Powered by <a href="https://faucetscript.net/faucet/vie-faucet-script/" target="_blank">Vie Faucet Script</a></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="terms-policy-wrap text-lg-right text-md-right text-left">
                        <ul class="list-inline">
                            <li class="list-inline-item"><a class="small-text" href="#">Terms</a></li>
                            <li class="list-inline-item"><a class="small-text" href="#">Security</a></li>
                            <li class="list-inline-item"><a class="small-text" href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="scroll-top scroll-to-target primary-bg text-white" data-target="html">
        <span class="fas fa-hand-point-up"></span>
    </div>
    <script src="<?= site_url('assets/js/vie/home/jquery-3.5.1.min.js') ?>"></script>
    <script src="<?= site_url('assets/js/vie/home/popper.min.js') ?>"></script>
    <script src="<?= site_url('assets/js/vie/home/bootstrap.min.js') ?>"></script>
    <script src="<?= site_url('assets/js/vie/home/jquery.easing.min.js') ?>"></script>
    <script src="<?= site_url('assets/js/vie/home/owl.carousel.min.js') ?>"></script>
    <script src="<?= site_url('assets/js/vie/home/countdown.min.js') ?>"></script>
    <script src="<?= site_url('assets/js/vie/home/jquery.waypoints.min.js') ?>"></script>
    <script src="<?= site_url('assets/js/vie/home/jquery.rcounterup.js') ?>"></script>
    <script src="<?= site_url('assets/js/vie/home/magnific-popup.min.js') ?>"></script>
    <script src="<?= site_url('assets/js/vie/home/app.min.js') ?>"></script>
</body>

</html>