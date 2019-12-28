<?php

    namespace DAO;

	use \Exception as Exception;
    use Models\User as User;
	use DAO\IUserDAO as IUserDAO;
	use DAO\QueryType as QueryType;
	use DAO\Connection as Connection;
	use DAO\ProfileUserDAO as ProfileUserDAO;	

    class UserDAO implements IUserDAO  {

		private $userList = array();
		private $connection;
		private $tableName = "users";
		private $profileUserDAO;		

		public function __construct() {
			$this->profileUserDAO = new ProfileUserDAO();			
		}

        public function add(User $user) {
			$profileUserDAO = new ProfileUserDAO();			
			if ($profileUserDAO->add($user)) {
				try {					
					$query = "CALL users_add(?, ?, ?, ?)";
					$parameters["mail"] = $user->getMail();
					$parameters["password"] = $user->getPassword();
					$parameters["dni"] = $user->getDni();
					$parameters["role"] = $user->getRole();
					$this->connection = Connection::getInstance();
					$this->connection->executeNonQuery($query, $parameters, QueryType::StoredProcedure);
					return true;
				}
				catch (Exception $e) {
					return false;
				}
			} else {
				return false;
			}
        }
				
		public function getByMail(User $user) {
			try {
				$userTemp = null;
				$query = "CALL users_getByMail(?)";
				$parameters["mail"] = $user->getMail();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);						
				foreach ($results as $row) {
					$userTemp = new User();
					$userTemp->setMail($row["mail"]);
					$userTemp->setPassword($row["password"]);
					$userTemp->setRole($row["FK_id_role"]);
					$userTemp->setDni($row["dni"]);
					$userTemp->setFirstName($row["first_name"]);
					$userTemp->setLastName($row["last_name"]);
					$userTemp->setIsActive($row["is_active"]);
				}
				return $userTemp;
			} catch (Exception $e) {
				return false;
			}
        }

		public function getAll() {
			try {
				$query = "CALL users_getAll()";
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
				foreach ($results as $row) {
					$user = new User();
					$user->setFirstName($row["first_name"]);
					$user->setLastName($row["last_name"]);
					$user->setDni($row["dni"]);
					$user->setMail($row["mail"]);
					$user->setRole($row["FK_id_role"]);
					$user->setIsActive($row["is_active"]);
					array_push($this->userList, $user);
				}
				return $this->userList;	
			} catch (Exception $e) {
				return false;
			}
		}
		
		public function enableByDni(User $user) {
			try {
				$query = "CALL users_enableByDni(?)";
				$parameters ["FK_dni"] = $user->getDni();
				$this->connection = Connection::GetInstance();
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
				return true;
			}
			catch (Exception $e) {
				return false;
			}
		}

		public function disableByDni(User $user) {
			try {
				$query = "CALL users_disableByDni(?)";
				$parameters ["FK_dni"] = $user->getDni();
				$this->connection = Connection::GetInstance();
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
				return true;
			}
			catch (Exception $e) {
				return false;
			}
		}		

		// Falta arreglar
		public function updateUser(User $user) {
			try {								
				$query = "UPDATE " . $this->tableName . " AS user 
														  INNER JOIN profile_users AS p_user ON user.FK_dni =  p_user.dni
														 SET
															 user.mail = :mail,
															 user.password = :password,
															 p_user.dni = :dni,
															 p_user.first_name = :firstname,
															 p_user.last_name = :lastname
 														 WHERE 
															 p_user.dni = :dni";					
				
				$parameters["mail"] = $user->getMail();
				$parameters["password"] = $user->getPassword();
				$parameters["dni"] = $user->getDni();
				$parameters["firstname"] = $user->getFirstName();
				$parameters["lastname"] = $user->getLastName();				

				$this->connection = Connection::GetInstance();
				$this->connection->ExecuteNonQuery($query, $parameters);								
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

    }

 ?>
