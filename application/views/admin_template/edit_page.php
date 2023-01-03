<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 text-center">Edit page</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/pages/update') ?>" method="POST">
                    <input type="hidden" name="id" value="<?= $this_page['id'] ?>">
                    <div class="form-group">
                        <label>Page Title (HTML)</label>
                        <textarea class="form-control" rows="3" name="title"><?= $this_page['title'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Slug</label>
                        <input type="text" class="form-control" name="slug" value="<?= $this_page['slug'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Priority</label>
                        <input type="number" class="form-control" name="priority" value="<?= $this_page['priority'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Page Content (HTML)</label>
                        <textarea class="form-control summernote" rows="15" name="content"><?= str_replace('&', '&amp;', $this_page['content']) ?></textarea>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                    <button class="btn btn-success btn-block">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>