<?php

    namespace Controllers;

    use DAO\CinemaRoomDAO as CinemaRoomDAO;
	use Models\CinemaRoom as CinemaRoom;
	use Models\Cinema as Cinema;
	use Models\Show as Show;
	use Controllers\UserController as UserController;   
	use Controllers\ViewsRouterController as ViewsRouter;  

    class CinemaRoomController extends ViewsRouter {
		
		private $cinemaRoomDAO;			

        public function __construct() {
            $this->cinemaRoomDAO = new CinemaRoomDAO();
		}			

        public function add($id_cinema, $name, $capacity, $price) {
			if ($this->isFormNotEmpty($id_cinema, $name, $capacity, $price)) {
				$cinemaRoom = new CinemaRoom();            
				$cinemaRoom->setName($name);
				
				$cinema = new Cinema();
				$cinema->setId($id_cinema);
				
				if ($this->cinemaRoomDAO->checkRoomNameInCinema($cinemaRoom, $cinema) == null) {					
					$cinemaRoom = new CinemaRoom();
					$cinemaRoom->setName($name);
					$cinemaRoom->setCapacity($capacity);
					$cinemaRoom->setPrice($price);										
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
		
        private function isFormNotEmpty($id_cinema, $name, $capacity, $price) {
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
					$cinemas = $cinemaController->getAllCinemasActives();
					if ($cinemas) {						
						require_once(VIEWS_PATH . "admin-head.php");
						require_once(VIEWS_PATH . "admin-header.php");
						require_once(VIEWS_PATH . "admin-cinema-room-add.php");
					} else {
						// $userController = new UserController();
						// return $userController->adminPath();
						return $this->goToAdminPath();
					}
				} else {
					// $userController = new UserController();
					// return $userController->userPath();
					return $this->goToUserPath();
				}				
			} else {
                // $userController = new UserController();
				// return $userController->userPath();
				return $this->goToUserPath();
            }
        }

		public function listCinemaRoomPath($all = false, $success = "", $alert = "", $cinemaId = "") {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];								
				if ($admin->getRole() == 1) {					
					
					$cinemasRooms = $all ? $this->cinemaRoomDAO->getAll() : $this->cinemaRoomDAO->getAllActives();

					if ($cinemasRooms) {
						require_once(VIEWS_PATH . "admin-head.php");
						require_once(VIEWS_PATH . "admin-header.php");
						require_once(VIEWS_PATH . "admin-cinema-room-list.php");
					} else {
						// $userController = new UserController();
						// return $userController->adminPath();
						return $this->goToAdminPath();
					}
				} else {
					// $userController = new UserController();
					// return $userController->userPath();
					return $this->goToUserPath();
				}
			} else {
                // $userController = new UserController();
				// return $userController->userPath();
				return $this->goToUserPath();
            }
        }

		public function enable($id) {
			$cinemaRoom = new CinemaRoom();
			$cinemaRoom->setId($id);
			if ($this->cinemaRoomDAO->enableById($cinemaRoom)) {
				return $this->listCinemaRoomPath(null, CINEMA_ROOM_ENABLE, null, null);
			} else {
				return $this->listCinemaRoomPath(null, null, DB_ERROR, null);
			}
		}
		
		public function disable($id) {				
			if ($this->cinemaRoomHasShows($id)) {								
				return $this->listCinemaRoomPath(null, null, CINEMA_ROOM_HAS_SHOWS, $id);
			} else {								
				$cinemaRoom = new CinemaRoom();
				$cinemaRoom->setId($id);				
				if ($this->cinemaRoomDAO->disableById($cinemaRoom)) {
					return $this->listCinemaRoomPath(null, CINEMA_ROOM_DISABLE, null, null);
				}
				return $this->listCinemaRoomPath(null, null, DB_ERROR, null);
			}
		}

		public function forceDisable($id) {
			$cinemaRoom = new CinemaRoom();
			$cinemaRoom->setId($id);
			if ($this->cinemaRoomDAO->disableById($cinemaRoom)) {
				return $this->listCinemaRoomPath(null, CINEMA_ROOM_DISABLE, null, null);
			}
			return $this->listCinemaRoomPath(null, null, DB_ERROR, null);
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
						require_once(VIEWS_PATH . "admin-cinema-room-modify.php");
					} else {
						// $userController = new UserController();
						// return $userController->adminPath();
						return $this->goToAdminPath();
					}
				} else {
					// $userController = new UserController();
					// return $userController->userPath();
					return $this->goToUserPath();
				}
			} else {
                // $userController = new UserController();
				// return $userController->userPath();
				return $this->goToUserPath();
            }
		}

		public function modify($id, $name, $price, $capacity) {			
			$cinemaRoom = new CinemaRoom();
			$cinemaRoom->setId($id);
            $cinemaRoom->setName($name);
			$cinemaRoom->setPrice($price);			
            $cinemaRoom->setCapacity($capacity);
	        if ($this->cinemaRoomDAO->modify($cinemaRoom)) {
				return $this->listCinemaRoomPath(null, CINEMA_ROOM_MODIFY, null, null);
			}
			return $this->listCinemaRoomPath(null, null, DB_ERROR, null);
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
						// $userController = new UserController();
						// return $userController->adminPath();
						return $this->goToAdminPath();
					}
				} else {
					// $userController = new UserController();
					// return $userController->userPath();
					return $this->goToUserPath();
				}
			} else {
                // $userController = new UserController();
				// return $userController->userPath();
				return $this->goToUserPath();
            }
		}
		
		//
		public function getCinemaRoomByShowId($id_show) {
			$show = new Show();
			$show->setId($id_show);
			return $this->cinemaRoomDAO->getByIdShow($show);
		}

		public function getAllCinemaRooms() {
			return $this->cinemaRoomDAO->getAllActives();
		}

		public function getCinemaRoomById($id) {
			$cinemaRoom = new CinemaRoom();
			$cinemaRoom->setId($id);
			return $this->cinemaRoomDAO->getById($cinemaRoom);
		}
		
    }

 ?>
