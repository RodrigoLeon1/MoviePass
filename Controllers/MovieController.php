<?php

    namespace Controllers;

    use Models\Movie as Movie;    
    use DAO\MovieDAO as MovieDAO;
    use Controllers\GenreToMovieController as GenreToMovieController;
    use Controllers\ShowController as ShowController;
    use Controllers\PurchaseController as PurchaseController;
    use Controllers\UserController as UserController;   

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

        public function moviesUpcoming() {
            return $this->movieDAO->getComingSoonMovies();
        }

        public function showMovie($id) {
            $movies = $this->moviesNowPlayingOnShow();              
            $genreMovieController = new GenreToMovieController();    
            $purchaseController = new PurchaseController();
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

		public function nowPlaying($movies = "", $title = "", $alert = "") {            
            $genreController = new GenreToMovieController();            
            $genres = $genreController->getGenresOfMoviesOnShows();            
            $img = IMG_PATH . '/w4.png';
                        
            if($movies == NULL && $alert == NULL) {
                $movies = $this->moviesNowPlayingOnShow();            
            }
            if($title == NULL) {
                $title = 'Now Playing';
            }
            
			require_once(VIEWS_PATH . "header.php");
			require_once(VIEWS_PATH . "navbar.php");
			require_once(VIEWS_PATH . "header-s.php");
			require_once(VIEWS_PATH . "now-playing.php");
			require_once(VIEWS_PATH . "footer.php");
		}
        
        public function filterMovies($id = "", $date = "") {                        
            $genreMovieController = new GenreToMovieController();            
            $genres = $genreMovieController->getAllGenres();            
            $img = IMG_PATH . '/w4.png';   

            if(!empty($id) && empty($date)) {                                
                //Filtramos solo por genero
                $nameGenre = $genreMovieController->getNameOfGenre($id);                   
                $title = 'Now Playing - ' . $nameGenre;         
                $movies = $genreMovieController->searchMoviesOnShowByGenre($id); 

                return (!empty($movies)) ? $this->nowPlaying($movies, $title) : $this->nowPlaying($movies, $title, MOVIES_NULL);

            } else if (!empty($date) && empty($id)) {                                
                //Filtramos solo por fecha                
                $movies = $genreMovieController->searchMoviesOnShowByDate($date);
                $title = 'Now Playing - ' . $date; 

                return (!empty($movies)) ? $this->nowPlaying($movies, $title) : $this->nowPlaying($movies, $title, MOVIES_NULL);

            } else if (!empty($id) && !empty($date)) {                
                //Filtramos por genero y fecha
                $nameGenre = $genreMovieController->getNameOfGenre($id);            
                $title = 'Now Playing - ' . $nameGenre . ' - ' . $date;
                $movies = $genreMovieController->searchMoviesOnShowByGenreAndDate($id, $date);  
                                                       
                return (!empty($movies)) ? $this->nowPlaying($movies, $title) : $this->nowPlaying($movies, $title, MOVIES_NULL);
                
            } else {                                
                return $this->nowPlaying();
            }            
        } 

		public function comingSoon() {
			$title = 'Coming Soon';
            $img = IMG_PATH . '/w5.png';

            $movies = $this->moviesUpcoming();
            
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
                $userController = new UserController();
                return $userController->userPath();
            }
        }        
        
        public function add($id) {
            $movie = new Movie();
            $movie->setId($id);                        
            if($this->movieDAO->existMovie($movie) == NULL) {         
            // if($this->movieDAO->getById($movie) == NULL) {
                $movieDetails = $this->movieDAO->getMovieDetailsById($movie);         
                $this->movieDAO->addMovie($movieDetails);   
                
                $genreMovieController = new GenreToMovieController();    
                $genreMovieController->addGenresBD($movieDetails);                
                
                return $this->addMoviePath(NULL, MOVIE_ADDED);                                    
            }            
            return $this->addMoviePath(MOVIE_EXIST, NULL);
        }        

        public function remove($id) {
            if($this->movieHasShows($id)) {
                return $this->listMoviePath(NULL, MOVIE_HAS_SHOWS, $id);
            } else {
                $movie = new Movie();
                $movie->setId($id);
                $this->movieDAO->deleteById($movie);
                return $this->listMoviePath(MOVIE_REMOVE, NULL, NULL);
            }
        }

		public function forceDelete($id) {
            $movie = new Movie();
            $movie->setId($id);
			$this->movieDAO->deleteById($movie);
			return $this->listMoviePath(MOVIE_REMOVE, NULL, NULL);
		}        
        
        private function movieHasShows($id) {
			$movie = new Movie();
			$movie->setId($id);

			return ($this->movieDAO->getShowsOfMovie($movie)) ? TRUE : FALSE;
		}
        
        public function listMoviePath($success = "", $alert = "", $movieId = "") {
			if (isset($_SESSION["loggedUser"])) {
                $admin = $_SESSION["loggedUser"];
                if($admin->getRole() == 1) {
                    $movies = $this->movieDAO->getAll();
				    require_once(VIEWS_PATH . "admin-head.php");
				    require_once(VIEWS_PATH . "admin-header.php");
                    require_once(VIEWS_PATH . "admin-movie-list.php");
                }
			} else {
                $userController = new UserController();
                return $userController->userPath();
            }            
        }         

        public function searchMovie($title) {            
            $movieTemp = new Movie();
            $movieTemp->setTitle($title);            
           
            $movie = $this->movieDAO->getByTitle($movieTemp);

            if($movie->getId() == NULL) {
                return $this->nowPlaying($movie, MOVIES_NULL , MOVIES_NULL);
            } else {
                return $this->showMovie($movie->getId());
            }
        }
    
        public function sales() {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if($admin->getRole() == 1) {

                    $movies = $this->moviesNowPlayingOnShow();

					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-movie-sales.php");
				}
			} else {
                $userController = new UserController();
                return $userController->userPath();
            } 
        }
        
        public function getMovieById(Movie $movie) {            
            return $this->movieDAO->getById($movie);
        }

    }

 ?>