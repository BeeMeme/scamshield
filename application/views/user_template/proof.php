<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?= $page ?> | <?= $settings['name'] ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url() ?>public/assets/img/favicon.ico" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?= base_url() ?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>public/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="<?= base_url() ?>public/assets/css/pages/privacy/privacy.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
</head>

<body>


    <div id="headerWrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-12 text-center mb-5">
                    <a href="<?=base_url()?>" class="navbar-brand-privacy">
                        <img src="<?= base_url() ?>public/img/home_logo.png" class="img-fluid" alt="logo">
                    </a>
                </div>
                <div class="col-md-12 col-sm-12 col-12 text-center">
                    <h2 class="main-heading">Payment Proofs</h2>
                </div>
            </div>
        </div>
    </div>

    <div id="privacyWrapper" class="">
        <div class="privacy-container">
            <div class="privacyContent">
                <div class="privacy-content-container">
                
                <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($proofs as $value) {
                                        echo '<tr><th scope="row">' . $value["id"] . '</th><td>' . $value["amount"] . '</td><td>' . $value["wallet"] . '</td><td>' . timespan($value["claim_time"], time(), 2) . ' ago</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                </div>

            </div>
        </div>
    </div>
	<div class="ads">
		<?= $settings['footer_code'] ?>
	</div>
	<hr>

    <div id="miniFooterWrapper" class="">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="position-relative">
                        <div class="arrow text-center">
                            <p class=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 mx-auto col-lg-6 col-md-6 site-content-inner text-md-left text-center copyright align-self-center">
                            <p class="mt-md-0 mt-4 mb-0">Copyright &copy <?= date('Y') ?> <a href="<?= base_url() ?>"><?= $settings['name'] ?></a>, All rights reserved.</p>
                        </div>
                        <div class="col-xl-5 mx-auto col-lg-6 col-md-6 site-content-inner text-md-right text-center align-self-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?= base_url() ?>public/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="<?= base_url() ?>public/bootstrap/js/popper.min.js"></script>
    <script src="<?= base_url() ?>public/bootstrap/js/bootstrap.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <script>
        // Scroll To Top
        $(document).on('click', '.arrow', function(event) {
            event.preventDefault();
            var body = $("html, body");
            body.stop().animate({
                scrollTop: 0
            }, 500, 'swing');
        });
    </script>

</body>

</html>