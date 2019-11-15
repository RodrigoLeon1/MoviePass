<?php

    namespace DAO;

	use \Exception as Exception;
	use DAO\Connection as Connection;
    use Models\Cinema as Cinema;

    class CinemaDAO {

        private $cinemaList = array();
		private $connection;
		private $tableName = "cinemas";

        public function add(Cinema $cinema) {
			try {
				$query = "INSERT INTO " . $this->tableName . " (name, address) VALUES (:name, :address);";
				$parameters["name"] = $cinema->getName();
				$parameters["address"] = $cinema->getAddress();				
                $this->connection = Connection::getInstance();
				$this->connection->executeNonQuery($query, $parameters);
			}
			catch (Exception $e) {
				throw $e;
			}
        }

        public function getAll() {
			try {								
				$query = "CALL cinemas_GetAll()";
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
				foreach($results as $row) {
					$cinema = new Cinema();
					$cinema->setId($row["id"]);
					$cinema->setName($row["name"]);					
					$cinema->setAddress($row["address"]);
					array_push ($this->cinemaList, $cinema);
				}				
				return $this->cinemaList;
			}
			catch(Exception $e) {
				throw $e;
			}
		}

		public function deleteById($id) {
			try {
				$query = "CALL cinemas_deleteById(?)";
				$parameters ["id"] = $id;
				$this->connection = Connection::GetInstance();
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
			}
			catch (Exception $e) {
				throw $e;
			}
		}

		public function getById($id) {
			try {
				$query = "CALL cinemas_getById(?)";
				$parameters ["id"] = $id;
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
				
				$cinema = new Cinema();
				foreach($results as $row) {
					$cinema->setId($row["id"]);
					$cinema->setName($row["name"]);					
					$cinema->setAddress($row["address"]);
				}
				return $cinema;
			}
			catch (Exception $e) {
				throw $e;
			}
		}

		public function modify(Cinema $cinema) {
			try {
				$query = "CALL cinemas_modify(?, ?, ?)";
				$parameters["id"] = $cinema->getId();
				$parameters["name"] = $cinema->getName();				
				$parameters["address"] = $cinema->getAddress();
				$this->connection = Connection::getInstance();
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
			}
			catch (Exception $e) {
				throw $e;
			}
		}

		public function getByName(Cinema $cinema) {
			try {								
				$query = "CALL cinemas_getByName(?)";
				$parameters["name"] = $cinema->getName();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);				

				return $results;
			}
			catch (Exception $e) {
				throw $e;
			}			
		}

        // MODIFICAR??????????'
		public function getShowsOfCinema(Cinema $cinema) {
			try {								
				$query = "CALL cinemas_hasShows(?)";
				$parameters["id"] = $cinema->getId();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);				

				return $results;
			}
			catch (Exception $e) {
				throw $e;
			}
		}

    }

 ?>
