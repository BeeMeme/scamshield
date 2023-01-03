<div class="ads">
    <?= $settings['tasks_top_ad'] ?>
</div>
<?php
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
}
?>
<div class="alert alert-warning text-center">FAKE PROOFS WILL LEAD TO IMMEDIATE SUSPENSION OF YOUR ACCOUNT!</div>
<div class="row">
    <?php foreach ($availableTasks as $task) { ?>
        <div class="col-md-6" style="margin-bottom: 5px;">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $task['name'] ?></h5>
                    <p class="card-text"><?= $task['description'] ?></p>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <span><i class="fas fa-gift"></i>: <?= currency($task['usd_reward'], $settings['currency_rate']) ?></span>
                        </div>
                        <div class="col-md-4">
                            <span><i class="fas fa-bolt"></i>: <?= $task['energy_reward'] ?> energy</span>
                        </div>
                        <div class="col-md-4">
                            <span><i class="fas fa-level-up-alt"></i>: <?= $task['exp_reward'] ?> exp</span>
                        </div>
                    </div>

                    <form action="<?= site_url('tasks/complete/' . $task['id']) ?>" method="post" autocomplete="off">
                        <div class="form-group">
                            <label>Proof</label>
                            <input type="text" name="proof" class="form-control" placeholder="<?= $task['requirement'] ?>" minlength="1" maxlength="100" required>
                        </div>
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                        <button type="submit" class="btn btn-primary btn-block">Submit your proof</button>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php foreach ($pendingTasks as $task) { ?>
        <div class="col-md-6" style="margin-bottom: 5px;">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $task['name'] ?></h5>
                    <p class="card-text"><?= $task['description'] ?></p>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <span><i class="fas fa-gift"></i>: <?= currency($task['usd_reward'], $settings['currency_rate']) ?></span>
                        </div>
                        <div class="col-md-4">
                            <span><i class="fas fa-bolt"></i>: <?= $task['energy_reward'] ?> energy</span>
                        </div>
                        <div class="col-md-4">
                            <span><i class="fas fa-level-up-alt"></i>: <?= $task['exp_reward'] ?> exp</span>
                        </div>
                    </div>

                    <form action="<?= site_url('tasks/complete/' . $task['id']) ?>" method="post" autocomplete="off">
                        <div class="form-group">
                            <label>Proof</label>
                            <input type="text" name="proof" class="form-control" value="<?= $task['proof'] ?>" disabled>
                        </div>
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                        <button type="submit" class="btn btn-primary btn-block" disabled>Submitted</button>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<div class="ads">
    <?= $settings['tasks_footer_ad'] ?>
</div>