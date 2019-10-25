    <main>
        <h2 class="dash-title">Cinemas</h2>
        <hr>
        <div class="dashboard-container">

            <div class="content-container">
				<form action="<?php echo FRONT_ROOT."cinema/remove" ?>" method="">
					<table border="1">
						<thead>
							<tr>
								<th>Id</th>
								<th>Name</th>
								<th>Capacity</th>
								<th>Address</th>
								<th>Price ticket</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($this->cinemas as $cinema): ?>
								<tr>
									<td><?= $cinema->getId(); ?></td>
									<td><?= $cinema->getName(); ?></td>
									<td><?= $cinema->getCapacity(); ?></td>
									<td><?= $cinema->getAddress(); ?></td>
									<td><?= $cinema->getPrice(); ?></td>
									<td>
										<a href="<?php echo FRONT_ROOT . "cinema/remove/" . $cinema->getId(); ?>" class="btn">Remove</a>
										<a href="<?php echo FRONT_ROOT . "cinema/getById/" . $cinema->getId(); ?>" class="btn">Modify</a>
									</td>

								</td>
							<?php endforeach; ?>
						</tbody>
					</table>
				</form>
            </div>

        </div>
    </main>

</body>

</html>
