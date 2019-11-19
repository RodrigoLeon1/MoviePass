<?php

	namespace DAO;

	use \Exception as Exception;
	use DAO\Connection as Connection;
	use DAO\IRoleDAO as IRoleDAO;
	use Models\Role as Role;

	class RoleDAO implements IRoleDAO {

		private $roleList = array();
		private $connection;
		private $tableName = "roles";

		public function getById($id) {
            $user = NULL;
            $query = "CALL roles_getById(?)";
            $parameters["id"] = $id;
            $this->connection = Connection::GetInstance();
            $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
			foreach($results as $row) {
				$role = new Role();
                $role->setId($row["id"]);
                $role->setDescription($row["description"]);
            }
            return $role;
		}
		
		public function getAll() {
			try {								
				$query = "CALL roles_getAll()";
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
				foreach($results as $row) {
					$role = new Role();
					$role->setId($row["id"]);
					$role->setDescription($row["description"]);
					array_push ($this->roleList, $role);
				}				
				return $this->roleList;
			}
			catch(Exception $e) {
				throw $e;
			}
		}

	}
 ?>
