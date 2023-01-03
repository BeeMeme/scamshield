<div class="ads">
    <?= $settings['ptc_top_ad'] ?>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Manage your campaigns</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                } ?>
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Url</th>
                                <th scope="col">Price</th>
                                <th scope="col">Timer</th>
                                <th scope="col">Views</th>
                                <th scope="col">Total View</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($ads as $ad) {
                                echo '
                            <tr>
                            <td scope="row">' . $ad["name"] . '</td>
                            <td>' . $ad["description"] . '</td>
                            <td>' . $ad["url"] . '</td>
                            <td>' . $ad["price"] . '</td>
                            <td>' . $ad["timer"] . '</td>
                            <td>' . $ad["views"] . '</td>
                            <td>' . $ad["total_view"] . '</td>
                            <td>' . $ad["status"] . '</td>
                            <td><a class="btn btn-success btn-sm" href="' . site_url("advertise/start/" . $ad['id']) . '">Start</a>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-' . $ad['id'] . ' ">Add view</button>
<a class="btn btn-warning btn-sm" href="' . site_url("advertise/pause/" . $ad['id']) . '">Pause</a><a class="btn btn-danger btn-sm" href="' . site_url("advertise/delete/" . $ad['id']) . '">Delete</a></td>
                            </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
foreach ($ads as $ad) { ?>

    <div class="modal fade" id="add-<?= $ad['id'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add view to campaign #<?= $ad['id'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= site_url('advertise/add_view/'.$ad['id']) ?>" method="POST" autocomplete="off">
                        <div class="form-group row mb-4">
                            <input type="hidden" name="<?= $csrf_name ?>" id="token" value="<?= $csrf_hash ?>">
                            <label class="col-sm-3 col-form-label">View</label>
                            <div class="col-sm-9">
                                <input type="number" min="0" max="<?=floor($user['dep_balance']/$ad['price'])?>" class="form-control mb-4" id="view" name="view" required="">
                            </div>
                        </div>

                        <div class="form-group row justify-content-end">
                            <div class="col-sm-9">
                                <div>
                                    <button type="submit" class="btn btn-primary w-md">Add view</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>