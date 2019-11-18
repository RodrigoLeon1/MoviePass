<?php
    namespace DAO;
	
	use \Exception as Exception;
	use DAO\Connection as Connection;
	use DAO\IProfileUserDAO as IProfileUserDAO;
    use Models\User as User;
    use Models\ProfileUser as ProfileUser;
	
	class ProfileUserDAO implements IProfileUserDAO {
		
		private $connection;
		private $tableName = "profile_users";

        public function add(User $user) {
			try {
				$query = "INSERT INTO " . $this->tableName . " (dni, first_name, last_name) VALUES (:dni, :first_name, :last_name);";
				$parameters["dni"] = $user->getDni();
                $parameters["first_name"] = $user->getFirstName();
                $parameters["last_name"] = $user->getLastName();
				$this->connection = Connection::getInstance();
				$this->connection->executeNonQuery($query, $parameters);
			}
			catch (Exception $e) {
				throw $e;
			}
        }
    }
 ?>