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

        public function add($name, $address, $capacity, $price) {
            $cinema = new Cinema();            
            $cinema->setName($name);
            $cinema->setAddress($address);
            $cinema->setCapacity($capacity);
            $cinema->setPrice($price);
            $this->cinemaDAO->add($cinema);
            $this->addCinemaPath();
        }

        public function list() {
			$this->cinemas = $this->cinemaDAO->getAll();
			$this->listCinemaPath();
        }

        public function addCinemaPath () {
			if ($_SESSION["loggedUser"]) {
				$admin = $_SESSION["loggedUser"];
				require_once(VIEWS_PATH . "admin-head.php");
				require_once(VIEWS_PATH . "admin-header.php");
				require_once(VIEWS_PATH . "admin-add-cinema.php");
			}
        }

		public function listCinemaPath () {
			if ($_SESSION["loggedUser"]) {
				$admin = $_SESSION["loggedUser"];
				require_once(VIEWS_PATH . "admin-head.php");
				require_once(VIEWS_PATH . "admin-header.php");
				require_once(VIEWS_PATH . "admin-cinema-list.php");
			}
        }

        // En lugar de recibir el ID debe recibir un objeto de tipo CINEMA
		public function remove($id) {
			$this->cinemaDAO->remove($id);
			$this->list();
		}
    }

 ?>
