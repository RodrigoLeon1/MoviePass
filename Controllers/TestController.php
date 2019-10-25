<?php

    namespace Controllers;

    use Controllers\CinemaController as CinemaController;

    class TestController {

        public function purchaseTicket() {
            
            $cinemaController = new CinemaController();            

            $title = 'Purchase';
			require_once(VIEWS_PATH . "header.php");			
            require_once(VIEWS_PATH . "navbar.php");            
            require_once(VIEWS_PATH . "purchase-ticket.php");
			require_once(VIEWS_PATH . "footer.php");
        }
    }
?>
