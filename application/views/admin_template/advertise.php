<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 text-center">Create a campaign</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                } ?>

                <form action="<?= site_url('admin/advertise/create') ?>" method="POST">

                    <label>Name</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-icon-img" name="name" minlength="1" maxlength="75" autocomplete="off" required>
                    </div>

                    <label>Description</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-comment-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control form-control-icon-img" name="description" minlength="1" maxlength="75" autocomplete="off" required>
                    </div>

                    <label>Url</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-link"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control form-control-icon-img" name="url" autocomplete="off" required>
                    </div>

                    <label>View</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <input type="number" class="form-control form-control-icon-img" name="view" min="1" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label for="option">Duration</label>
                        <select class="form-control" id="option" name="option">
                            <?php foreach ($options as $option) { ?>
                                <option value="<?= $option['id'] ?>"><?= $option['timer'] ?> seconds (<?= $option['price'] ?> USD/view, minimum <?= $option['min_view'] ?> views)</option>
                            <?php } ?>
                        </select>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" id="token" value="<?= $csrf_hash ?>">
                    <button type="submit" class="btn btn-success btn-block">Create Campaign</button>
                </form>
            </div>
        </div>
    </div>
</div>