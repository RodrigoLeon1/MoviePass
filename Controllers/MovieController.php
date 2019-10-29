<?php

    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;    
    use Models\Movie as Movie;

    class MovieController {

        private $movieDAO;        

        public function __construct() {
            $this->movieDAO = new MovieDAO();
        }

        public function showMoviesNowPlaying() {
            return $this->movieDAO->getAll();
        }

        // $id -> Movie $movie
        // El dao se encargar de ir a $movie->getId()
        public function showMovie($id) {
            $movies = $this->movieDAO->getAll();
            foreach ($movies as $movie) {
                if ($movie->getId() == $id) {                    
                    $title = $movie->getTitle();
                    $poster_path = $movie->getPosterPath();
                    $release_date = $movie->getReleaseDate();
                    $overview = $movie->getOverview();
					$adult = $movie->getAdult();
					$vote_average = $movie->getVoteAverage();
                    $img = IMG_PATH_TMDB . $movie->getBackdropPath();                    
                    $urlTrailer = $this->movieDAO->getKeyMovieTrailer($id);
                }
            }
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "header-s.php");
			require_once(VIEWS_PATH . "navbar.php");
            require_once(VIEWS_PATH . "datasheet.php");
			require_once(VIEWS_PATH . "footer.php");
        }

		public function nowPlaying() {
			$movies = $this->showMoviesNowPlaying();
			$title = 'Now Playing';
			$img = IMG_PATH . '/w4.png';
			require_once(VIEWS_PATH . "header.php");
			require_once(VIEWS_PATH . "navbar.php");
			require_once(VIEWS_PATH . "header-s.php");
			require_once(VIEWS_PATH . "now-playing.php");
			require_once(VIEWS_PATH . "footer.php");
		}

		public function comingSoon() {			
			$title = 'Coming Soon';
            $img = IMG_PATH . '/w5.png';
            
            $movies = $this->movieDAO->getComingSoonMovies();

			require_once(VIEWS_PATH . "header.php");
			require_once(VIEWS_PATH . "navbar.php");
			require_once(VIEWS_PATH . "header-s.php");
			require_once(VIEWS_PATH . "coming-soon.php");
			require_once(VIEWS_PATH . "footer.php");
		}

		public function getNowPlayingMoviesFromDAO () {
			$this->movieDAO->getNowPlayingMoviesFromDAO();
        }
        

        public function addMoviePath($alert = "", $success = "") {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				require_once(VIEWS_PATH . "admin-head.php");
				require_once(VIEWS_PATH . "admin-header.php");
				require_once(VIEWS_PATH . "admin-movie-add.php");
			} else {
                $this->userPath();
            }            
        }

        // 
        public function add($id) {
            $movie = new Movie();
            $movie->setId($id);

            if(true){
                $this->movieDAO->add($movie);
                $this->addMoviePath(NULL, MOVIE_ADDED);     
            }

            return $this->addMoviePath(MOVIE_EXIST, NULL);    
        }

        

    }

 ?>
