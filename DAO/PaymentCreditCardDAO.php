<?php

    namespace DAO;

    use \Exception as Exception;
    use Models\PaymentCreditCard as PaymentCreditCard;
    use DAO\QueryType as QueryType;
    use DAO\Connection as Connection;    

    class PaymentCreditCardDAO {

        private $creditAccountsList = array();
        private $connection;
        private $tableName = "payments_credit_card";

        public function add(PaymentCreditCard $paymentCreditCard) {
            try {
				$query = "CALL payments_credit_card_Add(?, ?, ?, ?, @lastId)";                                
                $parameters["code_auth"] = $paymentCreditCard->getCodeAuth();
                $parameters["date"] = $paymentCreditCard->getDate();
                $parameters["total"] = $paymentCreditCard->getTotal();
                $parameters["FK_card"] = $paymentCreditCard->getCreditAccount()->getId();
				$this->connection = Connection::GetInstance();
                $results = $this->connection->execute($query, $parameters, QueryType::StoredProcedure);
                foreach ($results as $row) {
                    $lastId = $row['lastId'];
                }
                return $lastId;
			}catch (Exception $e) {
				return false;
			}
        }

    }

?>