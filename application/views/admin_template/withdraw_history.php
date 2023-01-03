<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4"><?= $page ?></h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <div class="table-responsive">
                    <table class="table table-striped" style="font-size: 10px;">
                        <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 10px;">
                            <?php foreach ($history as $value) { ?>
                                <tr>
                                    <th scope="row"><?= $value['username'] ?></th>
                                    <td><?= $value['amt'] ?></td>
                                    <td><a href="<?= site_url("/admin/users/details/" . $value['user_id']) ?>" class="btn btn-secondary btn-sm" title="Detail"><i class="fas fa-user-cog"></i></a></td>
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