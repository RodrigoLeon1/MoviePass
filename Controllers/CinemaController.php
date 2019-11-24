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
			if ($this->validateCinemaForm($name, $address)) {
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
		
        private function validateCinemaForm($name, $address) {
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
				}				
			} else {
                $userController = new UserController();
                return $userController->userPath();
            }
        }

		public function listCinemaPath($success = "", $alert = "", $cinemaId = "") {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];				
				if ($admin->getRole() == 1) {
					$cinemas = $this->cinemaDAO->getAll();
					if ($cinemas != null) {
						require_once(VIEWS_PATH . "admin-head.php");
						require_once(VIEWS_PATH . "admin-header.php");
						require_once(VIEWS_PATH . "admin-cinema-list.php");
					} else {
						$userController = new UserController();
                		return $userController->adminPath();
					}
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
			if ($this->cinemaHasShows($id)) {				
				return $this->listCinemaPath(null, CINEMA_HAS_SHOWS, $id);
			} else {				
				$cinema = new Cinema();
				$cinema->setId($id);				
				if ($this->cinemaDAO->deleteById($cinema)){
					return $this->listCinemaPath(CINEMA_REMOVE, null, null);
				}
				return $this->listCinemaPath(null, DB_ERROR, null);
			}
		}

		// arreglar- solo borrado logico
		public function forceDelete($id) {
			$cinema = new Cinema();
			$cinema->setId($id);
			$this->cinemaDAO->deleteById($cinema);

			return $this->listCinemaPath(CINEMA_REMOVE, null, null);
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
					if ($cinema != null) {
						require_once(VIEWS_PATH . "admin-head.php");
						require_once(VIEWS_PATH . "admin-header.php");
						require_once(VIEWS_PATH . "admin-cinema-modify.php");
					} else {
						return $this->listCinemaPath(null, DB_ERROR, null);
					}
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
	        if ($this->cinemaDAO->modify($cinema)){
				return $this->listCinemaPath(CINEMA_MODIFY, null, null);
			}
			return $this->listCinemaPath(null, DB_ERROR, null);
        }

		public function sales() {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if ($admin->getRole() == 1) {
					$cinemas = $this->cinemaDAO->getAll();
					if ($cinemas != null) {
						require_once(VIEWS_PATH . "admin-head.php");
						require_once(VIEWS_PATH . "admin-header.php");
						require_once(VIEWS_PATH . "admin-cinema-sales.php");
					} else {
						$userController = new UserController();
                		return $userController->adminPath();
					}
				}
			} else {
                $userController = new UserController();
                return $userController->userPath();
            }
		}

    }

 ?>
