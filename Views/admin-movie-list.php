<main>
        <h2 class="dash-title">Movies</h2>
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
				<table border="1">
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
								<td><?= $movie->getRuntime(); ?>m </td>
								<td><?= $movie->getReleaseDate(); ?></td>								
								<td>
									<div class="actions-container">
										<a href="<?php echo FRONT_ROOT . "movie/remove/" . $movie->getId(); ?>" class="btn btn-delete">
											<i class="icon ion-md-trash"></i>
											Remove
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