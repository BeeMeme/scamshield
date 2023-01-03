<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Autofaucet settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/auto') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Autofaucet status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="autofaucet_status">
                                <option value="on" <?= ($settings['autofaucet_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['autofaucet_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Autofaucet top ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="autofaucet_top_ad"><?= $settings['autofaucet_top_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Autofaucet timer</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="daily_limit" name="autofaucet_timer" id="autofaucet_timer" value="<?= $settings['autofaucet_timer'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Autofaucet rewad</label>
                        <div class="col-sm-9">
                            <input type="number" min="0.000001" step="0.000001" class="form-control" id="autofaucet_reward" name="autofaucet_reward" value="<?= $settings['autofaucet_reward'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Autofaucet exp reward</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="autofaucet_exp_reward" value="<?= $settings['autofaucet_exp_reward'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Autofaucet cost</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="autofaucet_cost" name="autofaucet_cost" value="<?= $settings['autofaucet_cost'] ?>">
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