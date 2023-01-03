<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Cheat logs</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center" style="font-size: 15px;">
                        <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Comment</th>
                                <th scope="col">IP Address</th>
                                <th scope="col">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $log) { ?>
                                <tr>
                                    <th scope="row"><a href="<?= site_url('admin/users/details/' . $log['user_id']) ?>" target="_blank"><?= $log['username'] ?></a></th>
                                    <td><?= $log['log'] ?></td>
                                    <th><a target="_blank" href="<?= site_url('admin/users/find_ip/' . $log['ip_address']) ?>"><?= $log['ip_address'] ?> <i class="fas fa-search"></i></a></th>
                                    <td><?= timespan($log["create_time"], time(), 2) ?> ago</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>