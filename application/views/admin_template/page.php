<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 text-center">Pages</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Title</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pages as $p) {
                                echo '<tr><th scope="row">' . $p['id'] . '</th><td>' . $p['title'] . '</td><td>' . $p['slug'] . '</td><td>' . $p['priority'] . '</td><td><a class="btn btn-warning btn-sm" href="' . site_url("admin/pages/edit/" . $p['id']) . '">Edit</a><a class="btn btn-danger btn-sm" href="' . site_url("admin/pages/delete/" . $p['id']) . '">Delete</a></td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <hr>
                <form action="<?= site_url('admin/pages/add') ?>" method="POST">
                    <div class="form-group">
                        <label>Page Title (HTML)</label>
                        <textarea class="form-control" rows="3" name="title"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Slug (0-9, a-z, A-Z and - only)</label>
                        <input type="text" class="form-control" name="slug" placeholder="Url for this page, for example: hello-there" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Priority</label>
                        <input type="number" class="form-control" name="priority" placeholder="Priority to show in menu, 0 will not be shown" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label>Page Content (HTML)</label>
                        <textarea class="form-control summernote" rows="15" name="content"></textarea>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                    <button class="btn btn-success btn-block">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>