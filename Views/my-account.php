<body>
    <header>
        <div class="movie-h account-head">                
            <h3 class="section-title text-s">
                <i class="icon ion-md-happy"></i>
                <?= $title;?>
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

                <form method="post" action="<?= FRONT_ROOT ?>image/upload" enctype="multipart/form-data" class="form-upload">
                    <div class="upload-container"> 
                        <input type="file" name="image" value="" class="btn-upload" required>
                    </div>                    
                    <button type="submit" name="button" class="btn-l">Upload photo</button>                    
                </form>    
            </div>
            
            <div class="content-account">
                <div class="item-account">
                    <h2>FirstName:</h2>
                    <p><?= $user->getFirstName(); ?></p>
                </div>
                    
                <div class="item-account">                    
                    <h2>LastName:</h2>
                    <p><?= $user->getLastName(); ?></p>
                </div>

                <div class="item-account">
                    <h2>DNI:</h2>
                    <p><?= $user->getDni(); ?></p>
                </div>

                <div class="item-account">
                    <h2>Email:</h2>
                    <p><?= $user->getMail(); ?></p>            
                </div>
                
                <div class="btn-account">
                    <a href="<?= FRONT_ROOT ?>user/modifyAccountPath" class="btn-l">Edit Account</a>
                </div>
            </div>

        </div>
    </main>