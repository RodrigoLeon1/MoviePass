<?php

    namespace Controllers;

    use DAO\ShowDAO as ShowDAO;
    use Models\Show as Show;
    use DAO\CinemaDAO as CinemaDAO;
    use Models\Cinema as Cinema;
    use DAO\MovieDAO as MovieDAO;
    use Models\Movie as Movie;

    class ShowController {

        private $showDAO;
        private $cinemaDAO;
        private $movieDAO;

        public function __construct() {
            $this->showDAO = new ShowDAO();
            $this->cinemaDAO = new CinemaDAO();
            $this->movieDAO = new MovieDAO();
        }

        public function add($id_cinema, $id_movie, $date, $time) {
			if($this->validateShowForm($id_cinema, $id_movie, $date, $time)) {				
				$movie = new Movie ();
				$movie->setId($id_movie);
				$cinema = new Cinema();
				$cinema->setId($id_cinema);
				$show = new Show();
				$show->setDateStart($date);
				$show->setTimeStart($time);
				$show->setMovie($movie);
				$show->setCinema($cinema);
				if ($this->checkTime($show)) {
					$this->showDAO->add($show);
					return $this->addShowPath(NULL, SHOW_ADDED, $id_cinema, $id_movie, $date, $time);
				}
				return $this->addShowPath(SHOW_ERROR, NULL, $id_cinema, $id_movie, $date, $time); 
			}
			return $this->addShowPath(EMPTY_FIELDS, $id_cinema, $id_movie, $date, $time);
        }

		public function checkTime (Show $show) {
			$existance = $this->showDAO->getByCinemaId($show); // Get Shows That Belong To That Particular Cinema
			$this->appendTime ($show);
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
			$movie = $this->movieDAO->getById($show->getMovie()->getId()); // Get Movie On Show In Order To Get It's Runtime
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
							return 0;
						}
					}
				}
			}
			return 1;
		}

        private function validateShowForm($id_cinema, $id_movie, $day, $hour) {
            if(empty($id_cinema) || empty($id_movie) || empty($day) || empty($hour)) {
                return FALSE;
            }
            return TRUE;
        }

        public function addShowPath($alert = "", $success = "", $id_cinema="", $id_movie="", $showDate="", $time="") {
            if ($_SESSION["loggedUser"]) {
				$admin = $_SESSION["loggedUser"];
				if($admin->getRole() == 1) {
					$movies = $this->movieDAO->getAll();
					$cinemas = $this->cinemaDAO->getAll();

					
					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-show-add.php");
				}
			}
		}
		

		public function checkParameters($id_cinema, $id_movie, $date, $time)
		{
			if(empty($id_cinema) || empty($id_movie) || empty($date) || empty($time))
			{
				return FALSE;
			}else
			{
				return TRUE;
			}
		}

		public function listShowsPath($success = "") {
			if ($_SESSION["loggedUser"]) {
				$admin = $_SESSION["loggedUser"];
				if($admin->getRole() == 1) {
					$shows = $this->showDAO->getAll();
					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-show-list.php");
				}
			}
		}

		public function remove($id) {
			$this->showDAO->deleteById($id);
			return $this->listShowsPath(SHOW_REMOVE);
		}

		public function getById($id) {
			if ($_SESSION["loggedUser"]) {
				$admin = $_SESSION["loggedUser"];
				if($admin->getRole() == 1) {
					$show = $this->showDAO->getById($id);
					$movies = $this->movieDAO->getAll();
					$cinemas = $this->cinemaDAO->getAll();
					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-show-modify.php");
				}
			}
		}

		public function getShowById($id) {
			// $show = new Show();
			// $show->setId($id);
			$show = $this->showDAO->getById($id);					
			return $show;							
		}

		public function modify($id, $id_cinema, $id_movie, $date, $time) {
			$movie = new Movie ();
			$movie->setId($id_cinema);
			$cinema = new Cinema ();
			$cinema->setId ($id_cinema);
			$show = new Show();
			$show->setId($id);
			$show->setDateStart($date);
			$show->setTimeStart($time);
			$show->setMovie($movie);
			$show->setCinema($cinema);
			$this->showDAO->modify($show);
			return $this->listShowsPath();
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
