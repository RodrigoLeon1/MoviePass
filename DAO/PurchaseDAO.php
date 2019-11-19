<?php

    namespace DAO;

    use Models\Purchase as Purchase;
    use DAO\Connection as Connection;
    use DAO\IPurchaseDAO as IPurchaseDAO;
    use DAO\QueryType as QueryType;

    class PurchaseDAO implements IPurchaseDAO {

        private $tableName = "purchases";
        private $connection;
        
        public function add(Purchase $purchase) {
            try {
                $query = "CALL purchases_Add(?, ?, ?, ?, ?)";
                $parameters['ticket_quantity'] = $purchase->getTicketQuantity();
                $parameters['discount'] = $purchase->getDiscount();
                $parameters['date'] = $purchase->getDate();
                $parameters['total'] = $purchase->getTotal();
                $parameters['dni'] = $purchase->getDni();   
                
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
                
                $id = $this->getId($purchase->getTicketQuantity(), $purchase->getDiscount(), $purchase->getDate(), $purchase->getTotal(), $purchase->getDni());

                return $id;

            } catch(Exception $e) {
                throw $e;
            }
            
        }

        public function getId($ticket_quantity, $discount, $date, $total, $dni) {
            try {
                $query = "SELECT * FROM " . $this->tableName . " WHERE((ticket_quantity = :ticket_quantity) AND (discount = :discount) AND (date = :date) AND (total = :total) AND (FK_dni = :dni) )";			
                $parameters['ticket_quantity'] = $ticket_quantity;
                $parameters['discount'] = $discount;
                $parameters['date'] = $date;
                $parameters['total'] = $total;
                $parameters['dni'] = $dni;

                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters);
                $purchase = new Purchase();
                foreach($results as $row) {
                    $purchase->setId($row['id_purchase']);
                    $purchase->setTicketQuantity($row['ticket_quantity']);
                    $purchase->setDiscount($row['discount']);
                    $purchase->setDate($row['date']);
                    $purchase->setTotal($row['total']);
                    $purchase->setDni($row['FK_dni']);
                }
                return $purchase->getId();
            
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

        //PASAR A OBJ
        public function getById($id) {
            try {
                $query = "CALL purchases_GetById(?)";
                $parameters['id'] = $id;

                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
                $purchase = new Purchase();
                foreach($results as $row) {
                    $purchase->setId($row['purchases_id_purchase']);
                    $purchase->setTicketQuantity($row['purchases_ticket_quantity']);
                    $purchase->setDiscount($row['purchases_discount']);
                    $purchase->setDate($row['purchases_date']);
                    $purchase->setTotal($row['purchases_total']);
                    $purchase->setDni($row['purchases_FK_dni']);
                }
                return $purchase;
            
            } catch(Exception $e) {
                throw $e;
            }
        }

        public function getByDni($dni) {
            try {
                $query = "CALL purchases_GetByDni(?)";
                $parameters['dni'] = $dni;

                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
                $purchases = array();
                foreach($results as $row) {
                    $purchase = new Purchase();
                    $purchase->setId($row['purchases_id_purchase']);
                    $purchase->setTicketQuantity($row['purchases_ticket_quantity']);
                    $purchase->setDiscount($row['purchases_discount']);
                    $purchase->setDate($row['purchases_date']);
                    $purchase->setTotal($row['purchases_total']);
                    $purchase->setDni($row['purchases_FK_dni']);
                    array_push ($purchases, $purchase);
                }
                return $purchases;
            
            } catch(Exception $e) {
                throw $e;
            }
        }

}

?>