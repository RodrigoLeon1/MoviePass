<?php

    namespace Controllers;    

    use Controllers\UserController as UserController;

    class TicketController {
        
        public function purchaseTicketPath() {            

            if (isset($_SESSION["loggedUser"])) {
                
                $title = 'Purchase ticket';

			    require_once(VIEWS_PATH . "header.php");			
                require_once(VIEWS_PATH . "navbar.php");
                require_once(VIEWS_PATH . "purchase-ticket.php");
                require_once(VIEWS_PATH . "footer.php");
            } else {
                $userController = new UserController();
                return $userController->loginPath("Please! Login to continue.");
            }
        }
    }
?>