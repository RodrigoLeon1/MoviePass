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

        public function Add($qr, $id_show, $id_purchase)
        {
            $ticket = new Ticket();            
            $ticket->setQR($qr);
            $ticket->setIdPurchase($id_purchase);
            $ticket->setIdShow($id_show);
            
            $this->ticketDAO->Add($ticket);
        }

        public function getByNumber($number)
        {
            return $this->ticketDAO-GetByNumber($number);
        }

        public function getByShow($id)
        {
            return  $this->ticketDAO->getByShowId($id);
        }

        public function getTickets()
        {
            return $this->ticketDAO->getAll();
        }

        public function ticketsNumber($id)
        {
            $tickets = $this->getByShow($id);
            return count($tickets);
        }

        // 
        private function generateQR() {

        }
        
        
    }
?>