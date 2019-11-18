<?php

    namespace DAO;

	use \Exception as Exception;
	use DAO\Connection as Connection;
	use DAO\IUserDAO as IUserDAO;
    use Models\User as User;
	use DAO\ProfileUserDAO as ProfileUserDAO;
	use DAO\RoleDAO as RoleDAO;

    class UserDAO implements IUserDAO  {

		private $userList = array();
		private $connection;
		private $tableName = "users";
		private $profileUserDAO;
		private $roleDAO;

		public function __construct() {
			$this->profileUserDAO = new ProfileUserDAO();
			$this->roleDAO = new RoleDAO();
		}

        public function add(User $user) {
			$profileUserDAO = new ProfileUserDAO ();
			$profileUserDAO->add($user);
			try {
				$query = "INSERT INTO " . $this->tableName . " (mail, password, FK_dni, FK_id_role) VALUES (:mail, :password, :dni, :role);";
				$parameters["mail"] = $user->getMail();
                $parameters["password"] = $user->getPassword();
				$parameters["dni"] = $user->getDni();
				$parameters["role"] = $user->getRole();
                $this->connection = Connection::getInstance();
				$this->connection->executeNonQuery($query, $parameters);
			}
			catch (Exception $e) {
				throw $e;
			}
        }

		//PASAR A OBJ
		public function getByMail($mail) {
            $user = NULL;
            $query = "CALL users_getByMail (?)";
            $parameters["mail"] = $mail;
            $this->connection = Connection::GetInstance();
            $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);						
            foreach($results as $row) {
                $user = new User();
				$user->setMail($row["mail"]);
                $user->setPassword($row["password"]);
				$user->setRole($row["FK_id_role"]);
				$user->setDni($row["dni"]);
				$user->setFirstName($row["first_name"]);
				$user->setLastName($row["last_name"]);
            }
            return $user;
        }

		public function getAll() {
			$query = "CALL users_getAll";
			$this->connection = Connection::GetInstance();
			$results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
			foreach($results as $row) {
				$user = new User();
				$user->setFirstName($row["first_name"]);
				$user->setLastName($row["last_name"]);
				$user->setDni($row["dni"]);
				$user->setMail($row["mail"]);
				$user->setRole($row["FK_id_role"]);
				array_push($this->userList, $user);
			}
			return $this->userList;
		}

		//PASAR A OBJ
		public function deleteByDni($dni) {
			try {
				$query = "CALL users_deleteByDni(?)";
				$parameters ["FK_dni"] = $dni;
				$this->connection = Connection::GetInstance();
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
			}
			catch (Exception $e) {
				throw $e;
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

			} catch (Exception $e) {
				throw $e;
			}
		}

    }

 ?>
