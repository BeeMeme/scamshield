<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Achievements settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <?php foreach ($achievements as $achievement) { ?>
                    <form action="<?= site_url('admin/achievements/edit/' . $achievement['id']) ?>" method="POST">
                        <input type="hidden" name="<?= $csrf_name ?>" id="token" value="<?= $csrf_hash ?>">
                        <div class="form-row mb-4">
                            <div class="col">
                                <label>For</label>
                                <select class="form-control form-control-sm" name="type">
                                    <option value="0" <?= ($achievement['type'] == 0) ? 'selected' : '' ?>>Faucet</option>
                                    <option value="1" <?= ($achievement['type'] == 1) ? 'selected' : '' ?>>Shortlinks</option>
                                    <option value="2" <?= ($achievement['type'] == 2) ? 'selected' : '' ?>>PTC</option>
                                    <option value="3" <?= ($achievement['type'] == 3) ? 'selected' : '' ?>>Lottery</option>
                                </select>
                            </div>
                            <div class="col">
                                <label>Condition</label>
                                <input type="number" name="condition" class="form-control" value="<?= $achievement['condition'] ?>" required="">
                            </div>
                            <div class="col">
                                <label>Usd Reward</label>
                                <input type="number" name="reward_usd" min="0.000001" step="0.000001" class="form-control" value="<?= $achievement['reward_usd'] ?>" required="">
                            </div>
                            <div class="col">
                                <label>Energy Reward</label>
                                <input type="number" name="reward_energy" class="form-control" value="<?= $achievement['reward_energy'] ?>" required="">
                            </div>
                            <div class="col">
                                <label>Actions</label>
                                <div style="display: block;">
                                    <button type="submit" class="btn btn-success btn-sm">Save</button>
                                    <a href="<?= site_url('admin/achievements/delete/' . $achievement['id']) ?>" class="btn btn-danger btn-sm">Delete</a>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php } ?>
                <hr>

                <form action="<?= site_url('admin/achievements/add/') ?>" method="POST">
                    <input type="hidden" name="<?= $csrf_name ?>" id="token" value="<?= $csrf_hash ?>">
                    <div class="form-row mb-4">
                        <div class="col">
                            <label>For</label>
                            <select class="form-control form-control-sm" name="type">
                                <option value="0">Faucet</option>
                                <option value="1">Shortlinks</option>
                                <option value="2">PTC</option>
                                <option value="3">Lottery</option>
                            </select>
                        </div>
                        <div class="col">
                            <label>Condition</label>
                            <input type="number" name="condition" class="form-control" value="" required="">
                        </div>
                        <div class="col">
                            <label>USD Reward</label>
                            <input type="text" min="0.000001" step="0.000001" name="reward_usd" class="form-control" value="" required="">
                        </div>
                        <div class="col">
                            <label>Energy Reward</label>
                            <input type="number" name="reward_energy" class="form-control" value="" required="">
                        </div>
                        <div class="col">
                            <label>Actions</label>
                            <div style="display: block;">
                                <button type="submit" class="btn btn-success btn-sm">Add</button>
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
                <h4 class="card-title mb-4">Achievements settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/achievements') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Achievement status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="achievement_status">
                                <option value="on" <?= ($settings['achievement_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['achievement_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Achievement exp reward</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="achievement_exp_reward" value="<?= $settings['achievement_exp_reward'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Achievement top ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="achievements_top_ad"><?= $settings['achievements_top_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Achievement footer ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="achievements_footer_ad"><?= $settings['achievements_footer_ad'] ?></textarea>
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