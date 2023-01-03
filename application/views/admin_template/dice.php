<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
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
                <h4 class="card-title mb-4">Dice settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/dice') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Dice status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="dice_status">
                                <option value="on" <?= ($settings['dice_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['dice_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Dice maximum bet amount</label>
                        <div class="col-sm-9">
                            <input type="number" min="0.000001" step="0.000001" class="form-control" id="max_bet" name="max_bet" value="<?= $settings['max_bet'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Dice minimum bet amount</label>
                        <div class="col-sm-9">
                            <input type="number" min="0.000001" step="0.000001" class="form-control" id="min_bet" name="min_bet" value="<?= $settings['min_bet'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">House EDGE (%)</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" max="100" step="0.001" class="form-control" id="house_edge" name="house_edge" value="<?= $settings['house_edge'] ?>">
                        </div>
                    </div>
                    <small>Make sure House Edge amount always greater than 0.000001 (minimum amount = min_bet*house_edge/100)</small>

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