<?php

    namespace Controllers;

    use DAO\CinemaDAO as cinemaDAO;
    use Models\Cinema as Cinema;

    class CinemaController {
        private $cinemaDAO;
		private $cinemas;

        public function __construct() {
            $this->cinemaDAO = new CinemaDAO();
        }

        public function add($name, $capacity, $address, $price) {
			if($this->validateCinemaForm($name, $capacity, $address, $price)) {
				$cinema = new Cinema();            
				$cinema->setName($name);
				if($this->cinemaDAO->getByName($cinema) == NULL) {
					$cinema = new Cinema();
					$cinema->setName($name);
					$cinema->setCapacity($capacity);
					$cinema->setAddress($address);
					$cinema->setPrice($price);
					$this->cinemaDAO->add($cinema);
					return $this->addCinemaPath(CINEMA_ADDED, NULL);
				}
				return $this->addCinemaPath(NULL, CINEMA_EXIST);
			}
			return $this->addCinemaPath(NULL, EMPTY_FIELDS);
		}
		
        private function validateCinemaForm($name, $capacity, $address, $price) {
            if(empty($name) || empty($capacity) || empty($address) || empty($price)) {
                return FALSE;
            }
            return TRUE;
        }		

        public function addCinemaPath($success = "", $alert = "") {
			if ($_SESSION["loggedUser"]) {
				$admin = $_SESSION["loggedUser"];
				if($admin->getRole() == 1) {
					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-cinema-add.php");
				}				
			}
        }

		public function listCinemaPath($success = "") {
			if ($_SESSION["loggedUser"]) {
				$admin = $_SESSION["loggedUser"];				
				$this->cinemas = $this->cinemaDAO->getAll();
				if($admin->getRole() == 1) {
					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-cinema-list.php");
				}
			}
        }

		public function remove($id) {			
			$this->cinemaDAO->deleteById($id);
			return $this->listCinemaPath(CINEMA_REMOVE);
		}

		public function getById($id) {
			$cinema = $this->cinemaDAO->getById($id);
			if ($_SESSION["loggedUser"]) {
				$admin = $_SESSION["loggedUser"];
				if($admin->getRole() == 1) {
					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-cinema-modify.php");
				}
			}
		}

		public function modify($id, $name, $capacity, $address, $price) {			
			$cinema = new Cinema();
            $cinema->setId($id);
            $cinema->setName($name);
            $cinema->setCapacity($capacity);
			$cinema->setAddress($address);
            $cinema->setPrice($price);
	        $this->cinemaDAO->modify($cinema);
            return $this->listCinemaPath(CINEMA_MODIFY);
        }

    }

 ?>
