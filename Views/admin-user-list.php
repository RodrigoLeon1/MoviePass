<main>
        <h2 class="dash-title">Users</h2>
        <hr>
        <div class="dashboard-container">

            <div class="content-container">
				<form action="<?php echo FRONT_ROOT . "" ?>" method="">
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
							<?php foreach ($users as $user): ?>
								<tr>					
                                    <td></td>				
									<td><?= $user->getFirstName(); ?></td>
									<td><?= $user->getLastName(); ?></td>
									<td><?= $user->getDni(); ?></td>
									<td><?= $user->getMail(); ?></td>
									<td><button type="submit" name="id" class="btn btn-delete" value="<?php ?>"> Remove </button></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</form>
            </div>

        </div>
    </main>

</body>

</html>