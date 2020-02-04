<?php

    namespace Controllers;

    use Models\Movie as Movie;    
    use DAO\MovieDAO as MovieDAO;
    use Controllers\UserController as UserController;   
    use Controllers\ShowController as ShowController;
    use Controllers\PurchaseController as PurchaseController;
    use Controllers\GenreToMovieController as GenreToMovieController;

    class MovieController {

        private $movieDAO;
		private $showController;

        public function __construct() {
            $this->movieDAO = new MovieDAO();
            $this->showController = new ShowController();
            $this->userController = new UserController();
        }

        public function moviesNowPlaying() {
            return $this->movieDAO->getAllActives();
        }

		public function moviesNowPlayingOnShow() {
            return $this->showController->moviesOnShow();
        }

        public function moviesUpcoming() {
            return $this->movieDAO->getComingSoonMovies();
        }

        public function showMovie($id) {                              
            $genreMovieController = new GenreToMovieController();    
            $purchaseController = new PurchaseController();            
            $movieTemp = new Movie();
            $movieTemp->setId($id);
            $movie = $this->movieDAO->getById($movieTemp);
            if ($movie->getTitle() != null) {
                $title = $movie->getTitle();
                $img = IMG_PATH_TMDB . $movie->getBackdropPath();
                $keyTrailer = $this->movieDAO->getKeyMovieTrailer($movie);     
                $shows = $this->showController->getShowsOfMovieById($id);
                $genres = $genreMovieController->getGenresOfMovie($movie); 
                require_once(VIEWS_PATH . "header.php");
                require_once(VIEWS_PATH . "header-s.php");
                require_once(VIEWS_PATH . "navbar.php");
                require_once(VIEWS_PATH . "datasheet.php");
                require_once(VIEWS_PATH . "footer.php");
            } else {
                return $this->nowPlaying();
            }
        }

        // Converts the runtime of a movie in minutes to hours and minutes
        private function minToHour($time, $format = '%2dhr %02dm') {
            if ($time < 1) {
                return;
            }
            $hours = floor($time / 60);
            $minutes = ($time % 60);
            return sprintf($format, $hours, $minutes);
        }

		public function nowPlaying($movies = "", $title = "", $alert = "") {            
            $genreController = new GenreToMovieController();            
            $genres = $genreController->getGenresOfMoviesOnShows();            
            $img = IMG_PATH . '/w4.png';
                        
            if ($movies == null && $alert == null) {
                $movies = $this->moviesNowPlayingOnShow();            
            }
            if ($title == null) {
                $title = 'Now Playing';
            }
            
			require_once(VIEWS_PATH . "header.php");
			require_once(VIEWS_PATH . "navbar.php");
			require_once(VIEWS_PATH . "header-s.php");
			require_once(VIEWS_PATH . "now-playing.php");
			require_once(VIEWS_PATH . "footer.php");
		}
                
        // fix
        public function filterMovies($id = "", $date = "") {                        
            $genreMovieController = new GenreToMovieController();            
            $genres = $genreMovieController->getAllGenres();            
            $img = IMG_PATH . '/w4.png';   

            if (!empty($id) && empty($date)) {                                
                //Filter by genre
                $nameGenre = $genreMovieController->getNameOfGenre($id);                   
                $title = 'Now Playing - ' . $nameGenre;         
                $movies = $genreMovieController->searchMoviesOnShowByGenre($id); 

                // echo '<pre>';
                // var_dump($movies);
                // echo '</pre>';
                
            } else if (!empty($date) && empty($id)) {                                                
                // Filter by date
                $title = 'Now Playing - ' . $date; 
                $movies = $genreMovieController->searchMoviesOnShowByDate($date);
                
                // echo '<pre>';
                // var_dump($movies);
                // echo '</pre>';
                
            } else if (!empty($id) && !empty($date)) {                                
                // Filter by genre and date
                $nameGenre = $genreMovieController->getNameOfGenre($id);            
                $title = 'Now Playing - ' . $nameGenre . ' - ' . $date;
                $movies = $genreMovieController->searchMoviesOnShowByGenreAndDate($id, $date);      
                
                // echo '<pre>';
                // var_dump($movies);
                // echo '</pre>';
                                                
            } else {                            
                return $this->nowPlaying();
            }    
             
            return (!empty($movies)) ? $this->nowPlaying($movies, $title) : $this->nowPlaying($movies, $title, MOVIES_NULL);        
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

        public function addMoviePath($alert = "", $success = "") {
			if (isset($_SESSION["loggedUser"])) {
                $admin = $_SESSION["loggedUser"];
                if ($admin->getRole() == 1) {
				    require_once(VIEWS_PATH . "admin-head.php");
				    require_once(VIEWS_PATH . "admin-header.php");
                    require_once(VIEWS_PATH . "admin-movie-add.php");
                } else {
                    return $this->userController->userPath();
                }
			} else {
                return $this->userController->userPath();
            }
        }        
        
        public function add($id) {
            $movie = new Movie();
            $movie->setId($id);                        
            if ($this->movieDAO->existMovie($movie) == null) {                                     
                $movieDetails = $this->movieDAO->getMovieDetailsById($movie);                  
                if ($this->movieDAO->addMovie($movieDetails)) {                    
                    $genreMovieController = new GenreToMovieController();   
                    if ($genreMovieController->addGenresBD($movieDetails)) {                        
                        return $this->addMoviePath(null, MOVIE_ADDED);                                    
                    } else {
                        // If the genres couldnt add , the movie will be remove
                        if ($this->movieDAO->deleteById($movieDetails)) {
                            return $this->addMoviePath(DB_ERROR, null);                   
                        } else {
                            return $this->addMoviePath();
                        }
                    }                   
                }                
            }                        
            return $this->addMoviePath(MOVIE_EXIST, null);
        }        

        public function enable($id) {
			$movie = new Movie();
			$movie->setId($id);
			if ($this->movieDAO->enableById($movie)) {
				return $this->listMoviePath(null, MOVIE_ENABLE, null, null);
			} else {
				return $this->listMoviePath(null, null, DB_ERROR, null);
			}
		}
        
        public function disable($id) {
            if ($this->movieHasShows($id)) {
                return $this->listMoviePath(null, null, MOVIE_HAS_SHOWS, $id);
            } else {
                $movie = new Movie();
                $movie->setId($id);
                if ($this->movieDAO->disableById($movie)) {
                    return $this->listMoviePath(null, MOVIE_DISABLE, null, null);
                }
                return $this->listMoviePath(null, null, DB_ERROR, null);
            }
        }

		public function forceDisable($id) {
            $movie = new Movie();
            $movie->setId($id);
            if ($this->movieDAO->disableById($movie)) {
                return $this->listMoviePath(null, MOVIE_DISABLE, null, null);
            }
            return $this->listMoviePath(null, null, DB_ERROR, null);
		}        
        
        private function movieHasShows($id) {
			$movie = new Movie();
			$movie->setId($id);
			return ($this->movieDAO->getShowsOfMovie($movie)) ? true : false;
		}
                
        public function listMoviePath($page = 1, $success = "", $alert = "", $movieId = "") {
			if (isset($_SESSION["loggedUser"])) {
                $admin = $_SESSION["loggedUser"];
                if ($admin->getRole() == 1) {

                    $moviesCount = $this->movieDAO->getCount();         
                    $pages = ceil($moviesCount / MAX_ITEMS_PAGE);  
                    // This variable will contain the number of the current page
                    $current = 0;                  

                    if ($page == 1) {                        
                        $movies = $this->movieDAO->getMoviesWithLimit(0);
                    } else {
                        $startFrom = ($page - 1) * MAX_ITEMS_PAGE;
                        $movies = $this->movieDAO->getMoviesWithLimit($startFrom);
                    }
                    
                    if ($movies) {
                        require_once(VIEWS_PATH . "admin-head.php");
                        require_once(VIEWS_PATH . "admin-header.php");
                        require_once(VIEWS_PATH . "admin-movie-list.php");
                    } else {
                        return $this->userController->adminPath();
                    }

                } else {
                    return $this->userController->userPath();
                }
			} else {
                return $this->userController->userPath();
            }            
        }         
        
        public function searchMovie($title) {            
            $movieTemp = new Movie();
            $movieTemp->setTitle($title);                       
            $movies = $this->movieDAO->getByTitle($movieTemp);

            if (!empty($title)) {                                
                if (count($movies) > 1) {
                    return $this->nowPlaying($movies, $title, null);
                } else if (count($movies) == 1) {                
                    return $this->showMovie($movies[0]->getId());
                } else {                
                    return $this->nowPlaying($movies, $title . ' - Not found' , MOVIES_NULL);
                }
            }
            return $this->nowPlaying();
        }
    
        public function sales() {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if ($admin->getRole() == 1) {
                    $movies = $this->moviesNowPlayingOnShow();
                    if ($movies) {                        
                        require_once(VIEWS_PATH . "admin-head.php");
                        require_once(VIEWS_PATH . "admin-header.php");
                        require_once(VIEWS_PATH . "admin-movie-sales.php");
                    } else {
                        return $this->userController->adminPath();
                    }
				} else {
                    return $this->userController->userPath();
                }
			} else {
                return $this->userController->userPath();
            } 
        }
        
        //
        public function getMovieById(Movie $movie) {            
            return $this->movieDAO->getById($movie);
        }

        public function getNowPlayingMoviesFromDAO() {
			$this->movieDAO->getNowPlayingMoviesFromDAO();
			$this->movieDAO->getRunTimeMovieFromDAO();
        }

    }

 ?>