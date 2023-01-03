<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Mining settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/mining') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Mining status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="mining_status">
                                <option value="on" <?= ($settings['mining_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['mining_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Profit share (%)</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="mining_share" value="<?= $settings['mining_share'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Webminepool site key</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="webminepool_site_key" value="<?= $settings['webminepool_site_key'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Webminepool private key</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="webminepool_secret_key" value="<?= $settings['webminepool_secret_key'] ?>">
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