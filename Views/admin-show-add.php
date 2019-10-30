<main>
    <h2 class="dash-title">Add show</h2>
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
    </div>
    <?php endif; ?>

    <div class="dashboard-container">

        <form class="content-container" action="<?= FRONT_ROOT ?>show/add" method="post">

			<label>
				<h4>Select cinema:</h4>
				<select class="" name="id_cinema">
					<?php foreach ($cinemas as $cinema): ?>
						<option value="<?= $cinema->getId(); ?>"><?= $cinema->getName(); ?></option>
					<?php endforeach; ?>
				</select>
			</label>

			<label>
				<h4>Select Movie:</h4>
				<select class="" name="id_movie">
					<?php foreach ($movies as $movie): ?>
						<option value="<?= $movie->getId(); ?>"><?= $movie->getTitle(); ?></option>
					<?php endforeach; ?>
				</select>
			</label>

			<label>
                <h4>Insert date:</h4>
                <input type="date" name="date" id="" required>
            </label>

			<label>
                <h4>Insert hour:</h4>
                <input type="time" name="time" id="" required>
            </label>

            <button type="submit" class="btn">Add show</button>
        </form>

    </div>
</main>
