    <main>
        <h2 class="dash-title">Add User</h2>
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
            <form class="content-container" action="<?= FRONT_ROOT ?>user/adminAdd" method="post">
                <label>
                    <h4>Insert Role:</h4>
                    <input type="number" name="role" id="" required>
                </label>
                <label>
                    <h4>First Name:</h4>
                    <input type="text" name="firstName" id="" required>
                </label>
                <label>
                    <h4>Last Name:</h4>
                    <input type="text" name="lastName" id="" required>
                </label>
                <label>
                    <h4>DNI:</h4>
                    <input type="number" name="dni" id="" required>
                </label>
                <label>
                    <h4>Mail:</h4>
                    <input type="email" name="mail" id="" required>
                </label>
                <label>
                    <h4>Password:</h4>
                    <input type="password" name="password" id="" required>
                </label>
                <button type="submit">Add user</button>
            </form>

        </div>
    </main>

</body>

</html>
