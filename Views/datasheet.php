<main class="">
    <div class="dataSheet_Style">

        <div class="poster_Style">
            <img src="<?= IMG_PATH_TMDB . $poster_path ?> ">

            <!-- <form method="POST" action="<?= FRONT_ROOT ?>ticket/purchaseTicketPath">
                <input id="idMovie" name="idMovie" type="hidden" value="">
                <button class="btn-l" type="submit">Buy ticket</button>
            </form> -->
        </div>

        <div class="specification_Style">
            <div>
                <p class="title1_Style">Overview</p>
            </div>
            <div class="synopsis-container">
                <p class="synopsis_Style">
                    <?= $overview ?>
                    <div class="synopsis-extra">
                        <div class="movie-rating">
                            <i class="icon ion-md-star"></i>
                            Rating <?= $vote_average ?> 
                        </div>
                        <div class="genres">
                            <i class="icon ion-md-color-wand"></i>
                            Genres: Terror, adventure, family
                        </div>
                        <div class="duration">
                            <i class="icon ion-md-stopwatch"></i>
                            Duration 90m
                        </div>
                        <div class="genres">
                            <i class="icon ion-md-calendar"></i>
                            Release date: 
                            <?= $release_date ?>
                        </div>          
                        <div class="age">
                            <i class="icon ion-md-person"></i>
                            Age restriction:
                            <?= $adult ?>
                        </div>                                       
                    </div>
                </p>
            </div>    

            <div class="show-container">

                <h2>Movie Showtimes</h2>

                <div class="show-item">
                    <div class="show-content">
                        <h2>Paseo Aldrey</h2>
                        <p>
                            <p>
                                <i class="icon ion-md-calendar"></i> 
                                June18, 2019 at 8:00 
                            </p>
                            <p>-</p>
                            <p>
                                <i class="icon ion-md-pin"></i>
                                Sarmiento 2685
                            </p>
                        </p>
                    </div>
                    <div class="show-ticket">
                        <a href="<?= FRONT_ROOT ?>ticket/purchaseTicketPath">Buy Ticket</a>
                    </div>
                </div>
                
                <div class="show-item">
                    <div class="show-content">
                        <h2>Ambassador</h2>
                        <p>
                            <p>
                                <i class="icon ion-md-calendar"></i> 
                                June18, 2019 at 8:00 
                            </p>
                            <p>-</p>
                            <p>
                                <i class="icon ion-md-pin"></i>
                                Cordoba DVi
                            </p>
                        </p>
                    </div>
                    <div class="show-ticket">
                        <a href="<?= FRONT_ROOT ?>ticket/purchaseTicketPath">Buy Ticket</a>
                    </div>
                </div>

                <div class="show-item">
                    <div class="show-content">
                        <h2>CinemaCenter</h2>
                        <p>
                            <p>
                                <i class="icon ion-md-calendar"></i>     
                                June18, 2019 at 8:00 
                            </p>
                            <p>-</p>
                            <p>
                                <i class="icon ion-md-pin"></i>    
                                Diag. Pueyrredon 3050
                            </p>
                        </p>
                    </div>
                    <div class="show-ticket">
                        <a href="<?= FRONT_ROOT ?>ticket/purchaseTicketPath">Buy Ticket</a>
                    </div>
                </div>

                <div class="show-item">
                    <div class="show-content">
                        <h2>Cinema II</h2>
                        <p>
                            <p>
                                <i class="icon ion-md-calendar"></i> 
                                June18, 2019 at 8:00 
                            </p>
                            <p>-</p>
                            <p>
                                <i class="icon ion-md-pin"></i>
                                Los Gallegos Shopping
                            </p>
                        </p>
                    </div>
                    <div class="show-ticket">
                        <a href="<?= FRONT_ROOT ?>ticket/purchaseTicketPath">Buy Ticket</a>
                    </div>
                </div>  
                
                <div class="show-item">
                    <div class="show-content">
                        <h2>Cine del Paseo</h2>
                        <p>
                            <p>
                                <i class="icon ion-md-calendar"></i> 
                                June18, 2019 at 8:00 
                            </p>
                            <p>-</p>
                            <p>
                                <i class="icon ion-md-pin"></i>
                                Diagonal Pueyrredon
                            </p>
                        </p>
                    </div>
                    <div class="show-ticket">
                        <a href="<?= FRONT_ROOT ?>ticket/purchaseTicketPath">Buy Ticket</a>
                    </div>
                </div>                  
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
        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $urlTrailer ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope;" allowfullscreen></iframe>
        </div>
    </div>
</main>
