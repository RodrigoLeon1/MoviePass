<?php

    namespace Controllers;    

    use Models\Show as Show;
    use Models\Ticket as Ticket;
    use DAO\TicketDAO as TicketDAO;
    use Controllers\ShowController as ShowController;
    use Controllers\UserController as UserController;    

    class TicketController {
        
        private $ticketDAO;
        
        public function __construct() {            
            $this->ticketDAO = new TicketDAO();            
        }

        public function add($qr, $id_show, $id_purchase) {
            $ticket = new Ticket();            
            $ticket->setQr($qr);
            $ticket->setIdPurchase($id_purchase);

            $show = new Show();
            $show->setId($id_show);
            $ticket->setShow($show);
            
            $this->ticketDAO->add($ticket);			
        }

        private function validateTicketForm($id_purchase, $id_show) {
            if(empty($id_purchase) || empty($id_show)) {
                return FALSE;
            }
            return TRUE;
        }

        public function getByNumber($number) {
            return $this->ticketDAO-getByNumber($number);
        }

        public function getByShow($id) {
            return  $this->ticketDAO->getByShowId($id);
        }

        public function getTickets() {
            return $this->ticketDAO->getAll();
        }

        public function ticketsNumber($id) {
            $tickets = $this->getByShow($id);
            return count($tickets);
        }

        // Tickes vendidos
        public function ticketsSoldPath() {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if($admin->getRole() == 1) {                
                    $tickets = $this->ticketDAO->getGeneralInfo();                                    
					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-tickets-sold.php");
                } 
			} else {
                $userController = new UserController();
                return $userController->userPath();
            }
        }
        
        public function getTicketsSold($id_show) {
            $show = new Show();
            $show->setId($id_show);

            return $this->ticketDAO->getTicketsOfShows($show);
        }
        
        public function getTickesRemainder($id_show) {
            $cinemaRoomController = new CinemaRoomController();
            
            $show = new Show();
            $show->setId($id_show);
            $cinemaRoom = $cinemaRoomController->getCinemaRoomByShowId($id_show);
            $tickesSold = $this->getTicketsSold($id_show);
            
            return ($cinemaRoom->getCapacity() - $tickesSold);
        }

    }
?>