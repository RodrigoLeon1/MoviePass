<body>
    <header>
        <nav class="nav-container">
            <div class="nav-brand">
                <span>
                    <a href="<?= FRONT_ROOT ?>">
                        <i class="icon ion-md-play"></i>
                        MoviePass
                    </a>
                </span>
            </div>
            <ul class="nav-list">
                <li>
                    <i class="icon ion-md-home"></i>
                    <a href="<?= FRONT_ROOT ?>user/adminpath">Dashboard</a>
                </li>

                <li>
                    <i class="icon ion-md-videocam"></i>
                    Cinema
                    <ul>
                        <li>
                            <i class="icon ion-md-remove"></i>
                            <a href="<?= FRONT_ROOT ?>cinema/addCinemaPath">Add cinema</a>
                        </li>
                        <li>
                            <i class="icon ion-md-remove"></i>
                            <a href="<?= FRONT_ROOT ?>cinema/list">View/Edit cinemas</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <i class="icon ion-md-play-circle"></i>
                    Movies
                    <ul>
                        <li>
                            <i class="icon ion-md-remove"></i>
                            <a href="<?= FRONT_ROOT ?>movie/addMoviePath">Add movie</a>
                        </li>
                        <li>
                            <i class="icon ion-md-remove"></i>
                            <a href="<?= FRONT_ROOT ?>show/addShowPath">Add show</a>                            
                        </li>
                    </ul>
                </li>
                <li>
                    <i class="icon ion-md-person"></i>
                    Users
                    <ul>
						<li>
                            <i class="icon ion-md-remove"></i>
                            <a href="<?= FRONT_ROOT ?>user/list">View users</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="icon-container">
            <div class="icon-items">
				<span><?= $admin->getMail() ?> <i class="icon ion-md-contact"></i></span>
                <span>
					<a href="<?= FRONT_ROOT ?>user/logoutPath" class="icon ion-md-log-out">Log out</a>
				</span>
            </div>
        </div>
    </header>
