	<main>
        <h2 class="dash-title">Cinemas rooms</h2>
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
			
			<?php if($cinemaId != NULL): ?>			
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
                            <th>Cinema</th>
							<th>Name</th>							
                            <th>Price</th>		
                            <th>Capacity</th>					
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($cinemasRooms as $cinemaRoom): ?>
							<tr>
                                <td><?= $cinemaRoom->getId(); ?></td>
                                <td><?= $cinemaRoom->getCinema()->getName(); ?></td>
								<td><?= $cinemaRoom->getName(); ?></td>								
								<td><?= $cinemaRoom->getPrice(); ?></td>	
								<td><?= $cinemaRoom->getCapacity(); ?></td>								
								<td>
									<div class="actions-container">
										<a href="<?php echo FRONT_ROOT . "cinemaRoom/remove/" . $cinemaRoom->getId(); ?>" class="btn btn-delete">
											<i class="icon ion-md-trash"></i>
											Remove
										</a>										
										<!-- <a href="<?php echo FRONT_ROOT . "" . $cinemaRoom->getId(); ?>" class="btn">
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
