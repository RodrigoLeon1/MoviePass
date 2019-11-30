<main>
	<h2 class="dash-title">Movies</h2>
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
		
		<?php if($movieId != null): ?>			
		<a href="<?= FRONT_ROOT ?>movie/forceDelete/<?= $movieId ?>">
			<i class="icon ion-md-warning"></i>
			Force Delete
		</a>
		<?php endif; ?>			

	</div>
	<?php endif; ?>
	
	<div class="dashboard-container">

		<div class="content-container">
			<table border="1" id="myTable">
				<div class="filter-container">
					<i class="icon ion-md-search"></i>
					<input class="filter-input" type="text" class="filter" id="myInput" onkeyup="myFunction()" placeholder="Search for movies..">
				</div>
				<thead>
					<tr>
						<th>Poster</th>
						<th>Id</th>
						<th>Title</th>
						<th>Vote average</th>
						<th>Runtime</th>
						<th>Release date</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($movies as $movie): ?>							
						<tr>
							<td>
								<img src="<?= IMG_PATH_TMDB . $movie->getPosterPath() ?>" alt="">
							</td>
							<td><?= $movie->getId(); ?></td>
							<td><?= $movie->getTitle(); ?></td>
							<td><?= $movie->getVoteAverage(); ?></td>
							<td><?= $this->minToHour($movie->getRuntime()); ?></td>
							<td><?= $movie->getReleaseDate(); ?></td>								
							<td>
								<div class="actions-container">
									<?php if ($movie->getIsActive()): ?>
									<a href="<?php echo FRONT_ROOT . "movie/disable/" . $movie->getId(); ?>" class="btn btn-disable">
										<i class="icon ion-md-trash"></i>
										Disable
									</a>			
									<?php else: ?>
									<a href="<?php echo FRONT_ROOT . "movie/enable/" . $movie->getId(); ?>" class="btn btn-enable">
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
	function myFunction() {
	// Declare variables
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("myInput");
	filter = input.value.toUpperCase();
	table = document.getElementById("myTable");
	tr = table.getElementsByTagName("tr");

	// Loop through all table rows, and hide those who don't match the search query
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[2];
		if (td) {
		txtValue = td.textContent || td.innerText;
		if (txtValue.toUpperCase().indexOf(filter) > -1) {
			tr[i].style.display = "";
		} else {
			tr[i].style.display = "none";
		}
		}
	}
	}

</script>
</body>

</html>