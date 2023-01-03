<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Lottery Stat</h4>
                <ul>
                    <li>Total Pottery: <?= $countLottery ?></li>
                    <li>Reward Pool: <?= $countLottery * $settings['lottery_reward'] + $settings['lottery_base_reward'] ?> USD</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Lottery settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/lottery') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Lottery status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="lottery_status">
                                <option value="on" <?= ($settings['lottery_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['lottery_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Lottery exp reward</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="lottery_exp_reward" value="<?= $settings['lottery_exp_reward'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Lottery base reward</label>
                        <div class="col-sm-9">
                            <input type="number" min="0.000001" step="0.000001" class="form-control" id="lottery_base_reward" name="lottery_base_reward" value="<?= $settings['lottery_base_reward'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Lottery price (Amount user has to spend to buy a ticket)</label>
                        <div class="col-sm-9">
                            <input type="number" min="0.000001" step="0.000001" class="form-control" id="lottery_price" name="lottery_price" value="<?= $settings['lottery_price'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Lottery round duration</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="lottery_reward" name="lottery_duration" value="<?= $settings['lottery_duration'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Lottery reward (Amount that added to reward pool)</label>
                        <div class="col-sm-9">
                            <input type="number" min="0.000001" step="0.000001" class="form-control" id="lottery_reward" name="lottery_reward" value="<?= $settings['lottery_reward'] ?>">
                        </div>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">
                    <div class="form-group row justify-content-end">
                        <div class="col-sm-6">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Update</button>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div>
                                <a href="<?= site_url('admin/lottery/new_round') ?>" class="btn btn-success w-md">New Round</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Lottery ads settings</h4>
                <form action="<?= site_url('admin/update/lottery') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Lottery top ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="lottery_top_ad"><?= $settings['lottery_top_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Lottery bottom ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="lottery_bottom_ad"><?= $settings['lottery_bottom_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Lottery left ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="lottery_left_ad"><?= $settings['lottery_left_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Lottery right ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="lottery_right_ad"><?= $settings['lottery_right_ad'] ?></textarea>
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