<?php

    namespace DAO;

    use Models\Ticket as Ticket;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;

    class TicketDAO {
        
        private $tableName = "tickets";
        private $connection;

        public function Add(Ticket $ticket) {
            try {
                $query = "INSERT INTO " . $this->tableName . " (qr, FK_id_purchase, FK_id_show) VALUES (:qr, :id_purchase, :id_show);";
                //$query = "CALL tickets_Add(?,?,?)";
                $parameters['qr'] = $ticket->getQr();
                $parameters['id_show'] = $ticket->getIdShow();   
                $parameters['id_purchase'] = $ticket->getIdPurchase();                            

                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters);
                
            } catch(Exception $e) {
                throw $e;
            }
        }

        public function GetByNumber($number) {
            try {
                $query = "CALL tickets_GetByNumber(?)";
                $parameters['number'] = $number;

                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
                $ticket = new Ticket();
                foreach($results as $row) {
                    $ticket->setTicketNumber($row['ticket_number']);
                    $ticket->setQR($row['QR']);
                    $ticket->setIdPurchase($row['id_purchase']);
                    $ticket->setIdShow($row['id_show']);
                }
                return $purchase;
                
            } catch(Exception $e) {
                throw $e;
            }
        }

        public function getAll() {
            try {		
                $ticketList = array();		
                $query = "CALL tickets_GetAll()";
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
                foreach($results as $row) {
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

        public function getByShowId($id) {
            try {
                $query = "CALL tickets_GetByShowId(?)";
                $parameters['id'] = $id;

                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
                $ticketList = array();
                foreach($results as $row) {
                    $ticket = new Ticket();
                    $ticket->setTicketNumber($row['ticket_number']);
                    $ticket->setQR($row['QR']);
                    $ticket->setIdPurchase($row['FK_id_purchase']);
                    $ticket->setIdShow($row['FK_id_show']);
                    array_push($ticketList, $ticket);
                }

                return $ticketList;
                
            } catch(Exception $e) {
                throw $e;
            }
        }

    }
?>