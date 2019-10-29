<?php

    namespace DAO;

	use \Exception as Exception;
	use DAO\Connection as Connection;
    use Models\User as User;
	use DAO\ProfileUserDAO as ProfileUserDAO;
	use DAO\RoleDAO as RoleDAO;

    class UserDAO {

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

		public function getByMail($mail) {
            $user = NULL;
            $query = "CALL users_getByMail (?)";
            $parameters["mail"] = $mail;
            $this->connection = Connection::GetInstance();
            $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
            foreach($results as $row) {
                $user = new User();
				$user = $this->profileUserDAO->getByDNI($row["FK_dni"]);
                $user->setMail($row["mail"]);
                $user->setPassword($row["password"]);
				$role = $this->roleDAO->getById($row["FK_id_role"]);
				$user->setRole($role);
            }
            return $user;
        }

		public function getAll() {
			$query = "SELECT * FROM " . $this->tableName;
			$this->connection = Connection::GetInstance();
			$results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
			foreach($results as $row) {
				$user = new User();
				$user->setMail($row["mail"]);
				array_push ($this->userList, $user);
			}
			return $this->userList;
		}

    }

 ?>
