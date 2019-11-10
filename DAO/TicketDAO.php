<?php

    namespace DAO;

    use Models\Ticket as Ticket;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;

    class TicketDAO
    {
        private $tableName = "tickets";
        private $connection;

        public function Add(Ticket $ticket)
        {
            try
            {
                $query = "CALL tickets_Add(?, ?)";
                $parameters['id_purchase'] = $ticket->getIdPurchase();
                $parameters['id_show'] = $ticket->getIdShow();   
                
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            }catch(Exception $e)
            {
                throw $e;
            }
        }

        public function GetByNumber($number)
        {
            try
            {
                $query = "CALL tickets_GetByNumber(?)";
                $parameters['number'] = $number;

                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
                $ticket = new Ticket();
                foreach($results as $row)
                {
                    $ticket->setTicketNumber($row['ticket_number']);
                    $ticket->setQR($row['QR']);
                    $ticket->setIdPurchase($row['id_purchase']);
                    $ticket->setIdShow($row['id_show']);
                }
                return $purchase;
                
            }catch(Exception $e)
            {
                throw $e;
            }
        }

        public function getAll() 
    {
        try {		
            $ticketList = array();		
            $query = "CALL tickets_GetAll()";
            $this->connection = Connection::GetInstance();
            $results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
            foreach($results as $row) 
            {
                $ticket = new Ticket();
                $ticket->setTicketNumber($row['ticket_number']);
                $ticket->setQR($row['QR']);
                $ticket->setIdPurchase($row['id_purchase']);
                $ticket->setIdShow($row['id_show']);
                array_push ($ticketList, $ticket);
            }				
            return $ticketList;
        }
        catch(Exception $e) {
            throw $e;
        }
    }


    }
    

?>