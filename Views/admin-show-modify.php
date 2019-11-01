<main>
    <h2 class="dash-title">Add show</h2>
    <hr>
    <div class="dashboard-container">

        <form class="content-container" action="<?= FRONT_ROOT ?>show/modify" method="post">

			<label>
				<h4>Id:</h4>
				<input type="number" name="id" id="" value="<?php echo $show->getId(); ?>">
			</label>

			<label>
				<h4>Modify cinema:</h4>
				<select class="" name="id_cinema">
					<?php foreach ($cinemas as $cinema): ?>
						<?php $cinemaNumber = $cinema->getId(); ?>
						<option value="<?= $cinemaNumber; ?>"><?= $cinema->getName(); ?></option>
					<?php endforeach; ?>
				</select>
				<h6>Previous: <?= $show->getCinema()->getName(); ?></h6>
			</label>

			<label>
				<h4>Modify Movie:</h4>
				<select class="" name="id_movie">
					<?php foreach ($movies as $movie): ?>
						<option value="<?= $movie->getId(); ?>"><?= $movie->getTitle(); ?></option>
					<?php endforeach; ?>
				</select>
				<h6>Previous: <?= $show->getMovie()->getTitle(); ?></h6>
			</label>

			<label>
                <h4>Modify date:</h4>
                <input type="date" name="date" id="" value="<?= $show->getDateStart(); ?>" required>
            </label>

			<label>
                <h4>Modify hour:</h4>
                <input type="time" name="time" id="" value="<?= $show->getTimeStart(); ?>" required>
            </label>

            <button type="submit">Modify show</button>
        </form>

    </div>
</main>
