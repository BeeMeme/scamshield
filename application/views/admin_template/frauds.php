<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4"><?= $page ?></h4>
                <div class="form-check">
                    <input class="form-check-input" id='inactive' type="checkbox" value="1" <?= isset($_SESSION['inactive']) ? 'checked' : '' ?>>
                    <?php
                    if (isset($_SESSION['inactive'])) {
                        echo '<a href="' . site_url('admin/users/same_password/?inactive=0') . '" class="form-check-label" for="inactive">Show inactive users</a>';
                    } else {
                        echo '<a href="' . site_url('admin/users/same_password/?inactive=1') . '" class="form-check-label" for="inactive">Hide inactive users</a>';
                    }
                    ?>
                </div>
                <div class="form-check">
                    <input class="form-check-input" id='inactive' type="checkbox" value="1" <?= isset($_SESSION['banned']) ? 'checked' : '' ?>>
                    <?php
                    if (isset($_SESSION['banned'])) {
                        echo '<a href="' . site_url('admin/users/same_password/?banned=0') . '" class="form-check-label" for="inactive">Show banned users</a>';
                    } else {
                        echo '<a href="' . site_url('admin/users/same_password/?banned=1') . '" class="form-check-label" for="inactive">Hide banned users Hide inactive users (inactive in the last 14 days)</a>';
                    }
                    ?>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center">
                        <thead>
                            <tr>
                                <th scope="col"><?= $fraudContent ?></th>
                                <th scope="col">ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">IP Address</th>
                                <th scope="col">Country</th>
                                <th scope="col">Referred By</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $indx = 0;
                            foreach ($users as $fraudContent => $users) {
                                foreach ($users as $ind => $user) {
                                    $country = ($user['isocode'] != 'N/A') ? '<img src="' . base_url("assets/images/flags/" . $user['isocode'] . ".png") . '" title="' . $user['country'] . '"/>' : 'N/A';
                                    if ($ind == 0) {
                                        echo '<tr>
                                        <th class="align-middle" rowspan="' . count($users) . '" scope="row" style="border: 3px solid black;">' . $fraudContent . '</th>
                                        <td><a target="_blank" href="' . site_url('admin/users/details/' . $user['id']) . '">' . $user['id'] . '</a></td>
                                        <td><a target="_blank" href="' . site_url('admin/users/details/' . $user['id']) . '">' . $user['username'] . '</a></td>
                                        <td><a target="_blank" href="' . site_url('admin/users/find_ip/' . $user['ip_address']) . '">' . $user['ip_address'] . ' <i class="fas fa-search"></i></a></td>
                                        <td>' . $country . '</td>
                                        <td><a target="_blank" href="' . site_url('admin/users/details/' . $user["referred_by"]) . '">' . $user['referred_by'] . '</a></td>
                                        <td><a target="_blank" href="' . site_url("/admin/users/details/" . $user['id']) . '" class="btn btn-secondary btn-sm" title="Detail"><i class="fas fa-user-cog"></i></a><a target="_blank" href="' . site_url("/admin/users/ban/" . $user['id']) . '" class="btn btn-success btn-sm" title="Unban"><i class="fas fa-ban"></i></a><a target="_blank" href="' . site_url("/admin/users/unban/" . $user['id']) . '" class="btn btn-danger btn-sm" title="Ban"><i class="fas fa-ban"></i></a></td>
                                        </tr>';
                                    } else {
                                        echo '<tr>
                                        <td><a target="_blank" href="' . site_url('admin/users/details/' . $user['id']) . '">' . $user['id'] . '</a></td>
                                        <td><a target="_blank" href="' . site_url('admin/users/details/' . $user['id']) . '">' . $user['username'] . '</a></td>
                                        <td><a target="_blank" href="' . site_url('admin/users/find_ip/' . $user['ip_address']) . '">' . $user['ip_address'] . ' <i class="fas fa-search"></i></a></td>
                                        <td>' . $country . '</td>
                                        <td><a target="_blank" href="' . site_url('admin/users/details/' . $user["referred_by"]) . '">' . $user['referred_by'] . '</a></td>
                                        <td><a target="_blank" href="' . site_url("/admin/users/details/" . $user['id']) . '" class="btn btn-secondary btn-sm" title="Detail"><i class="fas fa-user-cog"></i></a><a target="_blank" href="' . site_url("/admin/users/ban/" . $user['id']) . '" class="btn btn-success btn-sm" title="Unban"><i class="fas fa-ban"></i></a><a target="_blank" href="' . site_url("/admin/users/unban/" . $user['id']) . '" class="btn btn-danger btn-sm" title="Ban"><i class="fas fa-ban"></i></a></td>
                                        </tr>';
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?= $pagination ?>
            </div>
        </div>
        </div.>
    </div>