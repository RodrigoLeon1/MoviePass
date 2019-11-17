    <main>
        <h2>Dashboard</h2>
        <hr>
        <div class="dashboard-container">            
            <!-- <div class="dash-item">
                <h4>Total Users</h4>
                <p>150</p>
            </div>
            <div class="dash-item">
                <h4>Total Cinemas</h4>
                <p>150</p>
            </div>
            <div class="dash-item">
                <h4>Total Shows</h4>
                <p>150</p>
            </div>      
            <div class="dash-item">
                <h4>Total Movies</h4>
                <p>150</p>
            </div>              -->
            <h1>
                <i class="icon ion-md-hand"></i>
                Welcome <?= $admin->getFirstName() ?> <?= $admin->getLastName() ?> to the dashboard main page.
            </h1>
        </div>       
        
        <div class="dashboard-movies">
            <h4>Movies now playing</h4>
            <hr>
            <div class="movies-container">
                <?php foreach ($movies as $movie): ?>
                <div class="movie">
                    <img src="<?= IMG_PATH_TMDB . $movie->getPosterPath() ?>" alt="<?= $movie->getTitle() ?>">
                </div>                    
                <?php endforeach; ?>                                            
            </div>
        </div>

    </main>
</body>

</html>