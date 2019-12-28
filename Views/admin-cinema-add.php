    <main>
        <h2 class="dash-title">Add cinema</h2>
        <hr>

        <?php if ($success != null): ?>
        <div class="alert-container success-container">
            <i class="icon ion-md-checkmark"></i>
            <h3><?= $success; ?></h3>
        </div>
        <?php endif; ?>    

        <?php if ($alert != null): ?>
        <div class="alert-container error-container">
            <i class="icon ion-md-close-circle-outline"></i>
            <h3><?= $alert; ?></h3>
        </div>
        <?php endif; ?>
        
        <div class="dashboard-container">            
            <form class="content-container" action="<?= FRONT_ROOT ?>cinema/add" method="post">
                <label>
                    <h4>Insert name:</h4>
                    <input type="text" name="name" required>
                </label>
                <label>
                    <h4>Address:</h4>
                    <input type="text" name="address" required>
                </label>                
                <button type="submit" class="btn">                
                    Add cinema
                </button>
            </form>
        </div>
    </main>

</body>

</html>
