<?php

    namespace DAO;

    use \Exception as Exception;
    use Models\User as User;
    use Models\Movie as Movie;
    use Models\Cinema as Cinema;    
    use Models\Purchase as Purchase;
    use Models\PurchaseCart as PurchaseCart;
    use Models\PaymenteCreditCard as PaymenteCreditCard;
    use DAO\QueryType as QueryType;
    use DAO\Connection as Connection;
    use DAO\IPurchaseDAO as IPurchaseDAO;
        
    class PurchaseDAO implements IPurchaseDAO {

        private $tableName = "purchases";
        private $connection;
        
        public function add(Purchase $purchase) {
            try {
                $query = "CALL purchases_Add(?, ?, ?, ?, ?, ?, @lastId)";
                $parameters['ticket_quantity'] = $purchase->getTicketQuantity();
                $parameters['discount'] = $purchase->getDiscount();
                $parameters['date'] = $purchase->getDate();
                $parameters['total'] = $purchase->getTotal();
                $parameters['dni'] = $purchase->getDni();            
                $parameters['FK_payment_cc'] = $purchase->getPaymentCreditCard()->getId();            
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
                
                foreach($results as $row) {
                    $lastId = $row['lastId'];                
                }
                
                return $lastId;

            } catch(Exception $e) {
                return false;
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
                return false;
            }
        }
        
        public function getById(Purchase $purchase) {
            try {
                $query = "CALL purchases_GetById(?)";
                $parameters['id'] = $purchase->getId();
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
                return false;
            }
        }

        public function getByDni(User $user) {
            try {
                $query = "CALL purchases_GetByDni(?)";
                $parameters['dni'] = $user->getDni();
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
                    
                    $movie = new Movie();
                    $movie->setTitle($row['movie_title']);

                    $cinema = new Cinema();
                    $cinema->setName($row['cinema_name']);
                    
                    $purchaseCart = new PurchaseCart();
                    $purchaseCart->setPurchase($purchase);
                    $purchaseCart->setMovie($movie);                                        
                    $purchaseCart->setCinema($cinema);

                    array_push ($purchases, $purchaseCart);
                }
                return $purchases;
            
            } catch(Exception $e) {
                return false;
            }
        }

    }

?>