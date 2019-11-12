<?php

    namespace DAO;

    use Models\Purchase as Purchase;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;

    class PurchaseDAO {

        private $tableName = "purchases";
        private $connection;
        
        public function Add(Purchase $purchase) {
            try {
                $query = "CALL purchases_Add(?, ?, ?, ?, ?)";
                $parameters['ticket_quantity'] = $purchase->getTicketQuantity();
                $parameters['discount'] = $purchase->getDiscount();
                $parameters['date'] = $purchase->getDate();
                $parameters['total'] = $purchase->getTotal();
                $parameters['dni'] = $purchase->getDNI();   
                
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);                   

            } catch(Exception $e) {
                throw $e;
            }
            
        }

        public function GetById($id) {
            try {
                $query = "CALL purchases_GetById(?)";
                $parameters['id'] = $id;

                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
                $purchase = new Purchase();
                foreach($results as $row) {
                    $purchase->setId($row['id']);
                    $purchase->setTicketQuantity($row['ticket_quantity']);
                    $purchase->setDiscount($row['discount']);
                    $purchase->setDate($row['date']);
                    $purchase->setTotal($row['total']);
                    $purchase->setDni($row['dni']);
                }
                return $purchase;
            }
            
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function getAll() {
        try {		
            $purchaseList = array();		
            $query = "CALL purchases_GetAll()";
            $this->connection = Connection::GetInstance();
            $results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
            foreach($results as $row) {
                $purchase = new Purchase();
                $purchase->setId($row['id']);
                $purchase->setTicketQuantity($row['ticket_quantity']);
                $purchase->setDiscount($row['discount']);
                $purchase->setDate($row['date']);
                $purchase->setTotal($row['total']);
                $purchase->setDni($row['dni']);
                array_push ($purchaseList, $purchase);
            }				
            return $purchaseList;
        }
        catch(Exception $e) {
            throw $e;
        }
    }


?>