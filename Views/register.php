    <main>
        <div class="register-container">
            <div class="register-content" >       
                
                <div class="sign-brand">                    
                    <a href="<?= FRONT_ROOT ?>">
                        <i class="icon ion-md-play">MoviePass.</i>                        
                    </a>
                </div>   

                <div class="sign-header">
                    <h3> <span>.</span> Register to start</h3>
                    <p>
                        Are you a member? 
                        <a href="<?= FRONT_ROOT ?>user/loginPath"> Login now</a>                        
                    </p>
                </div>

                <?php if($alert != null): ?>
                <div class="error-container">
                    <p>
                        <i class="icon ion-md-close-circle-outline"></i>
                        <?= $alert ?>
                    </p>
                </div>
                <?php endif; ?>                

                <form action="<?= FRONT_ROOT ?>user/validateRegister" method="post" class="register-form">
                    <label>
                        <input type="text" name="firstName" id="" placeholder="Insert your name" autofocus required/>
                    </label>
                    <label>
                        <input type="text" name="lastName" id="" placeholder="Insert your lastname" required/>
                    </label>
                    <label>
                        <input type="number" name="dni" id="" placeholder="Insert your dni" required/>
                    </label>					
                    <label>
                        <input type="email" name="mail" id="" placeholder="Insert your mail" required/>
                    </label>
                    <label>                        
                        <input type="password" name="password" id="" placeholder="Insert your password" required/>
                    </label>
                    <button class="btn-l" type="submit">Register</button>
                </form>

                <hr class="hr-l" />
                <div class="register-extra">
                    <p>Register with: </p>
                    <button class="btn-fb">
                        <i class="icon ion-logo-facebook"></i>       
                        <span>Facebook</span>             
                    </button>
                </div>
            </div>
            <div class="register-img" style="background-image: url('<?= $img ?>');"></div>
        </div>
    </main>
</body>
</html>
