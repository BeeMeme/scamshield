<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4"><?= $page ?></h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <div class="alert alert-info text-center">Click on ip address to check it with Ipqualityscore!</div>
                <div class="table-responsive">
                    <table class="table table-striped" style="font-size: 10px;">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Username</th>
                                <th scope="col">Ip Address</th>
                                <th scope="col">Offerwall</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Claim time</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 10px;">
                            <?php foreach ($records as $record) { ?>
                                <tr>
                                    <th scope="row"><?= $record['id'] ?></th>
                                    <td><a target="_blank" href="<?= site_url("/admin/users/details/" . $record['user_id']) ?>"><?= $record['username'] ?> <?= ($record['isocode'] != 'N/A') ? '<img src="' . base_url() . 'assets/images/flags/' . $record['isocode'] . '.png" title="' . $record['country'] . '">' : '' ?></td>
                                    <td><a target="_blank" href="https://www.ipqualityscore.com/free-ip-lookup-proxy-vpn-test/lookup/<?= $record['ip_address'] ?>"><?= $record['ip_address'] ?> <i class="fas fa-search"></i></a></td>
                                    <td><?= ucfirst($record['offerwall']) ?></td>
                                    <td><?= format_money($record['amount']) ?></td>
                                    <td><?= timespan($record["claim_time"], time(), 2) ?> ago</td>
                                    <td><a class="btn btn-success btn-sm" href="<?= site_url('admin/offerwalls/accept/' . $record['id']) ?>">Accept</a> | <a class="btn btn-success btn-sm" href="<?= site_url('admin/offerwalls/accept_by_ip/' . $record['id']) ?>">Accept by ip</a> | <a class="bn btn-danger btn-sm" href="<?= site_url('admin/offerwalls/deny_by_ip/' . $record['id']) ?>">Deny by ip</a> | <a class="bn btn-danger btn-sm" href="<?= site_url('admin/offerwalls/deny/' . $record['id']) ?>">Deny</a> </td>
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