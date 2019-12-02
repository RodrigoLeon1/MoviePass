<?php

    namespace Controllers;

	use Models\Movie as Movie;
    use Models\CinemaRoom as CinemaRoom;
    use Models\Show as Show;
    use DAO\ShowDAO as ShowDAO;	
	use Controllers\CinemaController as CinemaController;
	use Controllers\CinemaRoomController as CinemaRoomController;
	use Controllers\MovieController as MovieController;
	use Controllers\UserController as UserController;   
	use Controllers\ViewsRouterController as ViewsRouter;  
	
    class ShowController extends ViewsRouter {

        private $showDAO;
		private $cinemaRoomDAO;		
        private $movieDAO;

        public function __construct() {
            $this->showDAO = new ShowDAO();            
        }

        public function add($id_cinemaRoom, $id_movie, $date, $time) {
			if ($this->isFormNotEmpty($id_cinemaRoom, $id_movie, $date, $time)) {					
				if ($this->validateDate($date)) {
					$movie = new Movie();
					$movie->setId($id_movie);
	
					$cinemaRoomController = new CinemaRoomController();
					$cinemaRoom = $cinemaRoomController->getCinemaRoomById($id_cinemaRoom);				
					
					$show = new Show();
					$show->setDateStart($date);
					$show->setTimeStart($time);
					$show->setMovie($movie);
					$show->setCinemaRoom($cinemaRoom);
					
					if ($this->checkTime($show)) {
						if ($this->showDAO->add($show)) {
							return $this->addShowPath(null, SHOW_ADDED, $id_cinemaRoom, $id_movie, $date, $time);
						}
						return $this-addShowPath(DB_ERROR, null, $id_cinemaRoom, $id_movie, $date, $time);
					}
					return $this->addShowPath(SHOW_ERROR, null, $id_cinemaRoom, $id_movie, $date, $time); 
				}
				return $this->addShowPath(SHOW_CHECK_DAY, null, null, null, null, null);				
			}
			return $this->addShowPath(EMPTY_FIELDS, $id_cinemaRoom, $id_movie, $date, $time);
        }

		// solo una sala puede tener la pelicula
		public function checkTime (Show $show) {
			$existance = $this->showDAO->getByCinemaRoomId($show);  // Get Shows That Belong To That Particular Cinema
			$this->appendTime($show);
			$flag = 1;
			if ($existance != null) {
				foreach ($existance as $showsOnDB) {
					if ( ($showsOnDB["date_start"] == $show->getDateStart()) ) {
						if ( ($showsOnDB["time_start"] > $show->getTimeStart()) && ($showsOnDB["time_start"] > $show->getTimeEnd()) ) {
							$flag *= 1;
						}
						else if ( ($showsOnDB["time_end"] < $show->getTimeStart()) && ($showsOnDB["time_end"] < $show->getTimeEnd()) ) {
							$flag *= 1;
						}
						else {
							$flag *= 0;
						}
					}
				}
			}
			else if ($existance == null) {
				$flag *= $this->checkPlace($show);
			}
			return $flag;
		}

		public function appendTime ($show) {
			
			// $movie = $this->movieDAO->getById($show->getMovie()->getId()); // Get Movie On Show In Order To Get It's Runtime
			// $movie = $this->movieDAO->getById($show->getMovie());
			
			$movieController = new MovieController();
			$movie = $movieController->getMovieById($show->getMovie());

			//Modify Time Lapse
			//$timeStart = strtotime ("-15 minutes", strtotime($show->getDateStart() . $show->getTimeStart()));
			$plusRunTime = "+" . $movie->getRuntime() . " minutes";
			$timeEnd = strtotime ($plusRunTime, strtotime($show->getDateStart() . $show->getTimeStart()));
			$timeEnd += strtotime ("+15 minutes", strtotime($timeEnd));
			// Assign time to paramenters
			// $show->setDateStart(date ('Y-m-d', $timeStart));
			// $show->setTimeStart(date ('H:i:s', $timeStart));
			$show->setDateEnd(date ('Y-m-d', $timeEnd));
			$show->setTimeEnd(date ('H:i:s', $timeEnd));
		}

		public function checkPlace (Show $show) {
            $shows = $this->showDAO->getAll();
            if ($shows != null) {
                foreach ($shows as $showList) {
                    if ($showList->getMovie()->getId() == $show->getMovie()->getId()) {
                        if ($showList->getDateStart() == $show->getDateStart()) {
                            if ($showList->getCinemaRoom()->getCinema()->getId() != $show->getCinemaRoom()->getCinema()->getId()){
                                return 0;
                            }
                        }
                    }
                }
            }
            return 1;
        }

        private function isFormNotEmpty($id_cinemaRoom, $id_movie, $day, $hour) {
            if (empty($id_cinemaRoom) || empty($id_movie) || empty($day) || empty($hour)) {
                return false;
            }
            return true;
		}
		
		// The date of the show cant be the same date of today
		private function validateDate($date) {
			$today = date('Y-m-d');
			return (strtotime($today) == strtotime($date)) ? false : true;
		}

        public function addShowPath($alert = "", $success = "", $id_cinemaRoom="", $id_movie="", $showDate="", $time="") {
            if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if ($admin->getRole() == 1) {

					$cinemas = new CinemaController();
					$cinemas = $cinemas->getAllCinemasActives();					

					$movieController = new MovieController();
					$movies = $movieController->moviesNowPlaying();		

					$cinemaRoomController = new CinemaRoomController();					
					$cinemaRooms = $cinemaRoomController->getAllCinemaRooms();

					if ($cinemas && $movies && $cinemaRooms) {
						require_once(VIEWS_PATH . "admin-head.php");
						require_once(VIEWS_PATH . "admin-header.php");
						require_once(VIEWS_PATH . "admin-show-add.php");
					} else {
						return $this->goToAdminPath();	
					}
				} else {
					return $this->goToUserPath();
				}
			} else {
				return $this->goToUserPath();
            } 
		}
		
		public function checkParameters($id_cinemaRoom, $id_movie, $date, $time) {
			if (empty($id_cinemaRoom) || empty($id_movie) || empty($date) || empty($time)) {
				return false;
			}
			return true;			
		}

		public function listShowsPath($success = "", $alert = "") {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if ($admin->getRole() == 1) {
					$shows = $this->showDAO->getAll();
					if ($shows) {
						require_once(VIEWS_PATH . "admin-head.php");
						require_once(VIEWS_PATH . "admin-header.php");
						require_once(VIEWS_PATH . "admin-show-list.php");
					} else {
						return $this->goToAdminPath();
					}
				} else {
					return $this->goToUserPath();
				}
			} else {
				return $this->goToUserPath();
            } 
		}

		public function enable($id) {
			$show = new Show();
			$show->setId($id);
			if ($this->showDAO->enableById($show)) {
				return $this->listShowsPath(SHOW_ENABLE, null);
			} else {
				return $this->listShowsPath(null, DB_ERROR);
			}
		}
		
		public function disable($id) {
			$show = new Show();
			$show->setId($id);
			if ($this->showDAO->disableById($show)) {
				return $this->listShowsPath(SHOW_DISABLE, null);
			}
			return $this->listShowsPath(null, DB_ERROR);
		}		

		//
		public function getShowById($id) {
			$showTemp = new Show();
			$showTemp->setId($id);
			$show = $this->showDAO->getById($showTemp);					
			return $show;							
		}

		public function moviesOnShow() {
			return $this->showDAO->moviesOnShow();
		}

		public function getShowsOfMovieById($id) {
			$movie = new Movie();
			$movie->setId($id);
			return $this->showDAO->getShowsOfMovie($movie);
		}	
				
    }

?>
