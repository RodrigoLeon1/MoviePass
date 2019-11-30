<main>
        <h2 class="dash-title">Users</h2>
        <hr>

        <?php if($success != null): ?>
        <div class="alert-container success-container">
            <i class="icon ion-md-checkmark"></i>
            <h3><?= $success; ?></h3>
        </div>
        <?php endif; ?>        

        <?php if($alert != null): ?>
        <div class="alert-container error-container">
            <i class="icon ion-md-close-circle-outline"></i>
            <h3><?= $alert; ?></h3>
        </div>
        <?php endif; ?>

        <div class="dashboard-container">

            <div class="content-container">				
				<table border="1">
					<thead>
						<tr>
							<th>FirstName</th>
							<th>LastName</th>
							<th>DNI</th>
							<th>Mail</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($users as $user): ?>
							<tr>					
								<td><?= $user->getFirstName(); ?></td>
								<td><?= $user->getLastName(); ?></td>
								<td><?= $user->getDni(); ?></td>
								<td><?= $user->getMail(); ?></td>
								<td>
									<div class="actions-container">
										<?php if ($user->getIsActive()): ?>
										<a href="<?php echo FRONT_ROOT . "user/disable/" . $user->getDni(); ?>" class="btn btn-disable">
											<i class="icon ion-md-trash"></i>
											Disable
										</a>							
										<?php else: ?>
										<a href="<?php echo FRONT_ROOT . "user/enable/" . $user->getDni(); ?>" class="btn btn-enable">
											<i class="icon ion-md-done-all"></i>
											Enable
										</a>
										<?php endif; ?>			
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
