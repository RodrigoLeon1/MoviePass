    <main>
        <div class="register-container">
            <div class="register-content" >                
                <form action="<?= FRONT_ROOT ?>user/validateRegister" method="post" class="register-form">
                    <label>
                        <h4>Insert your First Name</h4>
                        <input type="text" name="firstName" id="" placeholder="Jhon" autofocus required/>
                    </label>
                    <label>
                        <h4>Insert your Last Name</h4>
                        <input type="text" name="lastName" id="" placeholder="Doe" autofocus required/>
                    </label>
                    <label>
                        <h4>Insert your DNI</h4>
                        <input type="number" name="dni" id="" placeholder="55666777" autofocus required/>
                    </label>					
                    <label>
                        <h4>Insert your email</h4>
                        <input type="email" name="mail" id="" placeholder="mail@example.com" autofocus required/>
                    </label>
                    <label>
                        <h4>Insert your password</h4>
                        <input type="password" name="password" id="" required/>
                    </label>
                    <button class="btn-l" type="submit">Register</button>
                </form>

                <hr class="hr-l" />
                <button class="btn-fb">Register with Facebook</button>
            </div>
            <div class="register-img" style="background-image: url('<?= $img ?>');"></div>
        </div>
    </main>
</body>
</html>
