<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4"><?= $page ?></h4>
                <div class="alert alert-warning text-center">This doesn't mean they are cheater. Compare the username, referral carefully before ban any users.</div>
                <form action="#" id="submit-form" method="POST">
                    <button type="submit" class="btn btn-danger suspect-button" submitto="<?= site_url('/admin/users/mass_ban') ?>">Ban selected</button>
                    <button type="submit" class="btn btn-success suspect-button" submitto="<?= site_url('/admin/users/mass_release') ?>">Release selected</button>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">
                    <input type="hidden" name="from" value="<?= current_url() . '/?' . $_SERVER['QUERY_STRING'] ?>">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col"><?= $fraudContent ?></th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">IP Address</th>
                                    <th scope="col">Balance</th>
                                    <th scope="col">Password</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">Referred By</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $indx = 0;
                                foreach ($users as $fraudContent => $users) {
                                    $passArr = [];
                                    $refArr = [];
                                    $idArr = [];
                                    foreach ($users as $user) {
                                        if (isset($passArr[$user['password']])) {
                                            $passArr[$user['password']]++;
                                        } else {
                                            $passArr[$user['password']] = 1;
                                        }
                                        array_push($idArr, $user['id']);
                                        if ($user['referred_by'] != 0) {
                                            array_push($refArr, $user['referred_by']);
                                        }
                                    }
                                    foreach ($users as $ind => $user) {
                                        if ($user['status'] == 'banned') {
                                            $user['username'] = '<del title="banned" style="color: gray;">' . $user['username'] . '</del>';
                                        }
                                        if (in_array($user['referred_by'], $idArr)) {
                                            $user['referred_by_display'] = '<span style="font-weight: bold; color: ' . getRandomColor($user['referred_by'], 0, true) . ';">' . $user['referred_by'] . '</span>';
                                        } else {
                                            $user['referred_by_display'] = $user['referred_by'];
                                        }
                                        if (in_array($user['id'], $refArr)) {
                                            $user['id_display'] = '<span style="font-weight: bold; color: ' . getRandomColor($user['id'], 0, true) . ';">' . $user['id'] . '</span>';
                                        } else {
                                            $user['id_display'] = $user['id'];
                                        }
                                        if ($passArr[$user['password']] > 1) {
                                            $user['password'] = '<span style="font-weight: bold; color: ' . getRandomColor(crc32($user['password']), 0, true) . ';">' . $user['password'] . '</span>';
                                        }
                                        $country = ($user['isocode'] != 'N/A') ? '<img src="' . base_url("assets/images/flags/" . $user['isocode'] . ".png") . '" title="' . $user['country'] . '"/>' : 'N/A';
                                        $border = '';
                                        if ($ind == count($users) - 1) {
                                            $border = 'style="border-bottom: 2px solid black"';
                                        }
                                        if ($ind == 0) {
                                            echo '<tr ' . $border . '>
                                        <th class="align-middle" rowspan="' . count($users) . '" scope="row" style="border: 2px solid black;">' . $fraudContent . '
                                        <button class="btn btn-sm btn-warning fraudcontent" type="button" fraudcontent="' . $indx . '">Select all</button></th>
                                        <td><div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input check-' . $indx . '" name="userId[]" value="' . $user['id'] . '">
                                        <label class="form-check-label"><a target="_blank" href="' . site_url('admin/users/details/' . $user['id']) . '">' . $user['id_display'] . '</a></label>
                                      </div>
                                        </td>
                                        <td><a target="_blank" href="' . site_url('admin/users/details/' . $user['id']) . '">' . $user['username'] . '</a></td>
                                        <td><a target="_blank" href="' . site_url('admin/users/find_ip/' . $user['ip_address']) . '">' . $user['ip_address'] . ' <i class="fas fa-search"></i></a></td>
                                        <td>' . $user['balance'] . '</td>
                                        <td>' . $user['password'] . '</td>
                                        <td>' . $country . '</td>
                                        <td><a target="_blank" href="' . site_url('admin/users/details/' . $user["referred_by"]) . '">' . $user['referred_by_display'] . '</a></td>
                                        <td><a target="_blank" href="' . site_url("/admin/users/details/" . $user['id']) . '" class="btn btn-secondary btn-sm" title="Detail"><i class="fas fa-user-cog"></i></a><a target="_blank" href="' . site_url("/admin/users/ban/" . $user['id']) . '" class="btn btn-success btn-sm" title="Unban"><i class="fas fa-ban"></i></a><a target="_blank" href="' . site_url("/admin/users/unban/" . $user['id']) . '" class="btn btn-danger btn-sm" title="Ban"><i class="fas fa-ban"></i></a></td>
                                        </tr>';
                                        } else {
                                            echo '<tr ' . $border . '>
                                            <td><div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input check-' . $indx . '" name="userId[]" value="' . $user['id'] . '">
                                            <label class="form-check-label"><a target="_blank" href="' . site_url('admin/users/details/' . $user['id']) . '">' . $user['id_display'] . '</a></label>
                                          </div>
                                            </td>
                                        <td><a target="_blank" href="' . site_url('admin/users/details/' . $user['id']) . '">' . $user['username'] . '</a></td>
                                        <td><a target="_blank" href="' . site_url('admin/users/find_ip/' . $user['ip_address']) . '">' . $user['ip_address'] . ' <i class="fas fa-search"></i></a></td>
                                        <td>' . $user['balance'] . '</td>
                                        <td>' . $user['password'] . '</td>
                                        <td>' . $country . '</td>
                                        <td><a target="_blank" href="' . site_url('admin/users/details/' . $user["referred_by"]) . '">' . $user['referred_by_display'] . '</a></td>
                                        <td><a target="_blank" href="' . site_url("/admin/users/details/" . $user['id']) . '" class="btn btn-secondary btn-sm" title="Detail"><i class="fas fa-user-cog"></i></a><a target="_blank" href="' . site_url("/admin/users/ban/" . $user['id']) . '" class="btn btn-success btn-sm" title="Unban"><i class="fas fa-ban"></i></a><a target="_blank" href="' . site_url("/admin/users/unban/" . $user['id']) . '" class="btn btn-danger btn-sm" title="Ban"><i class="fas fa-ban"></i></a></td>
                                        </tr>';
                                        }
                                    }
                                    ++$indx;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </form>
                <?= $pagination ?>
            </div>
        </div>
        </div.>
    </div>