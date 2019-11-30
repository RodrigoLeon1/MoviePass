<main>
    <?php foreach ($movies as $movie): ?>
    <div class="container movie-container movie-container-secundary">
        <div class="movie-img">            
            <img src="https://image.tmdb.org/t/p/original<?= $movie->getPosterPath(); ?>" alt="">            
        </div>
        <div class="movie-info">
            <h3><?= $movie->getTitle(); ?></h3>
            <p>
                <i class="icon ion-md-calendar"></i>
                Release date: 
                <?= $movie->getReleaseDate(); ?>
            </p>  
            <p>
                <i class="icon ion-md-star"></i>
                <?= $movie->getVoteAverage(); ?>
            </p>
            <p class="overview-text"><?= $movie->getOverview(); ?></p>
        </div>
    </div>
    <?php endforeach; ?>
</main>
