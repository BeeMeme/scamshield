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

	<link href="<?= base_url() ?>assets/css/bootstrap.min.css?v=<?= VIE_VERSION ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>assets/css/icons.min.css?v=<?= VIE_VERSION ?>" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>assets/css/app.min.css?v=<?= VIE_VERSION ?>" id="app-style" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>assets/css/styles.css?v=<?= VIE_VERSION ?>" rel="stylesheet" type="text/css" />

</head>

<body data-spy="scroll" data-target="#topnav-menu" data-offset="60">

	<nav class="navbar navbar-expand-lg navigation fixed-top sticky">
		<div class="container">
			<a class="navbar-logo" href="<?= base_url() ?>">
				<img src="<?= site_url('assets/images/logo.png') ?>" alt="" height="50" class="logo logo-light">
				<img src="<?= site_url('assets/images/logo.png') ?>" alt="" height="50" class="logo logo-dark">
			</a>

			<button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-toggle="collapse" data-target="#topnav-menu-content">
				<i class="fa fa-fw fa-bars"></i>
			</button>

			<div class="collapse navbar-collapse" id="topnav-menu-content">
				<ul class="navbar-nav ml-auto" id="topnav-menu">
					<li class="nav-item">
						<a class="nav-link active" href="#home">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#features">Features</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#statistics">Statistics</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#methods">Payment Methods</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#proofs">Payment Proofs</a>
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
				<div class="col-lg-5">
					<div class="text-white-50">
						<h1 class="text-white font-weight-semibold mb-3 hero-title"><?= $settings['name'] ?></h1>
						<p class="font-size-14"><?= $settings['description'] ?></p>

						<div class="button-items mt-4">
							<a href="<?= site_url('login') ?>" class="btn btn-success">Login</a>
							<a href="<?= site_url('register') ?>" class="btn btn-light">Register</a>
						</div>
					</div>
				</div>
				<?php if ($settings['lottery_status'] == 'on') { ?>
					<div class="col-lg-5 col-md-8 col-sm-10 ml-lg-auto">
						<div class="card overflow-hidden mb-0 mt-5 mt-lg-0">
							<div class="card-header text-center">
								<h5 class="mb-0">Lottery countdown</h5>
							</div>
							<div class="card-body">
								<div class="text-center">

									<h5>Time left to roll :</h5>
									<div class="mt-4">
										<div data-countdown="" class="counter-number ico-countdown"></div>
									</div>

									<div class="mt-4">
										<a class="btn btn-success w-md" href="<?= site_url('lottery') ?>">Buy a ticket</a>
									</div>

									<div class="mt-5">
										<h4 class="font-weight-semibold">Reward pool: <?= $lotteryReward ?> USD</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>

	<section class="section bg-white p-0" id="features">
		<div class="container">
			<div class="currency-price">
				<div class="row">
					<?php if ($settings['faucet_status'] == 'on') { ?>
						<div class="col-md-4">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<img class="feature-image" src="<?= base_url() ?>assets/images/home/faucet.png" alt="">
										</div>
										<div class="col-md-8">
											<h5>Faucet</h5>
											<p class="text-muted mb-0">Claim <?= $settings['reward'] ?> USD every <?= floor($settings['timer'] / 60) ?> minutes.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>

					<?php if ($settings['shortlink_status'] == 'on') { ?>
						<div class="col-md-4">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<img class="feature-image" src="<?= base_url() ?>assets/images/home/shortlink.png" alt="">
										</div>
										<div class="col-md-8">
											<h5>Shortlinks Wall</h5>
											<p class="text-muted mb-0">Click shortlinks to earn money and energy.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>

					<?php if ($settings['ptc_status'] == 'on') { ?>
						<div class="col-md-4">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<img class="feature-image" src="<?= base_url() ?>assets/images/home/ptc.png" alt="">
										</div>
										<div class="col-md-8">
											<h5>PTC</h5>
											<p class="text-muted mb-0">View PTC ads to earn money.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>

					<?php if ($settings['lottery_status'] == 'on') { ?>
						<div class="col-md-4">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<img class="feature-image" src="<?= base_url() ?>assets/images/home/lottery.png" alt="">
										</div>
										<div class="col-md-8">
											<h5>Lottery</h5>
											<p class="text-muted mb-0">Buy lottery and earn big reward.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>

					<?php if ($settings['achievement_status'] == 'on') { ?>
						<div class="col-md-4">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<img class="feature-image" src="<?= base_url() ?>assets/images/home/achievement.png" alt="">
										</div>
										<div class="col-md-8">
											<h5>Achievements</h5>
											<p class="text-muted mb-0">Complete achievements for extra money and energy.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>

					<?php if ($settings['offerwall_status'] == 'on') { ?>
						<div class="col-md-4">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<img class="feature-image" src="<?= base_url() ?>assets/images/home/offerwall.png" alt="">
										</div>
										<div class="col-md-8">
											<h5>Offerwalls</h5>
											<p class="text-muted mb-0">Complete tasks, surveys to earn money.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>

					<?php if ($settings['autofaucet_status'] == 'on') { ?>
						<div class="col-md-4">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<img class="feature-image" src="<?= base_url() ?>assets/images/home/auto.png" alt="">
										</div>
										<div class="col-md-8">
											<h5>Auto Faucet</h5>
											<p class="text-muted mb-0">Earn money just by leaving the Auto Faucet running.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>

					<?php if ($settings['dice_status'] == 'on') { ?>
						<div class="col-md-4">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<img class="feature-image" src="<?= base_url() ?>assets/images/home/dice.png" alt="">
										</div>
										<div class="col-md-8">
											<h5>Dice</h5>
											<p class="text-muted mb-0">Try your luck with Dice.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>

					<div class="col-md-4">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-4">
										<img class="feature-image" src="<?= base_url() ?>assets/images/home/level.png" alt="">
									</div>
									<div class="col-md-8">
										<h5>Level System</h5>
										<p class="text-muted mb-0">Level up your account to earn more.</p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-4">
										<img class="feature-image" src="<?= base_url() ?>assets/images/home/rank.png" alt="">
									</div>
									<div class="col-md-8">
										<h5>Ranking</h5>
										<p class="text-muted mb-0">We reward to top activity users and top referral user weekly.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section" id="statistics">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="text-center mb-5">
						<div class="small-title">More about us</div>
						<h4>Statistics</h4>
					</div>
				</div>
			</div>

			<div class="stat">
				<div class="row text-center">
					<div class="col-md-4">
						<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
							<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
							<circle cx="9" cy="7" r="4"></circle>
							<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
							<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
						</svg>
						<h3 class="mt-3"><?= number_format($stat['total_user']) ?> <span style="font-size: 18px;">users</span></h3>
					</div>
					<div class="col-md-4">
						<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award">
							<circle cx="12" cy="8" r="7"></circle>
							<polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
						</svg>
						<h3 class="mt-3"><?= number_format($stat['earning']) ?> <span style="font-size: 18px;"> USD earned</span></h3>
					</div>
					<div class="col-md-4">
						<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
							<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
							<polyline points="7 10 12 15 17 10"></polyline>
							<line x1="12" y1="15" x2="12" y2="3"></line>
						</svg>
						<h3 class="mt-3"><?= number_format($stat['withdrawals']) ?> <span style="font-size: 18px;">withdrawals</span></h3>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section pt-4 bg-white" id="methods">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="text-center mb-5">
						<div class="small-title">Payment methods</div>
						<h4>Cryptocurrencies Supported</h4>
					</div>
				</div>
			</div>
			<div class="row align-items-center text-center">
				<?php foreach ($methods as $method) { ?>
					<div class="col">
						<img src="<?= site_url('assets/images/currencies/' . strtolower($method['code']) . '.png') ?>" alt="<?= $method['code'] ?>">
						<p class="text-muted"><?= $method['name'] ?></p>
					</div>
				<?php } ?>
			</div>

		</div>
	</section>

	<section class="section" id="proofs">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="text-center mb-5">
						<div class="small-title">Do you trust us?</div>
						<h4>Payment Proofs</h4>
					</div>
				</div>
			</div>

			<div class="table-responsive">
				<table class="table table-striped text-center">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Username</th>
							<th scope="col">Address</th>
							<th scope="col">Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($withdrawHistory as $wd) {
							echo '<tr><th scope="row">' . $wd["id"] . '</th><td>' . $wd["username"] . '</td><td>' . $wd["wallet"] . '</td><td>' . format_money($wd["amount"]) . ' USD</td></tr>';
						}
						?>
					</tbody>
				</table>
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
					<p>Powered by <a href="https://faucetscript.net/faucet/vie-faucet-script/" target="_blank">Vie Faucet Script</a></p>
				</div>

			</div>
		</div>
	</footer>

	<?= $settings['footer_code'] ?>

	<script src="<?= base_url() ?>assets/libs/moment/moment.js"></script>
	<script src="<?= base_url() ?>assets/libs/moment/moment-timezone-with-data.js"></script>
	<script>
		var nextRoll = moment.tz(<?= 1000 * $settings['lottery_date'] ?>, "<?= date_default_timezone_get() ?>").toDate();
	</script>
	<script src="<?= base_url() ?>assets/libs/jquery/jquery.min.js"></script>
	<script src="<?= base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url() ?>assets/libs/metismenu/metisMenu.min.js"></script>
	<script src="<?= base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
	<script src="<?= base_url() ?>assets/libs/node-waves/waves.min.js"></script>

	<script src="<?= base_url() ?>assets/libs/jquery.easing/jquery.easing.min.js"></script>

	<!-- Plugins js-->
	<script src="<?= base_url() ?>assets/libs/jquery-countdown/jquery.countdown.min.js"></script>

	<!-- owl.carousel js -->
	<script src="<?= base_url() ?>assets/libs/owl.carousel/owl.carousel.min.js"></script>

	<!-- ICO landing init -->
	<script src="<?= base_url() ?>assets/js/pages/ico-landing.init.js"></script>

	<script src="<?= base_url() ?>assets/js/app.js?v=<?= VIE_VERSION ?>"></script>
	<?php include 'adblock.php'; ?>
</body>

</html>