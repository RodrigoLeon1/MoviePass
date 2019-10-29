<main>

    <div class="movie-options">

    </div>

    <?php foreach ($movies as $movie): ?>
    <div class="container movie-container">
        <div class="movie-img">
            <img src="https://image.tmdb.org/t/p/original<?= $movie->getPosterPath() ?>" alt="">
        </div>
        <div class="movie-info">
            <h3><?= $movie->getTitle() ?></h3>
            <p>
                <i class="icon ion-md-star"></i>
                <?= $movie->getVoteAverage() ?>
            </p>
            <p><?= $movie->getOverview() ?></p>
        </div>
        <div class="movie-cta">
            <a class="btn-l" href="<?= FRONT_ROOT ?>movie/showMovie/?id=<?= $movie->getId() ?>">  
                <i class="icon ion-md-add"></i>More info
            </a>
        </div>
    </div>
    <?php endforeach; ?>

</main>
