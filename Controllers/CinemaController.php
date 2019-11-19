<?php

    namespace Controllers;

    use DAO\CinemaDAO as cinemaDAO;
	use Models\Cinema as Cinema;
	use Controllers\UserController as UserController;   

    class CinemaController {
        
        private $cinemaDAO;		

        public function __construct() {
            $this->cinemaDAO = new CinemaDAO();
		}			

        public function add($name, $address) {
			if($this->validateCinemaForm($name, $address)) {
				$cinema = new Cinema();            
				$cinema->setName($name);
				if($this->cinemaDAO->getByName($cinema) == NULL) {
					$cinema = new Cinema();
					$cinema->setName($name);					
					$cinema->setAddress($address);
					$this->cinemaDAO->add($cinema);
					return $this->addCinemaPath(CINEMA_ADDED, NULL);
				}
				return $this->addCinemaPath(NULL, CINEMA_EXIST);
			}
			return $this->addCinemaPath(NULL, EMPTY_FIELDS);
		}
		
        private function validateCinemaForm($name, $address) {
            if(empty($name) || empty($address)) {
                return FALSE;
            }
            return TRUE;
        }		

        public function addCinemaPath($success = "", $alert = "") {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if($admin->getRole() == 1) {
					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-cinema-add.php");
				}				
			} else {
                $userController = new UserController();
                return $userController->userPath();
            }
        }

		public function listCinemaPath($success = "", $alert = "", $cinemaId = "") {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];				
				$cinemas = $this->cinemaDAO->getAll();
				if($admin->getRole() == 1) {
					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-cinema-list.php");
				}
			} else {
                $userController = new UserController();
                return $userController->userPath();
            }
        }

		public function getAllCinemas() {
			return $this->cinemaDAO->getAll();
		}

		public function remove($id) {	
			if($this->cinemaHasShows($id)) {				
				return $this->listCinemaPath(NULL, CINEMA_HAS_SHOWS, $id);
			} else {
				
				$cinema = new Cinema();
				$cinema->setId($id);
				$this->cinemaDAO->deleteById($cinema);

				return $this->listCinemaPath(CINEMA_REMOVE, NULL, NULL);
			}
		}

		public function forceDelete($id) {
			$cinema = new Cinema();
			$cinema->setId($id);
			$this->cinemaDAO->deleteById($cinema);

			return $this->listCinemaPath(CINEMA_REMOVE, NULL, NULL);
		}

		private function cinemaHasShows($id) {
			$cinema = new Cinema();
			$cinema->setId($id);

			return ($this->cinemaDAO->getShowsOfCinema($cinema)) ? TRUE : FALSE;
		}

		public function modifyById($id) {			
			$cinemaAux = new Cinema();
			$cinemaAux->setId($id);

			$cinema = $this->cinemaDAO->getById($cinemaAux);
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if($admin->getRole() == 1) {
					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-cinema-modify.php");
				}
			} else {
                $userController = new UserController();
                return $userController->userPath();
            }
		}

		public function modify($id, $name, $address) {			
            $cinema = new Cinema();
            $cinema->setId($id);
            $cinema->setName($name);            
            $cinema->setAddress($address);
	        $this->cinemaDAO->modify($cinema);
            return $this->listCinemaPath(CINEMA_MODIFY);
        }

		public function sales() {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if($admin->getRole() == 1) {

					$cinemas = $this->cinemaDAO->getAll();
					
					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-cinema-sales.php");
				}
			} else {
                $userController = new UserController();
                return $userController->userPath();
            }
		}

    }

 ?>
