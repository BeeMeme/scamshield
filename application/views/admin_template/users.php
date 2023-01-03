<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 text-center">Find user</h4>
                <div class="alert alert-info text-center">Search by IP Address will look at <code>users</code>, <code>faucet_history</code>, <code>faucet_history</code>, <code>links_history</code>, <code>ptc_history</code>, <code>offerwall_history</code> tables</div>
                <form action="<?= site_url('admin/users/find') ?>" method="POST" autocomplete="off">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label text-center">Value</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="user" placeholder="Id, Username, Email, Ip" required>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label text-center">Type</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="type">
                                <option value="id">ID</option>
                                <option value="username">Username</option>
                                <option value="email">Email</option>
                                <option value="ip">Ip Address</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <div class="row">

                                <div class="col">
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">Find</button>
                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <a href="<?= site_url('/admin/users/delete_banned') ?>" class="btn btn-danger btn-sm w-md">Delete Banned Users</a>
                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <a href="<?= site_url('/admin/users/delete_inactive') ?>" class="btn btn-danger btn-sm w-md">Delete Inactive Users in the last 30 days</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Users</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <div class="table-responsive">
                    <table class="table table-striped" style="font-size: 10px;">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Email</th>
                                <th scope="col">Username</th>
                                <th scope="col">Last Active</th>
                                <th scope="col">Balance</th>
                                <th scope="col">Ip Address</th>
                                <th scope="col">Referred By</th>
                                <th scope="col">Verified</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 10px;">
                            <?php foreach ($users as $user) { ?>
                                <tr>
                                    <th scope="row"><?= $user['id'] ?></th>
                                    <td><?= $user['email'] ?> <?= ($user['isocode'] != 'N/A') ? '<img src="' . base_url() . 'assets/images/flags/' . $user['isocode'] . '.png" title="' . $user['country'] . '">' : '' ?></td>
                                    <td><?= $user['username'] ?></td>
                                    <td><?= timespan($user["last_active"], time(), 2) ?> ago</td>
                                    <td><?= $user['balance'] ?></td>
                                    <td class="admin-ip-address"><?= $user['ip_address'] ?></td>
                                    <td><a href="<?= site_url('admin/users/details/' . $user['referred_by']) ?>"><?= $user['referred_by'] ?></a></td>
                                    <td><?= $user['verified'] ?></td>
                                    <td><a href="<?= site_url("/admin/users/details/" . $user['id']) ?>" class="btn btn-secondary btn-sm" title="Detail"><i class="fas fa-user-cog"></i></a></td>
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