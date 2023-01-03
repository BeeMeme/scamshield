<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Recent Notifications</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Username</th>
                                <th scope="col">Content</th>
                                <th scope="col">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($notifications as $notification) { ?>
                                <tr>
                                    <th scope="row"><?= $notification['id'] ?></th>
                                    <th><a target="_blank" href="<?= site_url('admin/users/details/' . $notification['user_id']) ?>"><?= $notification['username'] ?></a></th>
                                    <td>
                                        <?= $notification['content'] ?>
                                    </td>
                                    <td>
                                        <?= timespan($notification["create_time"], time(), 2) ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>