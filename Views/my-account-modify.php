<body>
    <header>
        <div class="movie-h account-head">                
            <h3 class="section-title text-s">
                <i class="icon ion-md-happy"></i>
                <?= $title; ?>
            </h3>
        </div>
    </header>

    <main>
        <div class="container account-container">
            <div class="img-account">
                <?php if ($imageProfile): ?>
                    <img src="<?= IMG_UPLOADS_PATH . $imageProfile->getName(); ?>" alt="Profile picture">
                <?php else: ?>                    
                    <img src="<?= IMG_PATH ?>profile.jpg" alt="Profile picture">
                <?php endif; ?>             
            </div>
            <div class="content-account">
            <h3> <span>_</span> Insert the new information</h3>
                <form class="content-container modify-form" action="<?= FRONT_ROOT ?>user/updateAccount" method="post">              
                    <label>
                        <h4>Insert Firstname:</h4>
                        <input type="text" name="firstname" value="<?= $user->getFirstName(); ?>" required>
                    </label>
                    <label>
                        <h4>Insert Lastname:</h4>
                        <input type="text" name="lastname" value="<?= $user->getLastName(); ?>" required>
                    </label>
                    <label>
                        <h4>Insert DNI:</h4>
                        <input type="number" name="dni" value="<?= $user->getDni(); ?>" required>         
                    </label>
                    <label>
                        <h4>Insert mail:</h4>
                        <input type="email" name="mail" value="<?= $user->getMail(); ?>" required>           
                    </label>
                    <label>
                        <h4>Insert password:</h4>
                        <input type="password" name="password" value="<?= $user->getPassword(); ?>" required> 
                    </label>                
                    <button type="submit" class="btn-l">Modify</button>
                </form>
            </div>
        </div>          
    </main>

</body>
</html>
