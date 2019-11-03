<?php

    namespace Controllers;

    use Models\Movie as Movie;    
    use DAO\MovieDAO as MovieDAO;
    use Controllers\GenreToMovieController as GenreToMovieController;
	use Controllers\ShowController as ShowController;

    class MovieController {

        private $movieDAO;
		private $showController;

        public function __construct() {
            $this->movieDAO = new MovieDAO();
			$this->showController = new ShowController();
        }

        public function moviesNowPlaying() {
            return $this->movieDAO->getAll();
        }

		public function moviesNowPlayingOnShow() {
            return $this->showController->moviesOnShow();
        }

        public function showMovie($id) {
            $movies = $this->moviesNowPlaying();
            $genreMovieController = new GenreToMovieController();    
            foreach ($movies as $movieRow) {
                if ($movieRow->getId() == $id) {                                                                                
                    $movie = new Movie();
                    $movie = $movieRow;                    
                    $title = $movie->getTitle();
                    $img = IMG_PATH_TMDB . $movie->getBackdropPath();
                    $keyTrailer = $this->movieDAO->getKeyMovieTrailer($movie);     
                    $shows = $this->showController->getShowsOfMovieById($id);
                    $genres = $genreMovieController->getGenresOfMovie($movie);                                                   
                }
            }            
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "header-s.php");
			require_once(VIEWS_PATH . "navbar.php");
            require_once(VIEWS_PATH . "datasheet.php");
			require_once(VIEWS_PATH . "footer.php");
        }

		public function nowPlaying() {
            $movies = $this->moviesNowPlayingOnShow();            
            $genreController = new GenreToMovieController();
            $genres = $genreController->getAllGenres();            

			$title = 'Now Playing';
            $img = IMG_PATH . '/w4.png';
            
			require_once(VIEWS_PATH . "header.php");
			require_once(VIEWS_PATH . "navbar.php");
			require_once(VIEWS_PATH . "header-s.php");
			require_once(VIEWS_PATH . "now-playing.php");
			require_once(VIEWS_PATH . "footer.php");
		}

        public function filterMovies($id, $date) {            
            
            $genreMovieController = new GenreToMovieController();            
            $genres = $genreMovieController->getAllGenres();
            $nameGenre = $genreMovieController->getNameOfGenre($id);            
            $movies = $genreMovieController->searchMovieByGenre($id);  

            if(!empty($id) && empty($date)) {
                echo '1 - filtrar por id';
            } else if (!empty($date) && empty($id)) {
                echo '2 - filtrar por fecha';
            } else if (!empty($id) && !empty($date)) {
                echo '3 - filtrar por id y fecha';
            } else {
                echo 'ambos vacios - no filtrar';
            }

            $title = 'Now Playing - ' . $nameGenre;
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

		public function getNowPlayingMoviesFromDAO() {
			$this->movieDAO->getNowPlayingMoviesFromDAO();
			$this->movieDAO->getRunTimeMovieFromDAO();
        }

        public function addMoviePath($alert = "", $success = "") {
			if (isset($_SESSION["loggedUser"])) {
                $admin = $_SESSION["loggedUser"];
                if($admin->getRole() == 1) {
				    require_once(VIEWS_PATH . "admin-head.php");
				    require_once(VIEWS_PATH . "admin-header.php");
                    require_once(VIEWS_PATH . "admin-movie-add.php");
                }
			} else {
                return $this->userPath();
            }
        }        

        /*
        public function add($idMovie) {
            $movie = new Movie();
            $movie->setId($idMovie);
            
            $movieDetails = $this->movieDAO->getMovieDetails($movie);         

        }
        */
        
    }

 ?>