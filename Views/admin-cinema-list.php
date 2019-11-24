    <main>
        <h2 class="dash-title">Cinemas</h2>
        <hr>

        <?php if($success != null): ?>
        <div class="alert-container success-container">
            <i class="icon ion-md-checkmark"></i>
            <h3><?= $success ?></h3>
        </div>
        <?php endif; ?>    

		<?php if($alert != null): ?>
		<div class="alert-container error-container">
			<i class="icon ion-md-close-circle-outline"></i>
			<h3><?= $alert ?></h3>
			
			<?php if($cinemaId != null): ?>			
			<a href="<?= FRONT_ROOT ?>cinema/forceDelete/<?= $cinemaId ?>">
				<i class="icon ion-md-warning"></i>
				Force Delete
			</a>
			<?php endif; ?>			

		</div>
		<?php endif; ?>

        <div class="dashboard-container">

            <div class="content-container">				
				<table border="1">
					<thead>
						<tr>
							<th>Id</th>
							<th>Name</th>							
							<th>Address</th>							
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($cinemas as $cinema): ?>
							<tr>
								<td><?= $cinema->getId(); ?></td>
								<td><?= $cinema->getName(); ?></td>								
								<td><?= $cinema->getAddress(); ?></td>								
								<td>
									<div class="actions-container">
										<a href="<?php echo FRONT_ROOT . "cinema/remove/" . $cinema->getId(); ?>" class="btn btn-delete">
											<i class="icon ion-md-trash"></i>
											Remove
										</a>										
										<a href="<?php echo FRONT_ROOT . "cinema/modifyById/" . $cinema->getId(); ?>" class="btn">
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
