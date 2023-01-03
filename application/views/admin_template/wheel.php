<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 text-center">Add reward</h4>
                <form action="<?= site_url('admin/wheel/add') ?>" method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Text</label>
                                <input type="text" class="form-control" name="text" placeholder="Text">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Color</label>
                                <input type="text" class="form-control" name="color" placeholder="#845EC2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>USD Reward</label>
                                <input type="text" class="form-control" name="usd_reward" placeholder="Reward">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Exp Reward</label>
                                <input type="number" class="form-control" name="exp_reward" placeholder="Exp">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Probability</label>
                                <input type="number" class="form-control" name="probability" placeholder="Probability">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                    <button type="submit" class="btn btn-success btn-lg btn-block"><i class="fas fa-check"></i> Add</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Your prizes</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Text</th>
                                <th scope="col">Color</th>
                                <th scope="col">USD Reward</th>
                                <th scope="col">Exp Reward</th>
                                <th scope="col">Probability</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($prizes as $prize) { ?>
                                <form action="<?= site_url('/admin/wheel/update/' . $prize['id']) ?>" method="POST">
                                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                                    <tr>
                                        <th scope="row"><?= $prize['id'] ?></th>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="text" value="<?= $prize['text'] ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="color" value="<?= $prize['color'] ?>">
                                            </div>

                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="usd_reward" value="<?= $prize['usd_reward'] ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="exp_reward" value="<?= $prize['exp_reward'] ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="probability" value="<?= $prize['probability'] ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <button type="submit" class="edit-button btn btn-warning btn-sm">edit</button>
                                            <a class="btn btn-danger btn-sm" href="<?= site_url('admin/wheel/delete/' . $prize['id']) ?>">delete</a>
                                        </td>
                                    </tr>
                                </form>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Wheel settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/wheel') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Wheel status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="wheel_status">
                                <option value="on" <?= ($settings['wheel_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['wheel_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Energy cost</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="wheel_energy" name="wheel_energy" value="<?= $settings['wheel_energy'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Timer</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="wheel_timer" name="wheel_timer" value="<?= $settings['wheel_timer'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Daily limit</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="wheel_limit" name="wheel_limit" value="<?= $settings['wheel_limit'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Top ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="wheel_top_ad"><?= $settings['wheel_top_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Header ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="wheel_header_ad"><?= $settings['wheel_header_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Left ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="wheel_left_ad"><?= $settings['wheel_left_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Right ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="wheel_right_ad"><?= $settings['wheel_right_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Bottom ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="wheel_bottom_ad"><?= $settings['wheel_bottom_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Footer ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="wheel_footer_ad"><?= $settings['wheel_footer_ad'] ?></textarea>
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