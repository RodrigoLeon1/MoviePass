<?php

    namespace DAO;
	
	use \Exception as Exception;
    use Models\User as User;
    use Models\ProfileUser as ProfileUser;
	use DAO\QueryType as QueryType;
	use DAO\Connection as Connection;
	use DAO\IProfileUserDAO as IProfileUserDAO;
	
	class ProfileUserDAO implements IProfileUserDAO {
		
		private $connection;
		private $tableName = "profile_users";		

        public function add(User $user) {
			try {				
				$query = "CALL profile_users_add(?, ?, ?)";
				$parameters["dni"] = $user->getDni();
                $parameters["first_name"] = $user->getFirstName();
                $parameters["last_name"] = $user->getLastName();
				$this->connection = Connection::getInstance();
				$this->connection->executeNonQuery($query, $parameters, QueryType::StoredProcedure);
				return true;
			}
			catch (Exception $e) {
				return false;
			}
        }
    }
 ?>