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

        public function Add($qr, $id_purchase, $id_show)
        {
            if($this->validateTicketForm($qr, $id_purchase, $id_show)) 
            {
				$ticket = new Ticket();            
                $ticket->setQR($qr);
                $ticket->setIdPurchase($id_purchase);
                $ticket->setIdShow($id_show);
                
                $this->ticketDAO->Add($ticket);
			}
        }


        

        private function validateTicketForm($qr, $id_purchase, $id_show)
         {
            if(empty($qr) || empty($id_purchase) || empty($id_show)) 
            {
                return FALSE;
            }
            return TRUE;
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


        


        
    }
?>