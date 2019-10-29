<?php

    namespace Controllers;

    use Models\Role as Role;
    use Models\User as User;
	use DAO\UserDAO as UserDAO;	
    use Controllers\HomeController as HomeController;
    use Controllers\MovieController as MovieController;

    class UserController {

        private $userDAO;

        public function __construct() {
            $this->userDAO = new UserDAO();
        }

        public function validateRegister($firstName, $lastName, $dni, $mail, $password) {
            if($this->validateRegisterForm($firstName, $lastName, $dni, $mail, $password) && $this->validateMailForm($mail)) {
                if($this->userDAO->getByMail($mail) == NULL) {
                    $user = new User();
                    
                    $role = new Role();
                    $role->setId(0);

                    $user->setFirstName($firstName);
                    $user->setLastName($lastName);
                    $user->setDni($dni);
                    $user->setMail($mail);
                    $user->setPassword($password);                    
                    $user->setRole($role);
                    $this->userDAO->add($user);
                    $_SESSION["loggedUser"] = $user;
                    $this->userPath();
                }
                return $this->registerPath(REGISTER_ERROR);
            }
            return $this->registerPath(EMPTY_FIELDS);
        }

        private function validateRegisterForm($firstName, $lastName, $dni, $email, $password) {
            if(empty($firstName) || empty($lastName) || empty($dni) || empty($email) || empty($password)) {
                return false;
            }
            return true;
        }

        private function validateMailForm($mail) {
            return (filter_var($mail, FILTER_VALIDATE_EMAIL)) ? TRUE : FALSE;
        }        

        public function validateLogin($mail, $password) {
            if($this->validateLoginForm($mail, $password) && $this->validateMailForm($mail)) {
                $user = $this->userDAO->getByMail($mail);
                if (($user != NULL) && ($user->getPassword() == $password)) {
                    $_SESSION["loggedUser"] = $user;
                    if ($user->getRole() == 1) {
                        return $this->adminPath();
                    }
                    else if ($user->getRole() == 0) {
                        return $this->userPath();
                    }
                }
                return $this->loginPath(LOGIN_ERROR);
            }
            return $this->loginPath(EMPTY_FIELDS);
        }

        private function validateLoginForm($mail, $password) {
            if(empty($mail) || empty($password)) {
                return FALSE;
            }
            return TRUE;
        }

        public function listUserPath($alert = "", $success = "") {
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

        public function registerPath($alert = "") {
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
            $_SESSION["loggedUser"] = NULL;
			$this->userPath();
        }

        public function myAccountPath() {
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

        public function modifyAccountPath() {
			if (isset($_SESSION["loggedUser"])) {
                $user = $_SESSION["loggedUser"];
                $title = "Modify my account";
				require_once(VIEWS_PATH . "header.php");
                require_once(VIEWS_PATH . "navbar.php");                
                require_once(VIEWS_PATH . "my-account-modify.php");
                require_once(VIEWS_PATH . "footer.php");
			} else {
                $this->loginPath();
            }              
        }

    }

 ?>
