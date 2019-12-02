<main>
	<h2 class="dash-title">Shows</h2>
	<hr>

	<?php if($success != null): ?>
	<div class="alert-container success-container">
		<i class="icon ion-md-checkmark"></i>
		<h3><?= $success; ?></h3>
	</div>
	<?php endif; ?>

	<div class="dashboard-container">

		<div class="content-container">
			<table border="1" id="myTable">
				<div class="filter-container">
					<div class="filter-search">						
						<i class="icon ion-md-search"></i>
						<input class="filter-input" type="text" class="filter" id="myInput" placeholder="Search for cinemas..">
					</div>
					<div class="filter-options">						
						<p>Filter by:</p>
						<input type="radio" name="filter" id="input-cinema" value="cinema" checked> Cinema
						<input type="radio" name="filter" id="input-movie" value="movie"> Movie						
						<input type="radio" name="filter" id="input-date" value="date"> Date	
					</div>
				</div>
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
							<td><?= $show->getCinemaRoom()->getCinema()->getName(); ?></td>
							<td><?= $show->getCinemaRoom()->getName(); ?></td>
							<td><?= $show->getMovie()->getTitle(); ?></td>
							<td><?= $show->getDateStart(); ?></td>
							<td><?= $show->getTimeStart(); ?></td>
							<td>
								<div class="actions-container">
									<?php if ($show->getIsActive()): ?>
									<a href="<?php echo FRONT_ROOT . "show/disable/" . $show->getId(); ?>" class="btn btn-disable">
										<i class="icon ion-md-trash"></i>
										Disable
									</a>
									<?php else: ?>
									<a href="<?php echo FRONT_ROOT . "show/enable/" . $show->getId(); ?>" class="btn btn-enable">
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

<script>
	let outerInput = document.getElementById('myInput');
	let inputCinema = document.getElementById('input-cinema');
	let inputMovie = document.getElementById('input-movie');
	let inputDate = document.getElementById('input-date');
	
	inputCinema.addEventListener('click', () => {
		outerInput.placeholder = `Search for cinemas..`;	
	});

	inputMovie.addEventListener('click', () => {
		outerInput.placeholder = `Search for movies..`;			
	});

	inputDate.addEventListener('click', () => {
		outerInput.placeholder = `Search for date (Y-m-d)..`;			
	});

	outerInput.addEventListener('keyup', function() {
		let innerInput, filter, table, tr, td, i, txtValue;
		innerInput = document.getElementById('myInput');
		filter = innerInput.value.toUpperCase();
		table = document.getElementById('myTable');
		tr = table.getElementsByTagName('tr');
		
		for (i = 0; i < tr.length; i++) {
			if (innerInput.placeholder.includes('cinemas')) {
				td = tr[i].getElementsByTagName('td')[1];
			} else if (innerInput.placeholder.includes('movies')) {
				td = tr[i].getElementsByTagName('td')[3];
			} else {
				td = tr[i].getElementsByTagName('td')[4];
			}
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
