<body>
    <nav class="nav-container">
        <div class="nav-brand">
            <a href="<?= FRONT_ROOT ?>">
                <i class="icon ion-md-play"> MoviePass<span>.</span></i>
            </a>
        </div>

        <ul class="nav-list">
            <li>
                <a href="<?= FRONT_ROOT ?>movie/nowPlaying" class="nav-link">Now playing</a>
            </li>
            <li>
                <a href="<?= FRONT_ROOT ?>movie/comingSoon" class="nav-link">Coming soon</a>
            </li> 
            
            <?php if(!isset($_SESSION["loggedUser"])): ?>
            <li>
                <a href="<?= FRONT_ROOT ?>user/registerPath" class="nav-link">Register</a>
            </li>
            <?php endif; ?>
            
            <?php if(!isset($_SESSION["loggedUser"])): ?>
            <li>
                <a href="<?= FRONT_ROOT ?>user/loginPath" class="nav-link">Login</a>
            </li>
            <?php endif; ?>

            <?php if(isset($_SESSION["loggedUser"])): ?>      
                <?php $user = $_SESSION["loggedUser"] ?>
                <li>
                	<a href="<?= FRONT_ROOT ?>user/loginPath" class="nav-link">
                        <?= $user->getMail() ?>
                        <i class="icon ion-md-arrow-dropdown"></i>
                    </a>
                    <!-- SubMenu -->
                    <ul class="sub-menu">
                        <li>
                            <a href="<?= FRONT_ROOT ?>user/myAccountPath" class="nav-link">Account</a>                            
                        </li>

                        <li>
                            <a href="<?= FRONT_ROOT ?>user/myCartPath" class="nav-link">My cart</a>                            
                        </li>

                        <?php if($user->getRole() == 1): ?>
                        <li>
                            <a href="<?= FRONT_ROOT ?>user/adminpath" class="nav-link">Dashboard</a>
                        </li>
                        <?php endif; ?>

                        <li>
                            <a href="<?= FRONT_ROOT ?>user/logoutPath" class="nav-link">Logout</a>
                        </li>
                    </ul>

                </li>
            <?php endif; ?>
        </ul>
    </nav>
