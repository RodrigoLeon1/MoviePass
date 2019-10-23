<main class="">
    <div class="dataSheet_Style">

        <div class="poster_Style">
            <img src="<?= IMG_PATH_TMDB . $poster_path ?> ">
            <br><br>

            <form method="POST" action="<?= FRONT_ROOT ?>test/purchaseTicket">
                <input id="idMovie" name="idMovie" type="hidden" value="">
                <button class="btn-l" type="submit">Buy ticket</button>
            </form>
        </div>

        <div class="specification_Style">
            <div>
                <p class="title1_Style">SYNOPSIS</p>
            </div>
            <div>
                <p class="synopsis_Style">
                    <?= $overview ?>
                </p>
            </div>
            <br><br><br>
            <ul>
                <br>
                <li>
                    <div class="label_Style">
                    <i class="icon ion-md-remove"></i>
                        Genre
                    </div>
                    <div class="data_Style">Terror</div>
                </li>
                <br>
                <br>
                <li>
                    <div class="label_Style">
                        <i class="icon ion-md-remove"></i>
                        Age restriction
                    </div>
                    <div class="data_Style">
                        <?php if( $adult ) { ?>
                            Adults Only
                        <?php } else { ?>
                            General Audiences
                        <?php } ?>
                    </div>
                </li>
                <br>
                <br>
                <li>
                    <div class="label_Style">
                        <i class="icon ion-md-remove"></i>
                        Rating
                    </div>
                    <div class="data_Style"><?= $vote_average ?></div>
                </li>
                <br>
                <br>
                <li>
                    <div class="label_Style">
                        <i class="icon ion-md-remove"></i>
                        Release date
                    </div>
                    <div class="data_Style"><?= $release_date ?></div>
                </li>
            </ul>
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
