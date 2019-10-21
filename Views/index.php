<main>
    <section id="now-playing">
        <div class="container">
            <h3 class="section-title">Now playing</h3>
            <hr>

            <br>
            <br>
            <br>

            <div class="glider-contain multiple">
                <button class="glider-prev">
                    <i class="icon ion-md-arrow-dropleft"></i>
                </button>

                <div class="glider">
                    <?php foreach ($movies as $movie): ?>
                    <figure>
                        <a href="<?= FRONT_ROOT ?>movie/showMovie/<?= $movie->getId() ?>">
                            <img src="https://image.tmdb.org/t/p/original<?= $movie->getPosterPath() ?>" alt="">
                            <h2><?= $movie->getTitle(); ?></h2>
                        </a>
                    </figure>
                    <?php endforeach; ?>
                </div>

                <button class="glider-next">
                    <i class="icon ion-md-arrow-dropright"></i>
                </button>

                <div id="dots" class="glider-dots"></div>
            </div>

            <a class="more-movies" href="<?= FRONT_ROOT ?>/home/now_playing">More movies</a>

        </div>
    </section>

    <section id="coming-soon" class="s-2">
        <div class="container">
            <h3 class="section-title">Coming soon</h3>
            <hr>

            <br>
            <br>
            <br>

            <div class="glider-contain multiple">
                <button class="glider-prev glider2-prev">
                    <i class="icon ion-md-arrow-dropleft"></i>
                </button>

                <div class="glider2">
                    <figure>
                        <a href="https://www.google.com">
                            <img src="views/assets/img/poster2.jpg" alt="">
                            <h2>Joker</h2>
                        </a>
                    </figure>
                    <figure>
                        <a href="https://www.google.com">
                            <img src="views/assets/img/poster2.jpg" alt="">
                            <h2>Joker</h2>
                        </a>
                    </figure>
                    <figure>
                        <a href="https://www.google.com">
                            <img src="views/assets/img/poster2.jpg" alt="">
                            <h2>Joker</h2>
                        </a>
                    </figure>
                    <figure>
                        <a href="https://www.google.com">
                            <img src="views/assets/img/poster2.jpg" alt="">
                            <h2>Joker</h2>
                        </a>
                    </figure>
                    <figure>
                        <a href="https://www.google.com">
                            <img src="views/assets/img/poster2.jpg" alt="">
                            <h2>Joker</h2>
                        </a>
                    </figure>
                </div>

                <button class="glider-next glider2-next">
                    <i class="icon ion-md-arrow-dropright"></i>
                </button>

                <div id="dots2" class="glider-dots"></div>
            </div>

            <a class="more-movies" href="<?= FRONT_ROOT ?>/home/coming_soon">More movies</a>

        </div>
    </section>

    <section>
        <div class="container">
            <h3 class="section-title">Search movies</h3>
            <hr>

            <div>
                <form action="" method="post" class="search-container">
                    <label>
                        <input type="text" name="" id="" placeholder="Insert the name of the movie">
                    </label>
                    <button class="btn-l" type="submit">
                        <i class="icon ion-md-search"></i>
                    </button>
                </form>
            </div>

        </div>
    </section>
</main>
