<main>
    <h2 class="dash-title">Add show</h2>
    <hr>
    <div class="dashboard-container">

        <form class="content-container" action="<?= FRONT_ROOT ?>cinema/add" method="post">
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
                            
            <button type="submit">Add show</button>
        </form>

    </div>
</main>
