<?php

    namespace Controllers;

    use DAO\CinemaRoomDAO as CinemaRoomDAO;
	use Models\CinemaRoom as CinemaRoom;
	use Models\Cinema as Cinema;
	use Models\Show as Show;
	use Controllers\UserController as UserController;   

    class CinemaRoomController {
		
		private $cinemaRoomDAO;			

        public function __construct() {
            $this->cinemaRoomDAO = new CinemaRoomDAO();
		}			

        public function add($id_cinema, $name, $capacity, $price) {
			if ($this->validateCinemaRoomForm($id_cinema, $name, $capacity, $price)) {
				$cinemaRoom = new CinemaRoom();            
				$cinemaRoom->setName($name);
				if ($this->cinemaRoomDAO->checkRoomNameInCinema($name, $id_cinema) == null) {
					$cinemaRoom = new CinemaRoom();
					$cinemaRoom->setName($name);
					$cinemaRoom->setCapacity($capacity);
					$cinemaRoom->setPrice($price);

					$cinema = new Cinema();
					$cinema->setId($id_cinema);

					$cinemaRoom->setCinema($cinema);

					if ($this->cinemaRoomDAO->add($cinemaRoom)){
						return $this->addCinemaRoomPath(CINEMA_ROOM_ADDED, null);
					}
					return $this->addCinemaRoomPath(null, DB_ERROR);
				}
				return $this->addCinemaRoomPath(null, CINEMA_ROOM_EXIST);
			}
			return $this->addCinemaRoomPath(null, EMPTY_FIELDS);
		}
		
        private function validateCinemaRoomForm($id_cinema, $name, $capacity, $price) {
            if (empty($id_cinema) || empty($name) || empty($capacity) || empty($price)) {
                return false;
            }
            return true;
        }		

        public function addCinemaRoomPath($success = "", $alert = "") {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if ($admin->getRole() == 1) {
					$cinemaController = new CinemaController();
					$cinemas = $cinemaController->getAllCinemas();
					if ($cinemas != null) {						
						require_once(VIEWS_PATH . "admin-head.php");
						require_once(VIEWS_PATH . "admin-header.php");
						require_once(VIEWS_PATH . "admin-cinema-room-add.php");
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

		public function listCinemaRoomPath($success = "", $alert = "", $cinemaId = "") {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];								
				if ($admin->getRole() == 1) {					
					$cinemasRooms = $this->cinemaRoomDAO->getAll();
					if ($cinemasRooms) {
						require_once(VIEWS_PATH . "admin-head.php");
						require_once(VIEWS_PATH . "admin-header.php");
						require_once(VIEWS_PATH . "admin-cinema-room-list.php");
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

		// borrado logico
		public function remove($id) {				
			if ($this->cinemaRoomHasShows($id)) {								
				return $this->listCinemaRoomPath(null, CINEMA_ROOM_HAS_SHOWS, $id);
			} else {								
				$cinemaRoom = new CinemaRoom();
				$cinemaRoom->setId($id);
				
				$this->cinemaRoomDAO->deleteById($cinemaRoom);
				return $this->listCinemaRoomPath(CINEMA_ROOM_REMOVE, null, null);
			}
		}

		public function forceDelete($id) {
			$cinemaRoom = new CinemaRoom();
			$cinemaRoom->setId($id);

			$this->cinemaRoomDAO->deleteById($cinemaRoom);
			return $this->listCinemaRoomPath(CINEMA_ROOM_REMOVE, null, null);
		}

		private function cinemaRoomHasShows($id) {
			$cinemaRoom = new CinemaRoom();
			$cinemaRoom->setId($id);

			return ($this->cinemaRoomDAO->getShowsOfCinemaRoom($cinemaRoom)) ? true : false;
		}

		public function modifyById($id) {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if ($admin->getRole() == 1) {
					$cinemaRoomTemp = new CinemaRoom();
					$cinemaRoomTemp->setId($id);
					$cinemaRoom = $this->cinemaRoomDAO->getById($cinemaRoomTemp);					
					if ($cinemaRoom) {
						require_once(VIEWS_PATH . "admin-head.php");
						require_once(VIEWS_PATH . "admin-header.php");
						require_once(VIEWS_PATH . "admin-cinema-modify.php");
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

		public function modify($id, $name, $capacity, $price) {			
			$cinemaRoom = new CinemaRoom();
            $cinemaRoom->setName($name);
            $cinemaRoom->setCapacity($capacity);
			$cinemaRoom->setPrice($price);			
	        if ($this->cinemaRoomDAO->modify($cinemaRoom)) {
				return $this->listCinemaRoomPath(CINEMA_ROOM_MODIFY, null, null);
			}
			return $this->listCinemaRoomPath(null, DB_ERROR, null);
        }

		public function getCinemaRoomByShowId($id_show) {
			$show = new Show();
			$show->setId($id_show);

			return $this->cinemaRoomDAO->getByIdShow($show);
		}
		
		public function sales() {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if ($admin->getRole() == 1) {					
					$rooms = $this->cinemaRoomDAO->getAll();
					if ($rooms) {
						require_once(VIEWS_PATH . "admin-head.php");
						require_once(VIEWS_PATH . "admin-header.php");
						require_once(VIEWS_PATH . "admin-cinema-room-sales.php");
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
		
		public function getAllCinemaRooms() {
			return $this->cinemaRoomDAO->getAll();
		}

		public function getCinemaRoomById($id) {
			$cinemaRoom = new CinemaRoom();
			$cinemaRoom->setId($id);

			return $this->cinemaRoomDAO->getById($cinemaRoom);
		}
    }

 ?>
