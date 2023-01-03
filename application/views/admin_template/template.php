<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title><?= $page ?> | <?= $settings['name'] ?> - <?= $settings['description'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="<?= $settings['description'] ?>" name="description" />
    <meta content="Vie Faucet Script" name="author" />
    <meta name=”robots” content=”noindex,nofollow”>
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
    <!-- App Css-->
    <link href="<?= base_url() ?>assets/css/styles.css?v=<?= VIE_VERSION ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/libs/summernote/summernote-bs4.min.css?v=<?= VIE_VERSION ?>" rel="stylesheet" type="text/css" />
</head>


<body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="<?= site_url('admin') ?>" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="<?= base_url() ?>assets/images/logo.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url() ?>assets/images/logo.png" alt="" height="50">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
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
                            <a href="<?= site_url('admin/overview') ?>" class="waves-effect">
                                <i class="fas fa-tachometer-alt"></i>
                                <span key="t-overview">Overview</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/store') ?>" class="waves-effect">
                                <i class="fas fa-store"></i>
                                <span key="t-store">Store <span class="badge badge-danger">HOT</span></span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/currencies') ?>" class="waves-effect">
                                <i class="fas fa-hand-holding-usd"></i>
                                <span key="t-currency">Payment Methods</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/settings') ?>" class="waves-effect">
                                <i class="fas fa-cogs"></i>
                                <span key="t-settings">General Settings</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/pages') ?>" class="waves-effect">
                                <i class="far fa-edit"></i>
                                <span key="t-pages">Pages</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/notifications') ?>" class="waves-effect">
                                <i class="fas fa-bullhorn"></i>
                                <span key="t-pages">Recent Notifications</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/leaderboard') ?>" class="waves-effect">
                                <i class="fas fa-list-ol"></i>
                                <span key="t-leaderboard">Leaderboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-download"></i>
                                <span key="t-withdrawals">Withdrawals</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?= site_url('admin/withdraw/recent') ?>" key="t-withdrawals-recent">Recent withdrawals</a></li>
                                <li><a href="<?= site_url('admin/withdraw/pending') ?>" key="t-withdrawals-pending">Pending withdrawals</a></li>
                                <li><a href="<?= site_url('admin/withdraw/today') ?>" key="t-withdrawals-history">Today history</a></li>
                                <li><a href="<?= site_url('admin/withdraw/yesterday') ?>" key="t-withdrawals-yesterday">Yesterday history</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-users"></i>
                                <span key="t-users">Manage users</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?= site_url('admin/users') ?>" key="t-users-all">Users</a></li>
                                <li><a href="<?= site_url('admin/users/banned') ?>" key="t-users-banned">Banned users</a></li>
                                <li><a href="<?= site_url('admin/users/suspected') ?>" key="t-users-suspected">Suspected users</a></li>
                                <li><a href="<?= site_url('admin/users/same_password') ?>" key="t-users-password">Users have same password hash</a></li>
                                <li><a href="<?= site_url('admin/users/same_ip') ?>" key="t-users-ip">Users have same IP Address</a></li>
                                <li><a href="<?= site_url('admin/users/similar_ip') ?>" key="t-users-sub">Users have similar IP Address</a></li>
                                <li><a href="<?= site_url('admin/users/country') ?>" key="t-users-country">Users by country</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="far fa-newspaper"></i>
                                <span key="t-offerwall">Offerwall</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?= site_url('admin/offerwalls/pending') ?>" key="t-offerwall-pending">Pending</a></li>
                                <li><a href="<?= site_url('admin/offerwalls/cancelled') ?>" key="t-offerwall-cancelled">Cancelled</a></li>
                                <li><a href="<?= site_url('admin/offerwalls/approved') ?>" key="t-offerwall-approved">Approved</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-tasks"></i>
                                <span key="t-tasks">Tasks</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?= site_url('admin/tasks/submissions') ?>" key="t-task-submissions">Pending</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/reward') ?>" class="waves-effect">
                                <i class="fas fa-gift"></i>
                                <span key="t-dashboard">Reward User</span>
                            </a>
                        </li>

                        <li class="menu-title" key="t-earning">Earning</li>

                        <li>
                            <a href="<?= site_url('admin/achievements') ?>" class="waves-effect">
                                <i class="fas fa-trophy"></i>
                                <span key="t-achievements">Achievements</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/dice') ?>" class="waves-effect">
                                <i class="fas fa-dice"></i>
                                <span key="t-dice">Dice</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/coinflip') ?>" class="waves-effect">
                                <i class="fas fa-coins"></i>
                                <span key="t-dice">Coin Flip</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/auto') ?>" class="waves-effect">
                                <i class="fas fa-robot"></i>
                                <span key="t-auto">Auto Faucet</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/faucet') ?>" class="waves-effect">
                                <i class="fas fa-faucet"></i>
                                <span key="t-faucet">Manual Faucet</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/wheel') ?>" class="waves-effect">
                                <i class="fas fa-dharmachakra"></i>
                                <span key="t-faucet">Wheel Of Fortune</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/mining') ?>" class="waves-effect">
                                <i class="far fa-gem"></i>
                                <span key="t-faucet">Mining</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/links') ?>" class="waves-effect">
                                <i class="fas fa-link"></i>
                                <span key="t-links">Shortlinks</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/ptc') ?>" class="waves-effect">
                                <i class="fas fa-mouse"></i>
                                <span key="t-ptc">PTC</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/lottery') ?>" class="waves-effect">
                                <i class="fas fa-ticket-alt"></i>
                                <span key="t-lottery">Lottery</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/offerwalls') ?>" class="waves-effect">
                                <i class="far fa-newspaper"></i>
                                <span key="t-offerwall">Offerwalls</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/tasks') ?>" class="waves-effect">
                                <i class="fas fa-tasks"></i>
                                <span key="t-tasks">Tasks</span>
                            </a>
                        </li>

                        <li class="menu-title" key="t-advertise">Advertise</li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-user-tie"></i>
                                <span key="t-advertiser">Advertiser</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?= site_url('admin/advertise/options') ?>" key="t-advertise-create">Options</a></li>
                                <li><a href="<?= site_url('admin/advertise') ?>" key="t-advertise-create">Create campaign</a></li>
                                <li><a href="<?= site_url('admin/advertise/accepted') ?>" key="t-advertise-manage">Accepted campaigns</a></li>
                                <li><a href="<?= site_url('admin/advertise/pending') ?>" key="t-advertise-manage">Pending campaigns</a></li>
                                <li><a href="<?= site_url('admin/advertise/completed') ?>" key="t-advertise-manage">Completed campaigns</a></li>
                                <li><a href="<?= site_url('admin/advertise/admin') ?>" key="t-advertise-manage">Created by admin campaigns</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="<?= site_url('admin/deposit') ?>" class="waves-effect">
                                <i class="fas fa-donate"></i>
                                <span key="t-deposit">Deposit</span>
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
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18"><?= $settings['name'] ?> - Version <?= VIE_VERSION ?></h4>

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
            <div class="ads">
                <?= $settings['footer_code'] ?>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="mb-2">&copy <?= date('Y') ?> <a href="<?= base_url() ?>"><?= $settings['name'] ?></a> | <i class="fas fa-clock"></i> Server Time: <?= date('H:i') ?>.</p>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-right d-none d-sm-block">
                                Powered by <a href="https://faucetscript.net/faucet/vie-faucet-script/" target="_blank">Vie Faucet Script</a>
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
    <div class="rightbar-overlay"></div>
    <?= $settings['footer_code'] ?>
    <!-- JAVASCRIPT -->
    <script src="<?= base_url() ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/node-waves/waves.min.js"></script>

    <?php if ($page == 'Overview') {
        function toStringVie($raw)
        {
            return "'" . $raw . "'";
        }
        function toDayVie($day)
        {
            return ($day > 1) ? "'" . $day . " days ago'" : "'Today'";
        }
    ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
        <script>
            var lineChartData = {
                labels: [<?= implode(', ', array_map('toStringVie', $stats['date'])) ?>],
                datasets: [{
                    label: 'New Users',
                    borderColor: "rgba(180, 179, 113, 1)",
                    backgroundColor: "rgba(230, 229, 163, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['new_users']) ?>],
                    yAxisID: 'y-axis-count',
                    pointStyle: 'rect',
                    pointRadius: 7,
                }, {
                    label: 'Active Users',
                    borderColor: "rgba(186, 52, 160, 1)",
                    backgroundColor: "rgba(236, 102, 210, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['active_users']) ?>],
                    yAxisID: 'y-axis-count',
                    pointStyle: 'rect',
                    pointRadius: 7,
                }, {
                    label: 'Auto Faucet Count',
                    borderColor: "rgba(147, 164, 143, 1)",
                    backgroundColor: "rgba(197, 214, 193, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['autofaucet_count']) ?>],
                    yAxisID: 'y-axis-count',
                    pointStyle: 'rect',
                    pointRadius: 7,
                }, {
                    label: 'Auto Faucet Amount',
                    borderColor: "rgba(64, 97, 102, 1)",
                    backgroundColor: "rgba(114, 147, 152, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['autofaucet_amount']) ?>],
                    yAxisID: 'y-axis-amount',
                    pointStyle: 'triangle',
                    pointRadius: 7,
                }, {
                    label: 'Manual Faucet Count',
                    borderColor: "rgba(137, 135, 16, 1)",
                    backgroundColor: "rgba(187, 185, 66, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['faucet_count']) ?>],
                    yAxisID: 'y-axis-count',
                    pointStyle: 'rect',
                    pointRadius: 7,
                }, {
                    label: 'Manual Faucet Amount',
                    borderColor: "rgba(117, 131, 106, 1)",
                    backgroundColor: "rgba(167, 181, 156, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['faucet_amount']) ?>],
                    yAxisID: 'y-axis-amount',
                    pointStyle: 'triangle',
                    pointRadius: 7,
                }, {
                    label: 'Shortlink Count',
                    borderColor: "rgba(74, 5, 115, 1)",
                    backgroundColor: "rgba(124, 55, 165, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['shortlink_count']) ?>],
                    yAxisID: 'y-axis-count',
                    pointStyle: 'rect',
                    pointRadius: 7,
                }, {
                    label: 'Shortlink Amount',
                    borderColor: "rgba(156, 22, 126, 1)",
                    backgroundColor: "rgba(206, 72, 176, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['shortlink_amount']) ?>],
                    yAxisID: 'y-axis-amount',
                    pointStyle: 'triangle',
                    pointRadius: 7,
                }, {
                    label: 'PTC Count',
                    borderColor: "rgba(114, 173, 74, 1)",
                    backgroundColor: "rgba(164, 223, 124, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['ptc_count']) ?>],
                    yAxisID: 'y-axis-count',
                    pointStyle: 'rect',
                    pointRadius: 7,
                }, {
                    label: 'PTC Amount',
                    borderColor: "rgba(101, 165, 94, 1)",
                    backgroundColor: "rgba(151, 215, 144, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['ptc_amount']) ?>],
                    yAxisID: 'y-axis-amount',
                    pointStyle: 'triangle',
                    pointRadius: 7,
                }, {
                    label: 'Dice Count',
                    borderColor: "rgba(44, 122, 16, 1)",
                    backgroundColor: "rgba(94, 172, 66, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['dice_count']) ?>],
                    yAxisID: 'y-axis-count',
                    pointStyle: 'rect',
                    pointRadius: 7,
                }, {
                    label: 'Dice Amount',
                    borderColor: "rgba(28, 195, 29, 1)",
                    backgroundColor: "rgba(78, 245, 79, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['dice_amount']) ?>],
                    yAxisID: 'y-axis-amount',
                    pointStyle: 'triangle',
                    pointRadius: 7,
                }, {
                    label: 'Coin Flip Count',
                    borderColor: "rgba(60, 140, 30, 1)",
                    backgroundColor: "rgba(110, 190, 80, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['coinflip_count']) ?>],
                    yAxisID: 'y-axis-count',
                    pointStyle: 'rect',
                    pointRadius: 7,
                }, {
                    label: 'Coin Flip Amount',
                    borderColor: "rgba(40, 210, 40, 1)",
                    backgroundColor: "rgba(90, 260, 90, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['coinflip_amount']) ?>],
                    yAxisID: 'y-axis-amount',
                    pointStyle: 'triangle',
                    pointRadius: 7,
                }, {
                    label: 'Offerwall Count',
                    borderColor: "rgba(21, 167, 182, 1)",
                    backgroundColor: "rgba(71, 217, 232, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['offerwall_count']) ?>],
                    yAxisID: 'y-axis-count',
                    pointStyle: 'rect',
                    pointRadius: 7,
                }, {
                    label: 'Offerwall Amount',
                    borderColor: "rgba(85, 203, 152, 1)",
                    backgroundColor: "rgba(135, 253, 202, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['offerwall_amount']) ?>],
                    yAxisID: 'y-axis-amount',
                    pointStyle: 'triangle',
                    pointRadius: 7,
                }, {
                    label: 'Deposit Count',
                    borderColor: "rgba(48, 190, 21, 1)",
                    backgroundColor: "rgba(98, 240, 71, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['deposit_count']) ?>],
                    yAxisID: 'y-axis-count',
                    pointStyle: 'rect',
                    pointRadius: 7,
                }, {
                    label: 'Deposit Amount',
                    borderColor: "rgba(167, 91, 43, 1)",
                    backgroundColor: "rgba(217, 141, 93, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['deposit_amount']) ?>],
                    yAxisID: 'y-axis-amount',
                    pointStyle: 'triangle',
                    pointRadius: 7,
                }, {
                    label: 'Withdraw Amount',
                    borderColor: "rgba(121, 150, 158, 1)",
                    backgroundColor: "rgba(171, 200, 208, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['withdraw_amount']) ?>],
                    yAxisID: 'y-axis-amount',
                    pointStyle: 'triangle',
                    pointRadius: 7,
                }, {
                    label: 'Achievement Count',
                    borderColor: "rgba(25, 120, 60, 1)",
                    backgroundColor: "rgba(75, 170, 110, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['achievement_count']) ?>],
                    yAxisID: 'y-axis-count',
                    pointStyle: 'rect',
                    pointRadius: 7,
                }, {
                    label: 'Achievement Amount',
                    borderColor: "rgba(12, 150, 70, 1)",
                    backgroundColor: "rgba(62, 200, 120, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['achievement_amount']) ?>],
                    yAxisID: 'y-axis-amount',
                    pointStyle: 'triangle',
                    pointRadius: 7,
                }, {
                    label: 'Wheel Count',
                    borderColor: "rgba(14, 145, 122, 1)",
                    backgroundColor: "rgba(14, 222, 210, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['wheel_count']) ?>],
                    yAxisID: 'y-axis-count',
                    pointStyle: 'rect',
                    pointRadius: 7,
                }, {
                    label: 'Wheel Amount',
                    borderColor: "rgba(55, 125, 65, 1)",
                    backgroundColor: "rgba(13, 85, 123, 1)",
                    fill: false,
                    lineTension: 0,
                    data: [<?= implode(', ', $stats['wheel_amount']) ?>],
                    yAxisID: 'y-axis-amount',
                    pointStyle: 'triangle',
                    pointRadius: 7,
                }]
            };
        </script>
        <script>
            var linkChart = {
                labels: [<?= implode(', ', array_map('toDayVie', [7, 6, 5, 4, 3, 2, 1])) ?>],
                datasets: [<?php
                            foreach ($linkStatic as $linkName => $linkStat) {
                                echo "{
                                    label: '" . $linkName . " Count',
                                    borderColor: " . getRandomColor($mapNameToId[$linkName], 0) . ",
                                    backgroundColor: " . getRandomColor($mapNameToId[$linkName], 1) . ",
                                    fill: false,
                                    lineTension: 0,
                                    data: [" . implode(', ', array_reverse($linkStat['cnt'])) . "],
                                    yAxisID: 'y-axis-count',
                                    pointStyle: 'rect',
                                    pointRadius: 7,
                                }, {
                                label: '" . $linkName . " Amount',
                                borderColor: " . getRandomColor($mapNameToId[$linkName], 0) . ",
                                backgroundColor: " . getRandomColor($mapNameToId[$linkName], 1) . ",
                                fill: false,
                                lineTension: 0,
                                data: [" . implode(', ', array_reverse($linkStat['amount'])) . "],
                                yAxisID: 'y-axis-amount',
                                pointStyle: 'triangle',
                                pointRadius: 7,
                            },";
                            }
                            ?>]
            };

            window.onload = function() {
                var ctxLink = document.getElementById('linkChart').getContext('2d');
                new Chart.Line(ctxLink, {
                    data: linkChart,
                    options: {
                        responsive: true,
                        hoverMode: 'index',
                        stacked: false,
                        title: {
                            display: true,
                            text: '<?= $settings['name'] ?> Stats'
                        },
                        tooltips: {
                            position: 'nearest',
                            mode: 'index',
                            intersect: false,
                        },
                        scales: {
                            yAxes: [{
                                type: 'linear',
                                display: true,
                                position: 'left',
                                id: 'y-axis-count',
                            }, {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                id: 'y-axis-amount',
                                gridLines: {
                                    drawOnChartArea: false,
                                },
                            }],
                        }
                    }
                });


                var ctx = document.getElementById('chart').getContext('2d');
                new Chart.Line(ctx, {
                    data: lineChartData,
                    options: {
                        responsive: true,
                        hoverMode: 'index',
                        stacked: false,
                        title: {
                            display: true,
                            text: '<?= $settings['name'] ?> Stats'
                        },
                        tooltips: {
                            position: 'nearest',
                            mode: 'index',
                            intersect: false,
                        },
                        scales: {
                            yAxes: [{
                                type: 'linear',
                                display: true,
                                position: 'left',
                                id: 'y-axis-count',
                            }, {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                id: 'y-axis-amount',
                                gridLines: {
                                    drawOnChartArea: false,
                                },
                            }],
                        }
                    }
                });
            };
        </script>
    <?php } ?>
    <!-- App js -->
    <script src="<?= base_url() ?>assets/js/app.js?v=<?= VIE_VERSION ?>"></script>
    <script src="<?= base_url() ?>assets/js/vie/captcha.js?v=<?= VIE_VERSION ?>"></script>
    <script src="<?= base_url() ?>assets/js/vie/admin.js?v=<?= VIE_VERSION ?>"></script>
    <!-- <script src="<?= base_url() ?>assets/libs/tinymce/tinymce.min.js"></script> -->
    <script src="<?= base_url() ?>assets/libs/summernote/summernote-bs4.min.js"></script>
    <script src="<?= base_url() ?>assets/js/pages/form-editor.init.js"></script>
    <script type="text/javascript">
        $("a[href='<?= current_url() ?>']").attr('data-active', 'true');
    </script>
    <?php if (isset($_COOKIE['captcha'])) { ?>
        <script>
            $('option[value=<?= $_COOKIE['captcha'] ?>]').attr('selected', 'selected');
        </script>
    <?php } ?>
</body>

</html>