<main>
	<h2 class="dash-title">Users</h2>
	<hr>

	<?php if ($success != null): ?>
	<div class="alert-container success-container">
		<i class="icon ion-md-checkmark"></i>
		<h3><?= $success; ?></h3>
	</div>
	<?php endif; ?>        

	<?php if ($alert != null): ?>
	<div class="alert-container error-container">
		<i class="icon ion-md-close-circle-outline"></i>
		<h3><?= $alert; ?></h3>
	</div>
	<?php endif; ?>

	<div class="dashboard-container">
		<div class="content-container">				
			<table border="1" id="myTable">
				<div class="filter-container">
					<div class="filter-search">						
						<i class="icon ion-md-search"></i>
						<input class="filter-input" type="text" class="filter" id="myInput" placeholder="Search for user's dni..">
					</div>
					<div class="filter-options">						
						<p>Filter by:</p>
						<input type="radio" name="filter" id="input-dni" value="dni" checked> Dni
						<input type="radio" name="filter" id="input-email" value="email"> Email						
					</div>
				</div>
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
					<?php foreach ($users as $user): ?>
						<tr>					
							<td><?= $user->getFirstName(); ?></td>
							<td><?= $user->getLastName(); ?></td>
							<td><?= $user->getDni(); ?></td>
							<td><?= $user->getMail(); ?></td>
							<td>
								<div class="actions-container">
									<?php if ($user->getIsActive()): ?>
									<a href="<?= FRONT_ROOT . "user/disable/" . $user->getDni(); ?>" class="btn btn-disable">
										<i class="icon ion-md-trash"></i>
										Disable
									</a>							
									<?php else: ?>
									<a href="<?= FRONT_ROOT . "user/enable/" . $user->getDni(); ?>" class="btn btn-enable">
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
	let inputDni = document.getElementById('input-dni');
	let inputEmail = document.getElementById('input-email');
	
	inputDni.addEventListener('click', () => {
		outerInput.placeholder = `Search for user's dni..`;	
	});

	inputEmail.addEventListener('click', () => {
		outerInput.placeholder = `Search for user's email..`;			
	});

	outerInput.addEventListener('keyup', function() {
		let innerInput, filter, table, tr, td, i, txtValue;
		innerInput = document.getElementById('myInput');
		filter = innerInput.value.toUpperCase();
		table = document.getElementById('myTable');
		tr = table.getElementsByTagName('tr');
		
		for (i = 0; i < tr.length; i++) {
			if (innerInput.placeholder.includes('dni')) {
				td = tr[i].getElementsByTagName('td')[2];
			} else {
				td = tr[i].getElementsByTagName('td')[3];
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
