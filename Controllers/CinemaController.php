<?php

    namespace Controllers;

	use Models\Cinema as Cinema;
    use DAO\CinemaDAO as cinemaDAO;
	use Controllers\UserController as UserController;   	  

    class CinemaController {
        
        private $cinemaDAO;		

        public function __construct() {
			$this->cinemaDAO = new CinemaDAO();
			$this->userController = new UserController();
		}			

        public function add($name, $address) {
			if ($this->isFormNotEmpty($name, $address)) { 
				$cinema = new Cinema();            
				$cinema->setName($name);
				if ($this->cinemaDAO->getByName($cinema) == null) {
					$cinema = new Cinema();
					$cinema->setName($name);					
					$cinema->setAddress($address);
					if ($this->cinemaDAO->add($cinema)) {
						return $this->addCinemaPath(CINEMA_ADDED, null);
					}
					return $this->addCinemaPath(null, DB_ERROR);
				}
				return $this->addCinemaPath(null, CINEMA_EXIST);
			}
			return $this->addCinemaPath(null, EMPTY_FIELDS);
		}
		
        private function isFormNotEmpty($name, $address) {
            if (empty($name) || empty($address)) {
                return false;
            }
            return true;
        }		

        public function addCinemaPath($success = "", $alert = "") {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if ($admin->getRole() == 1) {
					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-cinema-add.php");
				} else {	
					return $this->userController->userPath();
				}				
			} else {
				return $this->userController->userPath();
            }
        }

		public function listCinemaPath($all = false, $success = "", $alert = "", $cinemaId = "") {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];				
				if ($admin->getRole() == 1) {
					$cinemas = $all ? $this->cinemaDAO->getAll() : $this->cinemaDAO->getAllActives();
					if ($cinemas) {
						require_once(VIEWS_PATH . "admin-head.php");
						require_once(VIEWS_PATH . "admin-header.php");
						require_once(VIEWS_PATH . "admin-cinema-list.php");
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

		public function enable($id) {
			$cinema = new Cinema();
			$cinema->setId($id);
			if ($this->cinemaDAO->enableById($cinema)) {
				return $this->listCinemaPath(null, CINEMA_ENABLE, null, null);
			} else {
				return $this->listCinemaPath(null, null, DB_ERROR, null);
			}
		}

		public function disable($id) {	
			if ($this->cinemaHasShows($id)) {				
				return $this->listCinemaPath(null, null, CINEMA_HAS_SHOWS, $id);
			} else {				
				$cinema = new Cinema();
				$cinema->setId($id);				
				if ($this->cinemaDAO->disableById($cinema)){
					return $this->listCinemaPath(null, CINEMA_DISABLE, null, null);
				}
				return $this->listCinemaPath(null, null, DB_ERROR, null);
			}
		}				

		public function forceDisable($id) {
			$cinema = new Cinema();
			$cinema->setId($id);
			if ($this->cinemaDAO->disableById($cinema)) {
				return $this->listCinemaPath(null, CINEMA_DISABLE, null, null);
			}			
		}

		private function cinemaHasShows($id) {
			$cinema = new Cinema();
			$cinema->setId($id);
			return ($this->cinemaDAO->getShowsOfCinema($cinema)) ? true : false;
		}

		public function modifyById($id) {			
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if ($admin->getRole() == 1) {
					$cinemaAux = new Cinema();
					$cinemaAux->setId($id);
					$cinema = $this->cinemaDAO->getById($cinemaAux);
					if ($cinema) {
						require_once(VIEWS_PATH . "admin-head.php");
						require_once(VIEWS_PATH . "admin-header.php");
						require_once(VIEWS_PATH . "admin-cinema-modify.php");
					} else {
						return $this->listCinemaPath(null, null, DB_ERROR, null);
					}
				} else {
					return $this->userController->userPath();
				}
			} else {
				return $this->userController->userPath();
            }
		}

		public function modify($id, $name, $address) {			
            $cinema = new Cinema();
            $cinema->setId($id);
            $cinema->setName($name);            
            $cinema->setAddress($address);
	        if ($this->cinemaDAO->modify($cinema)){
				return $this->listCinemaPath(null, CINEMA_MODIFY, null, null);
			}
			return $this->listCinemaPath(null, null, DB_ERROR, null);
        }

		public function sales() {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if ($admin->getRole() == 1) {
					$cinemas = $this->cinemaDAO->getAll();
					if ($cinemas) {
						require_once(VIEWS_PATH . "admin-head.php");
						require_once(VIEWS_PATH . "admin-header.php");
						require_once(VIEWS_PATH . "admin-cinema-sales.php");
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
		public function getAllCinemasActives() {
			return $this->cinemaDAO->getAllActives();
		}

    }

 ?>
