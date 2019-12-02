<main>        
    <div class="back-container">
        <a href="<?= FRONT_ROOT ?>movie/nowPlaying">
            <i class="icon ion-md-arrow-back"></i>
            Back
        </a>
    </div>
    <div class="dataSheet_Style">        
        
    <div class="poster_Style">
            <img src="<?= IMG_PATH_TMDB . $movie->getPosterPath(); ?> ">
        </div>        

        <div class="specification_Style">
            <div>
                <p class="title1_Style">Overview</p>
            </div>
            <div class="synopsis-container">
                <p class="synopsis_Style">
                    <?= $movie->getOverview(); ?>
                    <div class="synopsis-extra">
                        <div class="movie-rating">
                            <i class="icon ion-md-star"></i>
                            Rating: <span> <?= $movie->getVoteAverage(); ?> </span>
                        </div>
                        <div class="genres">
                            <i class="icon ion-md-color-wand"></i>
                            Genres:                             
                            <?php foreach ($genres as $genre): ?>
                                <span><?= $genre ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="duration">
                            <i class="icon ion-md-stopwatch"></i>
                            Duration: <span> <?= $this->minToHour($movie->getRuntime()); ?> </span>
                        </div>
                        <div class="release">
                            <i class="icon ion-md-calendar"></i>
                            Release date: <span> <?= $movie->getReleaseDate(); ?> </span>                            
                        </div>                                                
                    </div>
                </p>
            </div>    

            <div class="show-container">
                <h2>Movie Showtimes</h2>
                
                <?php if(empty($shows)): ?>
                    <p class="synopsis_Style">No shows available at the moment.</p>
                <?php endif; ?>

                <?php foreach ($shows as $show): ?>
                <div class="show-item">
                    <div class="show-content">
                        <h2><?= $show->getCinemaRoom()->getCinema()->getName(); ?> - <?= $show->getCinemaRoom()->getName(); ?></h2>
                        <p>
                            <p>
                                <i class="icon ion-md-calendar"></i> 
                                <!-- June 18, 2019 at 8:00  -->
                                <?= date('F j, Y', strtotime($show->getDateStart())); ?>
                                at 
                                <?= date('H:i', strtotime($show->getTimeStart())); ?>
                            </p>
                            <p>-</p>
                            <p>
                                <i class="icon ion-md-pin"></i>
                                <?= $show->getCinemaRoom()->getCinema()->getAddress(); ?>
                            </p>
                        </p>
                    </div>
                    <?php if($purchaseController->ticketsAvailable($show->getId())): ?>                    
                        <div class="show-ticket">
                            <a href="<?= FRONT_ROOT ?>purchase/buyTicketPath/<?= $show->getId(); ?>">Buy Ticket</a>
                        </div>
                    <?php else: ?>
                        <div class="show-ticket sold-out">
                            <a>Sold out</a>
                        </div>
                    <?php endif; ?>                    
                </div>                    
                <?php endforeach; ?>                             
                <br>                
            </div>    
        </div>
    </div>

    <div class="datasheet-video text-s">
        <h4>
            <i class="icon ion-md-videocam"></i>
            TRAILER
        </h4>

        <br><hr><br>

        <div>
            <iframe width="854" height="480" src="https://www.youtube.com/embed/<?= $keyTrailer ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope;" allowfullscreen></iframe>
        </div>
    </div>
</main>
