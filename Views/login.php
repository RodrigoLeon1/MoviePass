    <main>
        <div class="login-container">

            <div class="login-img" style="background-image: url('<?= $img ?>');"></div>
			<div class="login-content">
                <h3>MoviePass Account Login</h3>
                
                <?php if($alert != null): ?>
                <div class="error-container">
                    <p>
                        <i class="icon ion-md-close-circle-outline"></i>
                        <?= $alert ?>
                    </p>
                </div>
                <?php endif; ?>

                <form action="<?= FRONT_ROOT ?>/user/validateLogin" method="POST" class="login-form">
                    <label>
                        <h4>Email</h4>
                        <input type="email" name="mail" id="email" placeholder="mail@example.com" autofocus>
                    </label>
                    <label>
                        <h4>Password</h4>
                        <input type="password" name="password" id="password">
                    </label>
                    <button class="btn-l" type="submit">Connect</button>
                </form>
            </div>

        </div>
    </main>
</body>
</html>
