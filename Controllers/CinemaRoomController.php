<?php

    namespace Controllers;

    use DAO\CinemaRoomDAO as cinemaRoomDAO;
    use Models\Cinema as CinemaRoom;

    class CinemaRoomController {
        private $cinemaRoomDAO;
		private $cinemasRoom;

        public function __construct() {
            $this->cinemaRoomDAO = new CinemaRoomDAO();
		}
		
		// add- borrar- modificar- get(id/all)- 

        public function add($name, $capacity, $price) {
			if($this->validateCinemaForm($name, $capacity, $price)) {
				$cinemaRoom = new CinemaRoom();            
				$cinemaRoom->setName($name);
				if($this->cinemaRoomDAO->getByName($cinemaRoom) == NULL) {
					$cinemaRoom = new Cinema();
					$cinemaRoom->setName($name);
					$cinemaRoom->setCapacity($capacity);
					$cinemaRoom->setPrice($price);
					$this->cinemaRoomDAO->add($cinemaRoom);
					return $this->addCinemaRoomPath(CINEMA_ROOM_ADDED, NULL);
				}
				return $this->addCinemaRoomPath(NULL, CINEMA_ROOM_EXIST);
			}
			return $this->addCinemaRoomPath(NULL, EMPTY_FIELDS);
		}
		
        private function validateCinemaForm($name, $capacity, $price) {
            if(empty($name) || empty($capacity) || empty($price)) {
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
					require_once(VIEWS_PATH . "admin-cinema-room-add.php");
				}				
			}
        }

		public function listCinemaRoomPath($success = "", $alert = "", $cinemaId = "") {
			if ($_SESSION["loggedUser"]) {
				$admin = $_SESSION["loggedUser"];				
				$this->cinemas = $this->cinemaRoomDAO->getAll();
				if($admin->getRole() == 1) {
					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-cinema-room-list.php");
				}
			}
        }

		public function remove($id) {	
			if($this->cinemaHasShows($id)) {				
				return $this->listCinemaRoomPath(NULL, CINEMA_ROOM_HAS_SHOWS, $id);
			} else {
				$this->cinemaRoomDAO->deleteById($id);
				return $this->listCinemaRoomPath(CINEMA_ROOM_REMOVE, NULL, NULL);
			}
		}

		public function forceDelete($id) {
			$this->cinemaRoomDAO->deleteById($id);
			return $this->listCinemaRoomPath(CINEMA_ROOM_REMOVE, NULL, NULL);
		}

		private function cinemaHasShows($id) {
			$cinemaRoom = new CinemaRoom();
			$cinemaRoom->setId($id);

			return ($this->cinemaRoomDAO->getShowsOfCinemaRoom($cinemaRoom)) ? TRUE : FALSE;
		}

		public function modifyById($id) {
			$cinemaRoom = $this->cinemaRoomDAO->getById($id);
			if ($_SESSION["loggedUser"]) {
				$admin = $_SESSION["loggedUser"];
				if($admin->getRole() == 1) {
					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-cinema-modify.php");
				}
			}
		}

		public function modify($id, $name, $capacity, $price) {			
			$cinemaRoom = new CinemaRoom();
            $cinemaRoom->setName($name);
            $cinemaRoom->setCapacity($capacity);
            $cinemaRoom->setPrice($price);
	        $this->cinemaRoomDAO->modify($cinemaRoom);
            return $this->listCinemaRoomPath(CINEMA_ROOM_MODIFY);
        }

    }

 ?>
