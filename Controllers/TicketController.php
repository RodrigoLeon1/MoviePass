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
            $this->userController = new UserController();          
        }

        public function add($qr, $id_show, $id_purchase) {
            $ticket = new Ticket();            
            $ticket->setQr($qr);
            $ticket->setIdPurchase($id_purchase);

            $show = new Show();
            $show->setId($id_show);
            $ticket->setShow($show);
            
            return $this->ticketDAO->add($ticket);
        }
 
        public function getByNumber($number) {
            $ticket = new Ticket();
            $ticket->setTicketNumber($number);
            return $this->ticketDAO-getByNumber($ticket);
        }

        public function getByShow($id) {
            $show = new Show();
            $show->setId($id);
            return  $this->ticketDAO->getByShowId($show);
        }

        public function getTickets() {
            return $this->ticketDAO->getAll();
        }

        public function ticketsNumber($id) {
            $tickets = $this->getByShow($id);
            return count($tickets);
        }
        
        public function ticketsSoldPath() {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if ($admin->getRole() == 1) {                                         
                    $tickets = $this->ticketDAO->getInfoShowTickets();    
                    if ($tickets) {
                        require_once(VIEWS_PATH . "admin-head.php");
                        require_once(VIEWS_PATH . "admin-header.php");
                        require_once(VIEWS_PATH . "admin-tickets-sold.php");
                    } else {
                        return $this->userController->adminPath();
                    }
                } else {
                    return $this->userController->userPath();
                }
			} else {
                return $this->userController->userPath();
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