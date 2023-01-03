<div class="ads">
    <?= $settings['autofaucet_top_ad'] ?>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Auto Faucet</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                if (!isset($error)) { ?>
                    <div class="text-center">
                        <div class="alert alert-info">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-gift">
                                <polyline points="20 12 20 22 4 22 4 12"></polyline>
                                <rect x="2" y="7" width="20" height="5"></rect>
                                <line x1="12" y1="22" x2="12" y2="7"></line>
                                <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path>
                                <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path>
                            </svg>
                            Please wait <b id="minute"><?= floor($settings['autofaucet_timer'] / 60) ?></b>:<b id="second"><?= $settings['autofaucet_timer'] % 60 ?></b> to get <?= currency($settings['autofaucet_reward'], $settings['currency_rate']) ?>
                        </div>
                        <div class="progress br-30">
                            <div class="progress-bar-striped bg-secondary" id="progress" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="60"></div>
                        </div>
                        <form action="<?= site_url('auto/verify') ?>" method="POST" id="verify">
                            <input type="hidden" name="token" value="<?= $_SESSION['autoFaucetToken'] ?>">
                        </form>
                        <script>
                            let timer = <?= $settings['autofaucet_timer'] ?>,
                                current = 0;
                            const autoFaucet = setInterval(function() {
                                current += 1;
                                let percent = current * 100 / timer;
                                $('#progress').attr('style', 'width: ' + percent + '%;');
                                $('#progress').attr('aria-valuenow', percent);
                                if (current >= timer) {
                                    clearInterval(autoFaucet);
                                    $('#verify').submit();
                                } else {
                                    let wait = Math.floor(timer - current);
                                    let minutes = Math.floor(wait / 60);
                                    let seconds = wait % 60;
                                    $('#minute').text(minutes);
                                    $('#second').text(seconds);
                                    wait -= 1;
                                }
                            }, 1000);
                        </script>
                    </div>
                <?php } else {
                    echo faucet_alert('danger', 'You don\'t have enough energy for Auto Faucet!');
                } ?>
                <!-- end table-responsive -->
            </div>
        </div>
    </div>
</div>