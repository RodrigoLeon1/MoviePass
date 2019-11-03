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

		public function nowPlaying($movies = "", $title = "") {
            $genreController = new GenreToMovieController();
            $genres = $genreController->getAllGenres();            
            
            if($movies == NULL) {
                $movies = $this->moviesNowPlayingOnShow();            
            }

            if($title == NULL) {
                $title = 'Now Playing';
            }

            $img = IMG_PATH . '/w4.png';
            
			require_once(VIEWS_PATH . "header.php");
			require_once(VIEWS_PATH . "navbar.php");
			require_once(VIEWS_PATH . "header-s.php");
			require_once(VIEWS_PATH . "now-playing.php");
			require_once(VIEWS_PATH . "footer.php");
		}
        
        public function filterMovies($id = "", $date = "") {            
            
            $img = IMG_PATH . '/w4.png';   
            $genreMovieController = new GenreToMovieController();            
            $genres = $genreMovieController->getAllGenres();                        

            if(!empty($id) && empty($date)) {                
                //Filtramos solo por genero
                $nameGenre = $genreMovieController->getNameOfGenre($id);   
                $title = 'Now Playing - ' . $nameGenre;         
                $movies = $genreMovieController->searchMoviesOnShowByGenre($id);                  
                return $this->nowPlaying($movies, $title);

            } else if (!empty($date) && empty($id)) {                
                //Filtramos solo por fecha                
                $movies = $genreMovieController->searchMoviesOnShowByDate($date); 
                return $this->nowPlaying($movies);

            } else if (!empty($id) && !empty($date)) {
                //Filtramos por genero y fecha
                $nameGenre = $genreMovieController->getNameOfGenre($id);            
                $title = 'Now Playing - ' . $nameGenre;
                $movies = $genreMovieController->searchMoviesOnShowByGenreAndDate($id, $date);                  
                return $this->nowPlaying($movies, $title);
                
            } else {                
                return $this->nowPlaying();
            }
            
        } 
        
        /* 
        public function filterMovies2($id = "", $date = "") {
            $genreMovieController = new GenreToMovieController();
            $genres = $genreMovieController->getAllGenres();

            if(substr($id, 4, 1) == '-') {
                $date = $id;
                // echo ' filtrar por fecha';
                $title = 'Now Playing';
                $movies = $genreMovieController->searchMoviesOnShowByDate($date); 
            } else {
                if(!empty($id) && empty($date)) {
                    // echo ' filtrar por id';
                    $nameGenre = $genreMovieController->getNameOfGenre($id);
                    $title = 'Now Playing - ' . $nameGenre;
                    $movies = $genreMovieController->searchMoviesOnShowByGenre($id);
                } else if (!empty($id) && !empty($date)) {
                    // echo ' filtrar por id y fecha';
                    $nameGenre = $genreMovieController->getNameOfGenre($id);
                    $title = 'Now Playing - ' . $nameGenre;
                    $movies = $genreMovieController->searchMoviesOnShowByGenreAndDate($id, $date);
                } else {
                    return $this->nowPlaying();
                }
            }

            $img = IMG_PATH . '/w4.png';
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "navbar.php");
            require_once(VIEWS_PATH . "header-s.php");
            require_once(VIEWS_PATH . "now-playing.php");
            require_once(VIEWS_PATH . "footer.php");
        }*/

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