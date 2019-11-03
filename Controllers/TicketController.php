<?php

    namespace Controllers;    

    use Controllers\UserController as UserController;

    class TicketController {
        
        public function buyTicketPath() {            
            if (isset($_SESSION["loggedUser"])) {                
                $title = 'Buy ticket';
			    require_once(VIEWS_PATH . "header.php");			
                require_once(VIEWS_PATH . "navbar.php");
                require_once(VIEWS_PATH . "purchase-ticket.php");
                require_once(VIEWS_PATH . "footer.php");
            } else {
                $userController = new UserController();
                return $userController->loginPath(LOGIN_NEEDED);
            }
        }
    }
?>