<main>
    <h2 class="dash-title">Add show</h2>
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
    </div>
    <?php endif; ?>

    <div class="dashboard-container">
        <form class="content-container" action="<?= FRONT_ROOT ?>show/add" method="post">
			<label>
				<h4>Select cinema room:</h4>
				<select id="cinema_rooms" name="id_cinemaRoom">
					<?php foreach ($cinemaRooms as $cinemaRoom): ?>                        
                        <?php if($this->checkParameters($id_cinemaRoom, $id_movie, $showDate, $time)): ?>                            
                            <?php if($cinemaRoom->getId() == $id_cinemaRoom): ?>                            
                                <option selected value="<?= $cinemaRoom->getId(); ?>">
                                    <?= $cinemaRoom->getCinema()->getName() . ' - ' . $cinemaRoom->getName(); ?>
                                </option>
                            <?php else: ?>
                                <option value="<?= $cinemaRoom->getId(); ?>">
                                    <?= $cinemaRoom->getName(); ?>
                                </option>
                            <?php endif; ?>
                        <?php else: ?>                            
                            <option value="<?= $cinemaRoom->getId(); ?>">
                                <?= $cinemaRoom->getCinema()->getName() . ' - ' . $cinemaRoom->getName(); ?>
                            </option>                                                        
                        <?php endif; ?>
					<?php endforeach; ?>
				</select>
			</label>

			<label>
				<h4>Select Movie:</h4>
				<select class="" name="id_movie">
					<?php foreach ($movies as $movie): ?>
                        <?php if($this->checkParameters($id_cinemaRoom, $id_movie, $showDate, $time)): ?>                            
                            <?php if($movie->getId() == $id_movie): ?>
                                <option value="<?= $movie->getId(); ?>" selected>
                                    <?= $movie->getTitle(); ?>
                                </option>
                            <?php else: ?>
                                <option value="<?= $movie->getId(); ?>">
                                    <?= $movie->getTitle(); ?>
                                </option>
                            <?php endif; ?>
                        <?php else: ?>						    
                            <option value="<?= $movie->getId(); ?>">
                                <?= $movie->getTitle(); ?>
                            </option>
                        <?php endif; ?>
					<?php endforeach; ?>
				</select>
			</label>

			<label>
                <h4>Insert date:</h4>
				<?php $date = date('Y-m-d'); ?>	
                <?php if($this->checkParameters($id_cinemaRoom, $id_movie, $showDate, $time)): ?>
                    <input type="date" name="date" min="<?= $date; ?>" required value=<?= $showDate; ?>>             
                <?php else: ?>
                    <input type="date" name="date" min="<?= $date; ?>" required>
                <?php endif; ?>
				
            </label>

			<label>
                <h4>Insert hour:</h4>                
                <?php if($this->checkParameters($id_cinemaRoom, $id_movie, $showDate, $time)): ?>
                    <input type="time" name="time" required value=<?= $time; ?>>
                <?php else: ?>
                    <input type="time" name="time" required>
                <?php endif; ?>
            </label>

            <button type="submit" class="btn">Add show</button>
        </form>
    </div>
</main>
