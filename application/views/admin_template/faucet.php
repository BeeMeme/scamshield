<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Faucet settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/faucet') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Faucet status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="faucet_status">
                                <option value="on" <?= ($settings['faucet_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['faucet_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Daily limit</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="daily_limit" name="daily_limit" id="daily_limit" value="<?= $settings['daily_limit'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Reward</label>
                        <div class="col-sm-9">
                            <input type="number" min="0.000001" step="0.000001" class="form-control" id="reward" name="reward" value="<?= $settings['reward'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Faucet Cost</label>
                        <div class="col-sm-9">
                            <input type="number" min="1" class="form-control" id="faucet_cost" name="faucet_cost" value="<?= $settings['faucet_cost'] ?>">
                            <small>How much energy does user need to claim faucet when daily limit reached?</small>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Faucet exp reward</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="faucet_exp_reward" value="<?= $settings['faucet_exp_reward'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Level Bonus (%)</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="level_bonus" min="0" step="0.0001" value="<?= $settings['level_bonus'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Max Bonus (%)</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="max_bonus" min="0" step="0.0001" value="<?= $settings['max_bonus'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Timer</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="timer" name="timer" value="<?= $settings['timer'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Antibotlinks</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm" name="antibotlinks" id="antibotlinks">
                                <option value="on" <?= ($settings['antibotlinks'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['antibotlinks'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Top ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="faucet_top_ad"><?= $settings['faucet_top_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Header ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="faucet_header_ad"><?= $settings['faucet_header_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Left ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="faucet_left_ad"><?= $settings['faucet_left_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Right ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="faucet_right_ad"><?= $settings['faucet_right_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Bottom ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="faucet_bottom_ad"><?= $settings['faucet_bottom_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Footer ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="faucet_footer_ad"><?= $settings['faucet_footer_ad'] ?></textarea>
                        </div>
                    </div>
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