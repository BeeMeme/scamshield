<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">PTC ads settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/ptc') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">PTC status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="ptc_status">
                                <option value="on" <?= ($settings['ptc_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['ptc_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">PTC exp reward</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="ptc_exp_reward" value="<?= $settings['ptc_exp_reward'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">PTC top ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="ptc_top_ad"><?= $settings['ptc_top_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">PTC footer ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="ptc_footer_ad"><?= $settings['ptc_footer_ad'] ?></textarea>
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