<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title><?= $page ?> | <?= $settings['name'] ?> - <?= $settings['description'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="origin">
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
        echo '<style>.antibotlinks {background-color: #ffffff}</style>';
    }
    ?>
    <!-- Icons Css -->
    <link href="<?= base_url() ?>assets/css/icons.min.css?v=<?= VIE_VERSION ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url() ?>assets/css/styles.css?v=<?= VIE_VERSION ?>" rel="stylesheet" type="text/css" />

</head>


<body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">

                    <div class="navbar-brand-box">
                        <a href="<?= site_url() ?>" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="<?= base_url() ?>assets/images/logo.png" alt="" style="height: 22px">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url() ?>assets/images/logo.png" alt="" style="height: 50px">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>

                <div class="d-flex">

                    <div class="dropdown d-inline-block d-lg-none ml-2">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-search-dropdown">

                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block" id="notifications">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php if ($countUnreadNotification > 0) { ?>
                                <i class="bx bx-bell bx-tada"></i>
                                <span class="badge badge-danger badge-pill"><?= $countUnreadNotification ?></span>
                            <?php } else { ?>
                                <i class="bx bx-bell"></i>
                            <?php } ?>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0" key="t-notifications"> Notifications </h6>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar="init" style="max-height: 230px;">
                                <div class="simplebar-wrapper" style="margin: 0px;">
                                    <div class="simplebar-height-auto-observer-wrapper">
                                        <div class="simplebar-height-auto-observer"></div>
                                    </div>
                                    <div class="simplebar-mask">
                                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                            <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden;">
                                                <div class="simplebar-content" style="padding: 0px;">
                                                    <?php
                                                    foreach ($notifications as $notification) {
                                                        $icon = [];
                                                        switch ($notification['type']) {
                                                            case 0:
                                                                $icon['content'] = '<i class="fas fa-bullhorn"></i>';
                                                                $icon['color'] = 'bg-primary';
                                                                break;
                                                            case 1:
                                                                $icon['content'] = '<i class="far fa-money-bill-alt"></i>';
                                                                $icon['color'] = 'bg-success';
                                                                break;
                                                            case 2:
                                                                $icon['content'] = '<i class="fas fa-exclamation-triangle"></i>';
                                                                $icon['color'] = 'bg-danger';
                                                                break;
                                                            default:
                                                                $icon['content'] = '<i class="far fa-comment-dots"></i>';
                                                                $icon['color'] = 'bg-info';
                                                                break;
                                                        }
                                                    ?>
                                                        <a href="" class="text-reset notification-item">
                                                            <div class="media">
                                                                <div class="avatar-xs mr-3">
                                                                    <span class="avatar-title <?= $icon['color'] ?> rounded-circle font-size-16">
                                                                        <?= $icon['content'] ?>
                                                                    </span>
                                                                </div>
                                                                <div class="media-body">
                                                                    <div class="font-size-12 text-muted">
                                                                        <p class="mb-1" key="t-grammer" style="word-break: keep-all;"><?= $notification['content'] ?></p>
                                                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago"><?= timespan($notification["create_time"], time(), 2) ?> ago</span></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div>
                                </div>
                                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                    <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                                </div>
                                <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                    <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="<?= base_url() ?>assets/images/users/user.png" alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ml-1" key="t-henry"><?= $user['username'] ?></span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a class="dropdown-item" href="<?= site_url('profile') ?>"><i class="far fa-user-circle"></i> <span key="t-profile">Profile</span></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="<?= site_url('auth/logout') ?>"><i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title" key="t-menu">Menu</li>

                        <li>
                            <a href="<?= site_url('dashboard') ?>" class="waves-effect">
                                <i class="fas fa-tachometer-alt"></i>
                                <span key="t-dashboard">Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('referrals') ?>" class="waves-effect">
                                <i class="fas fa-users"></i>
                                <span key="t-dashboard">Referrals</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('leaderboard') ?>" class="waves-effect">
                                <i class="fas fa-list-ol"></i>
                                <span key="t-dashboard">Leaderboard</span>
                            </a>
                        </li>

                        <li class="menu-title" key="t-earning">Earning</li>

                        <?php if ($settings['achievement_status'] == 'on') { ?>
                            <li>
                                <a href="<?= site_url('achievements') ?>" class="waves-effect">
                                    <i class="fas fa-trophy"></i>
                                    <span key="t-achievements">Achievements</span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($settings['dice_status'] == 'on') { ?>
                            <li>
                                <a href="<?= site_url('dice') ?>" class="waves-effect">
                                    <i class="fas fa-dice"></i>
                                    <span key="t-dice">Dice</span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($settings['coinflip_status'] == 'on') { ?>
                            <li>
                                <a href="<?= site_url('coinflip') ?>" class="waves-effect">
                                    <i class="fas fa-coins"></i>
                                    <span key="t-dice">Coin Flip</span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($settings['autofaucet_status'] == 'on') { ?>
                            <li>
                                <a href="<?= site_url('auto') ?>" class="waves-effect">
                                    <i class="fas fa-robot"></i>
                                    <span key="t-auto">Auto Faucet</span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($settings['faucet_status'] == 'on') { ?>
                            <li>
                                <a href="<?= site_url('faucet') ?>" class="waves-effect">
                                    <i class="fas fa-faucet"></i>
                                    <span key="t-faucet">Manual Faucet</span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($settings['wheel_status'] == 'on') { ?>
                            <li>
                                <a href="<?= site_url('wheel') ?>" class="waves-effect">
                                    <i class="fas fa-dharmachakra"></i>
                                    <span key="t-faucet">Wheel Of Fortune</span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($settings['mining_status'] == 'on') { ?>
                            <li>
                                <a href="<?= site_url('mining') ?>" class="waves-effect">
                                    <i class="far fa-gem"></i>
                                    <span key="t-faucet">Mining</span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($settings['shortlink_status'] == 'on') { ?>
                            <li>
                                <a href="<?= site_url('links') ?>" class="waves-effect">
                                    <i class="fas fa-link"></i>
                                    <span key="t-links">Shortlinks <span class="badge badge-success"><?= $countAvailableLinks ?></span></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($settings['ptc_status'] == 'on') { ?>
                            <li>
                                <a href="<?= site_url('ptc') ?>" class="waves-effect">
                                    <i class="fas fa-mouse"></i>
                                    <span key="t-ptc">PTC <span class="badge badge-info"><?= $countAvailableAds ?></span></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($settings['lottery_status'] == 'on') { ?>
                            <li>
                                <a href="<?= site_url('lottery') ?>" class="waves-effect">
                                    <i class="fas fa-ticket-alt"></i>
                                    <span key="t-lottery">Lottery</span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($settings['tasks_status'] == 'on') { ?>
                            <li>
                                <a href="<?= site_url('tasks') ?>" class="waves-effect">
                                    <i class="fas fa-tasks"></i>
                                    <span key="t-tasks">Tasks <span class="badge badge-warning"><?= $countAvailableTasks ?></span></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($settings['offerwall_status'] == 'on') { ?>
                            <?php if ($user['level'] < $settings['offerwall_min_level']) { ?>
                                <li>
                                    <a href="#" class="waves-effect">
                                        <i class="far fa-newspaper"></i>
                                        <span class="badge badge-pill badge-info float-right" key="t-offerwall-message">Unlock at Level <?= $settings['offerwall_min_level'] ?></span>
                                        <span key="t-lottery">Offerwall</span>
                                    </a>
                                </li>
                            <?php } else { ?>
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="far fa-newspaper"></i>
                                        <span key="t-offerwall">Offerwalls</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <?php if ($settings['pollfish_status'] == 'on') { ?>
                                            <li><a href="<?= site_url('offerwall/pollfish') ?>" key="t-pollfish">Pollfish</a></li>
                                        <?php } ?>
                                        <?php if ($settings['bitswall_status'] == 'on') { ?>
                                            <li><a href="<?= site_url('offerwall/bitswall') ?>" key="t-bitswall">Bitswall</a></li>
                                        <?php } ?>
                                        <?php if ($settings['wannads_status'] == 'on') { ?>
                                            <li><a href="<?= site_url('offerwall/wannads') ?>" key="t-wannads">Wannads</a></li>
                                        <?php } ?>
                                        <?php if ($settings['monlix_status'] == 'on') { ?>
                                            <li><a href="<?= site_url('offerwall/monlix') ?>" key="t-monlix">Monlix</a></li>
                                        <?php } ?>
                                        <?php if ($settings['offertoro_status'] == 'on') { ?>
                                            <li><a href="<?= site_url('offerwall/offertoro') ?>" key="t-offertoro">OfferToro</a></li>
                                        <?php } ?>
                                        <?php if ($settings['cpx_status'] == 'on') { ?>
                                            <li><a href="<?= site_url('offerwall/cpx') ?>" key="t-cpx">CPX Research</a></li>
                                        <?php } ?>
                                        <?php if ($settings['ayetstudios_status'] == 'on') { ?>
                                            <li><a href="<?= site_url('offerwall/ayetstudios') ?>" key="t-ayetstudios">AyetStudios</a></li>
                                        <?php } ?>
                                        <?php if ($settings['offerdaddy_status'] == 'on') { ?>
                                            <li><a href="<?= site_url('offerwall/offerdaddy') ?>" key="t-offerdaddy">OfferDaddy</a></li>
                                        <?php } ?>
                                        <?php if ($settings['personaly_status'] == 'on') { ?>
                                            <li><a href="<?= site_url('offerwall/personaly') ?>" key="t-personaly">Personaly</a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                        <?php }
                        } ?>

                        <li class="menu-title" key="t-advertise">Advertise</li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-user-tie"></i>
                                <span key="t-advertiser">Advertiser</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?= site_url('advertise') ?>" key="t-advertise-create">Create campaign</a></li>
                                <li><a href="<?= site_url('advertise/manage') ?>" key="t-advertise-manage">Manage campaigns</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="<?= site_url('deposit') ?>" class="waves-effect">
                                <i class="fas fa-donate"></i>
                                <span key="t-deposit">Deposit</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('transfer') ?>" class="waves-effect">
                                <i class="fas fa-exchange-alt"></i>
                                <span key="t-deposit">Transfer</span>
                            </a>
                        </li>

                        <?php if (count($pages) > 0) { ?>
                            <li class="menu-title" key="t-pages">Pages</li>
                        <?php } ?>
                        <?php foreach ($pages as $p) { ?>
                            <li>
                                <a href="<?= site_url('page/' . $p['slug']) ?>" class="waves-effect">
                                    <span><?= $p['title'] ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        <li class="menu-title" key="t-account">Account</li>

                        <li>
                            <a href="<?= site_url('profile') ?>" class="waves-effect">
                                <i class="far fa-user-circle"></i>
                                <span key="t-profile">Profile</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('history') ?>" class="waves-effect">
                                <i class="fas fa-history"></i>
                                <span key="t-history">History</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">

                <?php if (!empty($settings['global_notification'])) { ?>
                    <div class="alert-warning align-middle text-center noty pt-1 pb-1">
                        <strong><i class="fas fa-bullhorn"></i>: <?= $settings['global_notification'] ?></strong>
                    </div>
                <?php } ?>
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18"><?= $settings['name'] ?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><?= $settings['name'] ?></a></li>
                                        <li class="breadcrumb-item active"><?= $page ?></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <?= $contents ?>
                    <!-- end row -->
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="mb-2">&copy <?= date('Y') ?> <a href="<?= base_url() ?>"><?= $settings['name'] ?></a> | <i class="fas fa-clock"></i> Server Time: <?= date('H:i') ?>.</p>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-right d-none d-sm-block">
                                Powered by <a href="https://faucetscript.net/faucet/vie-faucet-script" target="_blank">Vie Faucet Script</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
    <!-- Right bar overlay-->
    <div class="rightbar-overlay">
        <div>
            <a></a>
        </div>
    </div>
    <?= $settings['footer_code'] ?>
    <!-- JAVASCRIPT -->
    <script src="<?= base_url() ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/node-waves/waves.min.js"></script>

    <?php if ($page == 'Dashboard') { ?>
        <script src="<?= base_url() ?>assets/libs/apexcharts/apexcharts.min.js"></script>

        <script>
            var options = {
                chart: {
                    height: 180,
                    type: 'radialBar',
                    offsetY: -10
                },
                plotOptions: {
                    radialBar: {
                        startAngle: -135,
                        endAngle: 135,
                        dataLabels: {
                            name: {
                                fontSize: '13px',
                                color: undefined,
                                offsetY: 60
                            },
                            value: {
                                offsetY: 22,
                                fontSize: '16px',
                                color: undefined,
                                formatter: function(val) {
                                    return val + "%";
                                }
                            }
                        }
                    }
                },
                colors: ['#556ee6'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        shadeIntensity: 0.15,
                        inverseColors: false,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 50, 65, 91]
                    },
                },
                stroke: {
                    dashArray: 4,
                },
                series: [<?= ($user['exp'] % 100) ?>],
                labels: ['Level <?= $user['level'] + 1 ?>'],

            }

            var chart = new ApexCharts(
                document.querySelector("#radialBar-chart"),
                options
            );

            chart.render();
        </script>
    <?php } ?>
    <script type="text/javascript">
        var site_url = "<?= base_url() ?>";
    </script>
    <!-- App js -->
    <script src="<?= base_url() ?>assets/js/app.js?v=<?= VIE_VERSION ?>"></script>
    <script src="<?= base_url() ?>assets/js/vie/captcha.js?v=<?= VIE_VERSION ?>"></script>
    <?php if ($page == 'Deposit') { ?>
        <script src="<?= base_url() ?>assets/js/vie/deposit.js?v=<?= VIE_VERSION ?>"></script>
    <?php } ?>
    <?php if ($page == 'Dice') { ?>
        <script src="<?= base_url() ?>assets/js/vie/dice.js?v=<?= VIE_VERSION ?>"></script>
    <?php } ?>
    <?php if ($page == 'Coin Flip') { ?>
        <script src="<?= site_url('assets/js/vie/coinflip.js?v=' . VIE_VERSION) ?>"></script>
    <?php } ?>
    <script type="text/javascript">
        $("a[href='<?= current_url() ?>']").attr('data-active', 'true');
    </script>
    <?php if (isset($antibot_js)) { ?>
        <?= $antibot_js ?>
        <script src="<?= base_url() ?>assets/js/vie/antibotlinks.js?v=<?= VIE_VERSION ?>"></script>
    <?php } ?>
    <?php if ($page == 'Faucet') { ?>
        <script src="<?= base_url() ?>assets/js/vie/faucet.js?v=<?= VIE_VERSION ?>"></script>
    <?php } ?>
    <?php if ($page == 'Wheel of fortunes') { ?>
        <script src="<?= base_url() ?>assets/js/wheel/Winwheel.min.js"></script>
        <script src="<?= base_url() ?>assets/js/wheel/TweenMax.min.js"></script>
        <script src="<?= base_url() ?>assets/js/wheel/wheel.js"></script>
    <?php } ?>
    <?php if (isset($_COOKIE['captcha'])) { ?>
        <script>
            $('option[value=<?= $_COOKIE['captcha'] ?>]').attr('selected', 'selected');
        </script>
    <?php } ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if (isset($_SESSION['sweet_message'])) {
        echo $_SESSION['sweet_message'];
    }
    ?>
    <?php include 'adblock.php'; ?>
    <?php include 'chatbro.php'; ?>
</body>

</html>