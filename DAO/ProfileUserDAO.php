<?php

    namespace DAO;

	use \Exception as Exception;
	use DAO\Connection as Connection;
    use Models\User as User;
    use Models\ProfileUser as ProfileUser;

    class ProfileUserDAO {

		private $connection;
		private $tableName = "profile_users";

        public function add (User $user) {
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

		public function getByDNI($dni)
        {
            $user = null;
            $query = "CALL profile_users_getByDNI (?)";
            $parameters["dni"] = $dni;
            $this->connection = Connection::GetInstance();
            $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
            foreach($results as $row)
            {
                $user = new User();
                $user->setDni($row["dni"]);
                $user->setFirstName($row["first_name"]);
                $user->setLastName($row["last_name"]);
            }
            return $user;
        }

    }

 ?>
