<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Pending task submissions</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <div class="row">
                    <div class="col-3">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <?php foreach ($tasks as $task) { ?>
                                <a class="nav-link <?= ($taskId == $task['id']) ? 'active' : '' ?>" href="<?= site_url('admin/tasks/submissions/' . $task['id']) ?>" <?= ($taskId == $task['id']) ? 'aria-selected="true"' : '' ?>>
                                    <?= $task['name'] ?>
                                    <span class="badge badge-success"><?= $task['cnt'] ?></span>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="table-responsive">
                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">Username</th>
                                            <th scope="col">Task name</th>
                                            <th scope="col">Proof</th>
                                            <th scope="col">Time</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($submissions as $submission) { ?>
                                            <tr>
                                                <th scope="row"><a href="<?= site_url('admin/users/details/' . $submission['userId']) ?>" target="_blank"><?= $submission['username'] ?></a></th>
                                                <td><?= $submission['name'] ?></td>
                                                <td><?= !filter_var($submission['proof'], FILTER_VALIDATE_URL) ? $submission['proof'] : '<a href="' . $submission['proof'] . '" target="_blank">' . $submission['proof'] . '</a>' ?></td>
                                                <td><?= timespan($submission["claim_time"], time(), 2) ?> ago</td>
                                                <td><a href="<?= site_url('admin/tasks/accept/' . $submission['id']) ?>" class="btn btn-success btn-sm" style="margin: 0 2px 0 2px;">Accept</a><a href="<?= site_url('admin/tasks/deny/' . $submission['id']) ?>" class="btn btn-danger btn-sm" style="margin: 0 2px 0 2px;">Deny</a><a href="<?= site_url('admin/tasks/hide/' . $submission['id']) ?>" class="btn btn-danger btn-sm" style="margin: 0 2px 0 2px;" title="User will not be able to submit this task again.">Deny forever</a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?= $pagination ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>