<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 text-center">Task settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/tasks/add') ?>" method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Task name</label>
                                <input type="text" class="form-control" name="name" placeholder="Name" minlength="1" maxlength="75">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Task requirement</label>
                                <input type="text" class="form-control" name="requirement" placeholder="Things used to verify user has completed task." minlength="1" maxlength="100">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>+Reward</label>
                                <input type="number" min="0.000001" step="0.000001" class="form-control" name="usd_reward" placeholder="Reward">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>+Energy</label>
                                <input type="number" class="form-control" name="energy_reward" placeholder="Energy" min=0>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>+Exp</label>
                                <input type="number" class="form-control" name="exp_reward" placeholder="Energy" min=0 max=100>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Task Description (HTML)</label>
                            <textarea class="form-control" rows="5" name="description"></textarea>
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
                <h4 class="card-title mb-4">Your tasks</h4>
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
                                <th scope="col">Name</th>
                                <th scope="col">Reward</th>
                                <th scope="col">Energy</th>
                                <th scope="col">Exp</th>
                                <th scope="col">Requirement</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tasks as $task) { ?>
                                <form action="<?= site_url('/admin/tasks/update/' . $task['id']) ?>" method="POST">
                                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                                    <tr>
                                        <th scope="row"><?= $task['id'] ?></th>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="name" value="<?= $task['name'] ?>" minlength="1" maxlength="75">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" min="0.000001" step="0.000001" class="form-control" name="usd_reward" value="<?= $task['usd_reward'] ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="energy_reward" value="<?= $task['energy_reward'] ?>" min="0">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="exp_reward" value="<?= $task['exp_reward'] ?>" min="0" max=100>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="requirement" value="<?= $task['requirement'] ?>" minlength="1" maxlength="100">
                                            </div>
                                        </td>
                                        <td>
                                            <button type="submit" class="edit-button btn btn-warning btn-sm">edit</button>
                                            <a class="btn btn-danger btn-sm" href="<?= site_url('admin/tasks/delete/' . $task['id']) ?>">delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="5">
                                            <div class="form-group">
                                            <label>Description</label>
                                                <textarea style="min-width: 400px" class="form-control" rows="7" name="description"><?= str_replace('\r\n', "\r\n", $task['description']) ?></textarea>
                                            </div>
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
                <h4 class="card-title mb-4">Task settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/tasks') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Task status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="tasks_status">
                                <option value="on" <?= ($settings['tasks_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['tasks_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Task top ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="tasks_top_ad"><?= $settings['tasks_top_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Task footer ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="tasks_footer_ad"><?= $settings['tasks_footer_ad'] ?></textarea>
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