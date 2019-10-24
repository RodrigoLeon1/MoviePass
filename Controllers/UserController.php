<?php

    namespace Controllers;

    use Models\User as User;
    use DAO\UserDAO as UserDAO;
    use DAO\ProfileUserDAO as ProfileUserDAO;
    use Controllers\HomeController as HomeController;
    use Controllers\MovieController as MovieController;

    class UserController {

        private $userDAO;

        public function __construct() {
            $this->userDAO = new UserDAO();
        }

        public function validateRegister($firstName, $lastName, $dni, $mail, $password) {
            $user = new User();
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setDni($dni);
            $user->setMail($mail);
            $user->setPassword($password);
            $user->setRole(0);
            $this->userDAO->add($user);
            $_SESSION["loggedUser"] = $user;
            $this->userPath();
        }

        public function validateLogin($mail, $password) {
            $user = $this->userDAO->getByMail($mail);
			if (($user != null) && ($user->getPassword() == $password)) {
				$_SESSION["loggedUser"] = $user;
				if ($user->getRole() == 1) {
					return $this->adminPath();
				}
				else if ($user->getRole() == 0) {
					return $this->userPath();
				}
			}
            return $this->loginPath("You have entered an invalid e-mail or password. Try again!");
        }

        public function list() {
            if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
                $users = $this->userDAO->getAll();
				require_once(VIEWS_PATH . "admin-head.php");
				require_once(VIEWS_PATH . "admin-header.php");
				require_once(VIEWS_PATH . "admin-user-list.php");                
            } else {
                $this->userPath();
            }
        }

        public function adminPath() {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				require_once(VIEWS_PATH . "admin-head.php");
				require_once(VIEWS_PATH . "admin-header.php");
				require_once(VIEWS_PATH . "admin-dashboard.php");
			} else {
                $this->userPath();
            }
        }

        public function userPath() {
			$movieController = new MovieController();
			$movies = $movieController->showMoviesNowPlaying();
			$title = 'Now Playing';
			$img = IMG_PATH . '/w4.png';
			require_once(VIEWS_PATH . "header.php");
			require_once(VIEWS_PATH . "navbar.php");
			require_once(VIEWS_PATH . "header-s.php");
			require_once(VIEWS_PATH . "now-playing.php");
			require_once(VIEWS_PATH . "footer.php");
        }

        public function loginPath($alert = "") {
            if(!isset($_SESSION["loggedUser"])) {
                $title = "MoviePass — Login";
                $img = IMG_PATH . "w5.png";
                require_once(VIEWS_PATH . "header.php");                
                require_once(VIEWS_PATH . "login.php");			
            } else {
                $this->userPath();
            }
        }

        public function registerPath() {
            if(!isset($_SESSION["loggedUser"])) {
                $title = 'MoviePass — Register';
                $img = IMG_PATH . '/w3.jpg';
                require_once(VIEWS_PATH . "header.php");                
                require_once(VIEWS_PATH . "register.php");			
            } else {
                $this->userPath();
            }
        }

        public function logoutPath() {
            session_destroy();
            $_SESSION["loggedUser"] = null;
			$this->userPath();
        }

        public function account() {
			if (isset($_SESSION["loggedUser"])) {
                $user = $_SESSION["loggedUser"];
                $title = "My account";
				require_once(VIEWS_PATH . "header.php");
                require_once(VIEWS_PATH . "navbar.php");                
                require_once(VIEWS_PATH . "my-account.php");
                require_once(VIEWS_PATH . "footer.php");
			} else {
                $this->loginPath();
            }            
        }

    }

 ?>
