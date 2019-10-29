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
                <h4>Insert cinema:</h4>
                <select name="cinemas">
                    <?php foreach($this->cinemas as $cinema){ ?>
                    <option value=<?php $cinema->getId(); ?> > <?php echo $cinema->getName(); ?> </option>
                    <?php } ?>
                </select>
            </label>
            <label>
                <h4>Insert movie:</h4>                
                <select name="">
                    <option value="">MOVIE1</option>
                </select>
            </label>
            <label>
                <h4>Insert date:</h4>
                <input type="date" name="date" id="" required>
            </label>            
                            
            <button type="submit" class="btn">Add show</button>
        </form>

    </div>
</main>
