<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body text-center">
				<h4 class="card-title mb-4">Pending withrawals</h4>
				<?php
				if (isset($_SESSION['message'])) {
					echo $_SESSION['message'];
				}
				?>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th scope="col">Username</th>
								<th scope="col">Status</th>
								<th scope="col">Method</th>
								<th scope="col">Ip Address</th>
								<th scope="col">Amount</th>
								<th scope="col">Wallet</th>
								<th scope="col">Date</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($pendingWithdrawal as $value) { ?>
								<tr>
									<th scope="row"><a target="_blank" href="<?= site_url('/admin/users/details/' . $value['user_id']) ?>"><?= $value['username'] ?></a></th>
									<td><?= $value['user_status'] ?></td>
									<td><?= $value['name'] ?></td>
									<td><?= $value['ip_address'] ?></td>
									<td><?= $value['amount'] ?></td>
									<td><?= $value['wallet'] ?></td>
									<td><?= timespan($value['claim_time'], time(), 2) ?> ago</td>
									<td><a href="<?= site_url("/admin/withdraw/accept/" . $value['id']) ?>" class="btn btn-success" style="margin-right: 10px;">Accept</a><a href="<?= site_url("/admin/withdraw/deny/" . $value['id']) ?>" class="btn btn-danger">Deny</a></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>