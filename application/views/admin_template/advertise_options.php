<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Add advertising option</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/advertise/option_add') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Timer (in second)</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="timer" name="timer" required>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Price (amount that charge advertiser each view)</label>
                        <div class="col-sm-9">
                            <input type="number" min="0.000001" step="0.000001" class="form-control" id="price" name="price" required>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Reward (amount that user receive each view)</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="reward" name="reward" required>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Minimum view</label>
                        <div class="col-sm-9">
                            <input type="number" min="1" class="form-control" id="min_view" name="min_view" required>
                        </div>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Add</button>
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
                <div class="alert alert-warning text-center">Updating options will not affect on running campaigns!</div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Price</th>
                                <th scope="col">Reward</th>
                                <th scope="col">Duration</th>
                                <th scope="col">Minimum view</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($options as $option) { ?>
                                <form action="<?= site_url('/admin/advertise/option_update/' . $option['id']) ?>" method="POST" autocomplete="off">
                                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                                    <tr>
                                        <th scope="row"><?= $option['id'] ?></th>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="price" min="0.000001" step="0.000001" value="<?= $option['price'] ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="reward" min="0.000001" step="0.000001" value="<?= $option['reward'] ?>">
                                            </div>

                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="timer" value="<?= $option['timer'] ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="min_view" value="<?= $option['min_view'] ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <button type="submit" class="edit-button btn btn-warning btn-sm">edit</button>
                                            <a class="btn btn-danger btn-sm" href="<?= site_url('admin/advertise/option_delete/' . $option['id']) ?>">delete</a>
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
</div>