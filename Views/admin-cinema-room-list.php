	<main>
        <h2 class="dash-title">Cinemas rooms</h2>
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
			<?php if($cinemaId != null): ?>			
			<a href="<?= FRONT_ROOT ?>cinemaRoom/forceDisable/<?= $cinemaId ?>">
				<i class="icon ion-md-warning"></i>
				Force Disable
			</a>
			<?php endif; ?>			
		</div>
		<?php endif; ?>

		<a href="<?= FRONT_ROOT ?>cinemaRoom/listCinemaRoomPath/all" class="btn-view-all">
			<i class="icon ion-md-clipboard"></i>
			List all cinemas rooms (Including the disabled)
		</a>
        <div class="dashboard-container">
            <div class="content-container">				
				<table border="1" id="myTable">
					<div class="filter-container">
						<div class="filter-search">		
							<i class="icon ion-md-search"></i>
							<input class="filter-input" type="text" class="filter" id="myInput" placeholder="Search for cinemas..">
						</div>
					</div>
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
								<td>$<?= $cinemaRoom->getPrice(); ?></td>	
								<td><?= $cinemaRoom->getCapacity(); ?></td>								
								<td>
									<div class="actions-container">
										<?php if ($cinemaRoom->getIsActive()): ?>
										<a href="<?php echo FRONT_ROOT . "cinemaRoom/disable/" . $cinemaRoom->getId(); ?>" class="btn btn-disable">
											<i class="icon ion-md-trash"></i>
											Disable
										</a>			
										<?php else: ?>
										<a href="<?php echo FRONT_ROOT . "cinemaRoom/enable/" . $cinemaRoom->getId(); ?>" class="btn btn-enable">
											<i class="icon ion-md-done-all"></i>
											Enable
										</a>		
										<?php endif; ?>							
										<a href="<?php echo FRONT_ROOT . "cinemaRoom/modifyById/" . $cinemaRoom->getId(); ?>" class="btn">
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
	<script>

		let outerInput = document.getElementById('myInput');

		outerInput.addEventListener('keyup', function() {
			let innerInput, filter, table, tr, td, i, txtValue;
			innerInput = document.getElementById('myInput');
			filter = innerInput.value.toUpperCase();
			table = document.getElementById('myTable');
			tr = table.getElementsByTagName('tr');
			
			for (i = 0; i < tr.length; i++) {
				td = tr[i].getElementsByTagName("td")[1];
				if (td) {
					txtValue = td.textContent || td.innerText;
					if (txtValue.toUpperCase().indexOf(filter) > -1) {
						tr[i].style.display = '';
					} else {
						tr[i].style.display = 'none';
					}
				}
			}
		});

	</script>
</body>

</html>
