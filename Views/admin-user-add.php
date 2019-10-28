    <main>
        <h2 class="dash-title">Add User</h2>
        <hr>

        <?php ?>
        <div class="error-container">
            <i class="icon ion-md-close-circle-outline"></i>
            <h3>Error message</h3>
        </div>
        <?php ?>

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
