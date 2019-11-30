<main>
        <h2 class="dash-title">Add cinema room</h2>
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
            <form class="content-container" action="<?= FRONT_ROOT ?>cinemaRoom/add" method="post">
                <label>
                    <h4>Select cinema:</h4>
                    <select name="id_cinema">
                        <?php foreach($cinemas as $cinema): ?>
                        <option value="<?= $cinema->getId(); ?>"><?= $cinema->getName(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label>
                    <h4>Insert name:</h4>
                    <input type="text" name="name" required>
                </label>
                <label>
                    <h4>Price for ticket:</h4>
                    <input type="number" name="price" min="1" required>
                </label>
                <label>
                    <h4>Capacity:</h4>
                    <input type="number" name="capacity" min="1" required>
                </label>                
                <button type="submit" class="btn">                
                    Add room
                </button>
            </form>

        </div>
    </main>

</body>

</html>
