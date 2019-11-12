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

        private function checkAvailabilityTickets($show, $tickets = "") {

            $cinemaCapacity = $show->getCinema()->getCapacity();
            
            echo 'CAPACIDAD: ' . $cinemaCapacity;
        }


        
    }
?>