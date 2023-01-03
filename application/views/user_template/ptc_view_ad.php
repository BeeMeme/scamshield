<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title><?= $ads['name'] ?> | <?= $settings['name'] ?></title>
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
    <link href="<?= base_url() ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/css/styles.css" rel="stylesheet" type="text/css" />

</head>


<body data-sidebar="dark" style="overflow: hidden">

    <div class="container-fluid ptc-header">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-success" href="<?= base_url() ?>">Back to home</a>
            </div>
            <div class="col-md-6">
                <span class="font-size-15 text-truncate text-white" id="ptcCountdown">Please wait...</span>
            </div>
        </div>
    </div>
    <iframe id="ads" src="<?= $ads['url'] ?>" frameborder="0" style="width: 100%; height: calc(100vh - 75px);" sandbox="allow-same-origin allow-scripts allow-forms"></iframe>
    <div class="modal fade" id="ptcCaptcha" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Complete the captcha to get reward</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= site_url('/ptc/verify/' . $ads['id']) ?>" method="POST">
                        <center>
                            <?= $captcha_display ?>
                        </center>
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">
                        <input type="hidden" name="token" value="<?= $user['token'] ?>">
                        <button id="verify" class="btn btn-success btn-block" type="submit">Verify</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var timer = <?= $ads['timer'] ?>;
        var url = '<?= $ads['url'] ?>';
    </script>
    <script src="<?= base_url() ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/node-waves/waves.min.js"></script>
    <!-- App js -->
    <script src="<?= base_url() ?>assets/js/app.js"></script>
    <script src="<?= base_url() ?>assets/js/vie/captcha.js"></script>
    <script src="<?= base_url() ?>assets/js/vie/ptc.js"></script>
    <?php if (isset($_COOKIE['captcha'])) { ?>
        <script>
            $('option[value=<?= $_COOKIE['captcha'] ?>]').attr('selected', 'selected');
        </script>
    <?php } ?>
    <?php
    if (isset($_SESSION['sweet_message'])) {
        echo $_SESSION['sweet_message'];
    }
    ?>
    <?= $settings['footer_code'] ?>
    <?php include 'adblock.php'; ?>
</body>

</html>