<?php

	namespace DAO;

	use \Exception as Exception;
	use DAO\Connection as Connection;
	use Models\Role as Role;

	class RoleDAO {

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
	}
 ?>
