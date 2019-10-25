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
            $cinema = new Cinema();
            $cinema->setName($name);
			$cinema->setCapacity($capacity);
            $cinema->setAddress($address);
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
				require_once(VIEWS_PATH . "admin-cinema-add.php");
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

		public function remove ($id) {
			$this->cinemaDAO->deleteById($id);
			$this->list();
		}

		public function getById ($id) {
			$cinema = $this->cinemaDAO->getById($id);
			if ($_SESSION["loggedUser"]) {
				$admin = $_SESSION["loggedUser"];
				require_once(VIEWS_PATH . "admin-head.php");
				require_once(VIEWS_PATH . "admin-header.php");
				require_once(VIEWS_PATH . "admin-cinema-modify.php");
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
            $this->list();
        }

    }

 ?>
