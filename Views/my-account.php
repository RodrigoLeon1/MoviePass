<body>
    <header>
        <div class="movie-h account-head">                
            <h3 class="section-title text-s">
                <i class="icon ion-md-happy"></i>
                <?= $title ?>
            </h3>
        </div>
    </header>
        
    <main>
        <div class="container account-container">

            <div class="img-account">
                <img src="<?= IMG_PATH ?>profile.jpg" alt="Profile picture">
                <a href="" class="btn-l">Edit Account</a>
            </div>
            
            <div class="content-account">
                <div class="item-account">
                    <h2>FirstName:</h2>
                    <p><?= $user->getFirstName() ?></p>
                </div>
                    
                <div class="item-account">                    
                    <h2>LastName:</h2>
                    <p><?= $user->getLastName() ?></p>
                </div>

                <div class="item-account">
                    <h2>DNI:</h2>
                    <p><?= $user->getDni() ?></p>
                </div>

                <div class="item-account">
                    <h2>Email:</h2>
                    <p><?= $user->getMail() ?></p>            
                </div>

            </div>

        </div>
    </main>