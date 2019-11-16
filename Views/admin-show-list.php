    <main>
        <h2 class="dash-title">Shows</h2>
        <hr>

        <?php if($success != NULL): ?>
        <div class="alert-container success-container">
            <i class="icon ion-md-checkmark"></i>
            <h3><?= $success ?></h3>
        </div>
        <?php endif; ?>

        <div class="dashboard-container">

			<div class="content-container">
				<table border="1">
					<thead>
						<tr>
							<th>Id</th>
							<th>Cinema</th>
							<th>Room</th>
							<th>Movie</th>
							<th>Date</th>
							<th>Hour</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($shows as $show): ?>
							<tr>
								<td><?= $show->getId(); ?></td>
								<td><?= $show->getCinemaRoom()->getCinema()->getName() ?></td>
								<td><?= $show->getCinemaRoom()->getName(); ?></td>
								<td><?= $show->getMovie()->getTitle(); ?></td>
								<td><?= $show->getDateStart(); ?></td>
								<td><?= $show->getTimeStart(); ?></td>
								<td>
									<div class="actions-container">
										<a href="<?php echo FRONT_ROOT . "show/remove/" . $show->getId(); ?>" class="btn btn-delete">
											<i class="icon ion-md-trash"></i>
											Remove
										</a>
										<!-- <a href="<?php echo FRONT_ROOT . "show/getById/" . $show->getId(); ?>" class="btn">
											<i class="icon ion-md-build"></i>
											Modify
										</a> -->
									</div>
								</td>

							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

        </div>
    </main>

</body>

</html>
