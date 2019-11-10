<?php

    namespace Controllers;    

    use DAO\TicketDAO as TicketDAO;
    use Models\Ticket as Ticket;
    use Controllers\ShowController as ShowController;
    use Controllers\UserController as UserController;

    class TicketController {
        
        private $ticketDAO;
        
        public function __construct() {
            $this->ticketDAO = new TicketDAO();            
        }

        public function buyTicketPath($idShow) {            
            if (isset($_SESSION["loggedUser"])) {                
                
                $showController = new ShowController();
                $show = $showController->getShowById($idShow);                                
                
                $title = 'Buy ticket - ' . $show->getMovie()->getTitle();
                $img = IMG_PATH_TMDB . $show->getMovie()->getBackdropPath();

			    require_once(VIEWS_PATH . "header.php");			
                require_once(VIEWS_PATH . "navbar.php");
                require_once(VIEWS_PATH . "header-s.php");
                require_once(VIEWS_PATH . "purchase-ticket.php");
                require_once(VIEWS_PATH . "footer.php");
            } else {
                $userController = new UserController();
                return $userController->loginPath(LOGIN_NEEDED);
            }
        }


        
    }
?>