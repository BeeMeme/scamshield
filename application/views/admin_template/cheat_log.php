<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Cheat logs</h4>
                <table class="table table-striped text-center" style="font-size: 15px;">
                    <thead>
                        <tr>
                            <th scope="col">User Id</th>
                            <th scope="col">Log</th>
                            <th scope="col">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $log) { ?>
                            <tr>
                                <th scope="row"><a href="<?= site_url('/admin/users/details/' . $log['user_id']) ?>" target="_blank"><?= $log['user_id'] ?> <i class="fas fa-external-link-alt"></i></a></th>
                                <td><?= $log['log'] ?></td>
                                <td><?= timespan($log["create_time"], time(), 2) ?> ago</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>