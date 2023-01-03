<div class="ads">
    <?= $settings['dashboard_top_ad'] ?>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">History</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                } ?>

                <ul class="nav nav-tabs mb-3 mt-3 justify-content-center" id="iconTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tasks-tab" data-toggle="tab" href="#tasks" role="tab" aria-controls="tasks" aria-selected="true">
                            <i class="fas fa-tasks"></i>
                            Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="lottery-tab" data-toggle="tab" href="#lottery" role="tab" aria-controls="lottery" aria-selected="false">
                            <i class="fas fa-ticket-alt"></i>
                            Lottery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="offerwall-tab" data-toggle="tab" href="#offerwall" role="tab" aria-controls="offerwall" aria-selected="false">
                            <i class="far fa-newspaper"></i>
                            Offerwalls</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="withdrawals-tab" data-toggle="tab" href="#withdrawals" role="tab" aria-controls="withdrawals" aria-selected="false">
                            <i class="fas fa-download"></i>
                            Withdrawals</a>
                    </li>
                </ul>
                <div class="tab-content" id="iconTabContent-1">
                    <div class="tab-pane fade active show" id="tasks" role="tabpanel" aria-labelledby="tasks-tab">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Task</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($task_history as $value) {
                                        echo '<tr><th scope="row">' . $value["id"] . '</th><td>' . $value['name'] . '</td><td>' . currency($value["usd_reward"], $settings['currency_rate']) . '</td><td>' . timespan($value["claim_time"], time(), 2) . ' ago</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="lottery" role="tabpanel" aria-labelledby="lottery-tab">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($lottery_history as $value) {
                                        echo '<tr><th scope="row">' . $value["id"] . '</th><td>' . format_money($value["amount"]) . '</td><td>' . timespan($value["create_time"], time(), 2) . ' ago</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="offerwall" role="tabpanel" aria-labelledby="offerwall-tab">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Offerwall</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Complete on</th>
                                        <th scope="col">Release in</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($offerwall_history as $value) {
                                        $release =  timespan(time(), $value["available_at"], 2);
                                        if ($release == '1 Second') {
                                            $release = '<span class="badge badge-success">Released</span>';
                                        }
                                        switch ($value['status']) {
                                            case 0:
                                                $value['status'] = '<span class="badge badge-pill badge-info">Pending</span>';
                                                break;
                                            case 1:
                                                $value['status'] = '<span class="badge badge-pill badge-danger">Cancelled</span>';
                                                break;
                                            case 2:
                                                $value['status'] = '<span class="badge badge-pill badge-success">Approved</span>';
                                                break;
                                        }
                                        echo '<tr><th scope="row">' . $value["id"] . '</th><td>' . ucfirst($value["offerwall"]) . '</td><td>' . format_money($value["amount"]) . '</td><td>' . $value["status"] . '</td><td>' . timespan($value["claim_time"], time(), 2) . ' ago</td><td>' . $release . '</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="withdrawals" role="tabpanel" aria-labelledby="withdrawals-tab">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($withdrawals_history as $value) {
                                        switch ($value['type']) {
                                            case 0:
                                                $value['type'] = '<span class="badge badge-pill badge-info">Pending</span>';
                                                break;
                                            case 1:
                                                $value['type'] = '<span class="badge badge-pill badge-success">Approved</span>';
                                                break;
                                            case 2:
                                                $value['type'] = '<span class="badge badge-pill badge-danger">Denied</span>';
                                                break;
                                        }
                                        echo '<tr><th scope="row">' . $value["id"] . '</th><td>' . $value["type"] . '</td><td>' . format_money($value["amount"]) . '</td><td>' . timespan($value["claim_time"], time(), 2) . ' ago</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>