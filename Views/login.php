    <main>
        <div class="login-container">

            <div class="login-img" style="background-image: url('<?= $img; ?>');"></div>
            
            <div class="login-content">
            
                <div class="sign-brand">                    
                    <a href="<?= FRONT_ROOT ?>">
                        <i class="icon ion-md-play">MoviePass.</i>                        
                    </a>
                </div>

                <div class="sign-header">
                    <h3> <span>.</span> Sign in to continue</h3>
                    <p>
                        <i class="icon ion-md-hand"></i>
                        Not a member yet? 
                        <a href="<?= FRONT_ROOT ?>user/registerPath"> Register now</a>                        
                    </p>
                </div>

                <?php if($alert != NULL): ?>
                <div class="error-container">
                    <p>
                        <i class="icon ion-md-close-circle-outline"></i>
                        <?= $alert; ?>
                    </p>
                </div>
                <?php endif; ?>

                <form action="<?= FRONT_ROOT ?>user/validateLogin" method="POST" class="login-form">
                    <label>
                        <h4>Mail</h4>
                        <input type="email" name="mail" id="email" placeholder="Insert your mail" required autofocus>
                    </label>
                    <label>
                        <h4>Password</h4>
                        <input type="password" name="password" id="password" placeholder="Insert your password" required>
                    </label>
                    <button class="btn-l" type="submit">Login</button>
                </form>
            </div>

        </div>
    </main>
</body>
</html>
