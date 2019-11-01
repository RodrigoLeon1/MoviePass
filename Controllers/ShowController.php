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
				//Validaciones aca
				$movie = new Movie ();
				$movie->setId($id_movie);
				$cinema = new Cinema();
				$cinema->setId($id_cinema);
				$show = new Show();
				$show->setDateStart($date);
				$show->setTimeStart($time);
				$show->setMovie($movie);
				$show->setCinema($cinema);
				$this->showDAO->add($show);
				return $this->addShowPath(NULL, SHOW_ADDED);

			}
			return $this->addShowPath(EMPTY_FIELDS);
        }

        private function validateShowForm($id_cinema, $id_movie, $day, $hour) {
            if(empty($id_cinema) || empty($id_movie) || empty($day) || empty($hour)) {
                return FALSE;
            }
            return true;
        }

        public function addShowPath($alert = "", $success = "") {
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

		public function listShowsPath() {
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
			return $this->listShowsPath();
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

    }

?>
