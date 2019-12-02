<?php

    namespace DAO;

    use \Exception as Exception;
    use DAO\Connection as Connection;    
    use Models\CreditAccount as CreditAccount;

    class CreditAccountDAO {

        private $creditAccountsList = array();
        private $connection;
        private $tableName = "credit_accounts";

        public function add(CreditAccount $creditAccount) {
            try {
				$query = "CALL credit_accounts_Add(?)";                
                $parameters["company"] = $creditAccount->getCompany();				
				$this->connection = Connection::GetInstance();
                $this->connection->executeNonQuery($query, $parameters, QueryType::StoredProcedure);
                return true;
			}catch (Exception $e) {
				return false;
			}
        }

        public function getAll() {
			try {                
                $query = "CALL credit_accounts_GetAll()";
				$this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($query, array(), QueryType::StoredProcedure);
				foreach ($resultSet as $row) {
					$creditAccount = new CreditAccount();
                    $creditAccount->setId($row["id"]);
                    $creditAccount->setCompany($row["company"]);					
					array_push($this->creditAccountsList, $creditAccount);
                }
				return $this->creditAccountsList;
			}
			catch (Exception $ex) {
				return false;
			}
        }
    }

?>