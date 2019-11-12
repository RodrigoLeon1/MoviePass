<?php

    namespace Controllers;    

    use Controllers\ShowController as ShowController;
    use Controllers\UserController as UserController;

    class PurchaseController {
        
        private $purchaseDAO;
        
        public function __construct() {
            // $this->purchaseDAO = new ();            
        }
        
        public function purchasePath($idShow) {            
            if (isset($_SESSION["loggedUser"])) {                
                
                $showController = new ShowController();
                $show = $showController->getShowById($idShow);                                   
                
                $title = 'Purchase - ' . $show->getMovie()->getTitle();
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

        public function buy($show, $tickets) {

        }


        
    }
?>