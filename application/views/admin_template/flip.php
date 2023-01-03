<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <b>Coin Flip is an addon, you can purchase it: <a href="https://shoppy.gg/product/SPmx7Jj" target="_blank">here</a></b>
                <h4 class="card-title mb-4">Today Stat</h4>
                <ul>
                    <li>Number Of Win: <?= $countWin ?></li>
                    <li>Amount Of Win: <?= $amountWin ?> USD</li>
                    <li>Number Of Loose: <?= $countLoose ?></li>
                    <li>Amount Of Loose: <?= format_money(abs($amountLoose)) ?> USD</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Coin Flip settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/coinflip') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Coin Flip status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="coinflip_status">
                                <option value="on" <?= ($settings['coinflip_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['coinflip_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Coin Flip maximum bet amount</label>
                        <div class="col-sm-9">
                            <input type="number" min="0.000001" step="0.000001" class="form-control" id="coinflip_max_bet" name="coinflip_max_bet" value="<?= $settings['coinflip_max_bet'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Coin Flip minimum bet amount</label>
                        <div class="col-sm-9">
                            <input type="number" min="0.000001" step="0.000001" class="form-control" id="coinflip_min_bet" name="coinflip_min_bet" value="<?= $settings['coinflip_min_bet'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">House EDGE (%)</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" max="100" step="0.001" class="form-control" id="coinflip_edge" name="coinflip_edge" value="<?= $settings['coinflip_edge'] ?>">
                        </div>
                    </div>
                    <small>Make sure House Edge amount always greater than 0.000001 (minimum amount = coinflip_min_bet*coinflip_min_bet/100)</small>

                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>