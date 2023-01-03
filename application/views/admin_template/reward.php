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
                <form action="<?= site_url('admin/reward/add') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">User Id</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="userId" placeholder="User Id" min="1" required>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Add To Balance</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" step="0.000001" class="form-control" name="balanceAmount" placeholder="Amount will be added to user balance" required>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Add To Deposit Balance</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" step="0.000001" class="form-control" name="depBalanceAmount" placeholder="Amount will be added to user deposit balance" required>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Add To Energy</label>
                        <div class="col-sm-9">
                            <input type="number" min='0' class="form-control" name="energyAmount" placeholder="Amount will be added to user energy" required>
                        </div>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Reward</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>