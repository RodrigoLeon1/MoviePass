    <main>
        <h2 class="dash-title">Add cinema</h2>
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
            <form class="content-container" action="<?= FRONT_ROOT ?>cinema/add" method="post">
                <label>
                    <h4>Insert name:</h4>
                    <input type="text" name="name" id="" required>
                </label>
                <label>
                    <h4>Capacity:</h4>
                    <input type="number" name="capacity" id="" required>
                </label>
                <label>
                    <h4>Address:</h4>
                    <input type="text" name="address" id="" required>
                </label>
                <label>
                    <h4>Price for ticket:</h4>
                    <input type="number" name="price" id="" required>
                </label>
                <button type="submit" class="btn">                
                    Add cinema
                </button>
            </form>

        </div>
    </main>

</body>

</html>
