<main>

    <div class="container filter-container">
        <h4>Do you want to filter the list of movies?</h4>

        <form class="filter-form" action="" method="post">
            <label>
                Category
                <select name="category">
                    <option value="value1">Value 1</option>
                    <option value="value2">Value 2</option>
                    <option value="value3">Value 3</option>
                </select>
            </label>
            <label>
                Date:
                <input type="date" name="" id="">
            </label>

            <button type="submit" class="btn-f">Filter</button>
        </form>
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
