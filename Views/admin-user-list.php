<main>
        <h2 class="dash-title">Users</h2>
        <hr>

        <?php if($success != NULL): ?>
        <div class="alert-container success-container">
            <i class="icon ion-md-checkmark"></i>
            <h3><?= $success ?></h3>
        </div>
        <?php endif; ?>        

        <?php if($alert != NULL): ?>
        <div class="alert-container error-container">
            <i class="icon ion-md-close-circle-outline"></i>
            <h3><?= $alert ?></h3>
        </div>
        <?php endif; ?>

        <div class="dashboard-container">

            <div class="content-container">				
				<table border="1">
					<thead>
						<tr>
							<th>Id</th>
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
								<td></td>				
								<td><?= $user->getFirstName(); ?></td>
								<td><?= $user->getLastName(); ?></td>
								<td><?= $user->getDni(); ?></td>
								<td><?= $user->getMail(); ?></td>
								<td>
									<div class="actions-container">
										<a href="<?php echo FRONT_ROOT . "user/remove/" . $user->getId(); ?>" class="btn btn-delete">
											<i class="icon ion-md-trash"></i>
											Remove
										</a>										
										<a href="<?php echo FRONT_ROOT . "user/" . $user->getId(); ?>" class="btn">
											<i class="icon ion-md-build"></i>
											Modify
										</a>
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
