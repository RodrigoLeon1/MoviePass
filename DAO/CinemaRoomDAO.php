<?php

    namespace DAO;

	use \Exception as Exception;
	use DAO\Connection as Connection;
    use Models\CinemaRoom as CinemaRoom;

    class CinemaRoomDAO {

        private $cinemaRoomList = array();
		private $connection;
		private $tableName = "cinema_rooms";

        public function add(CinemaRoom $cinemaRoom) {
			try {
				$query = "INSERT INTO " . $this->tableName . " (name, capacity, price) VALUES (:name, :capacity, :price);";
				$parameters["name"] = $cinemaRoom->getName();
				$parameters["capacity"] = $cinemaRoom->getCapacity();
				$parameters["price"] = $cinemaRoom->getPrice();
                $this->connection = Connection::getInstance();
				$this->connection->executeNonQuery($query, $parameters);
			}
			catch (Exception $e) {
				throw $e;
			}
        }

        public function getAll() {
			try {								
				$query = "CALL cinemasRooms_GetAll()";
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
				foreach($results as $row) {
					$cinemaRoom = new CinemaRoom();
					$cinemaRoom->setId($row["id"]);
					$cinemaRoom->setName($row["name"]);
					$cinemaRoom->setCapacity($row["capacity"]);
					$cinemaRoom->setPrice($row["price"]);
					array_push ($this->cinemaRoomList, $cinemaRoom);
				}				
				return $this->cinemaRoomList;
			}
			catch(Exception $e) {
				throw $e;
			}
		}

		public function deleteById($id) {
			try {
				$query = "CALL cinemaRooms_deleteById(?)";
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
				$query = "CALL cinemaRooms_getById(?)";
				$parameters ["id"] = $id;
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
				
				$cinemaRoom = new CinemaRoom();
				foreach($results as $row) {
					$cinemaRoom->setId($row["id"]);
					$cinemaRoom->setName($row["name"]);
					$cinemaRoom->setCapacity($row["capacity"]);
					$cinemaRoom->setPrice($row["price"]);
				}
				return $cinemaRoom;
			}
			catch (Exception $e) {
				throw $e;
			}
		}

		public function modify(CinemaRoom $cinemaRoom) {
			try {
				$query = "CALL cinemaRooms_modify(?, ?, ?, ?)";
				$parameters["id"] = $cinemaRoom->getId();
				$parameters["name"] = $cinemaRoom->getName();
				$parameters["capacity"] = $cinemaRoom->getCapacity();
				$parameters["price"] = $cinemaRoom->getPrice();
				$this->connection = Connection::getInstance();
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
			}
			catch (Exception $e) {
				throw $e;
			}
		}

		public function getByName(CinemaRoom $cinemaRoom) {
			try {								
				$query = "CALL cinemaRooms_getByName(?)";
				$parameters["name"] = $cinema->getName();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);				

				return $results;
			}
			catch (Exception $e) {
				throw $e;
			}			
		}

		public function getShowsOfCinema(CinemaRoom $cinemaRoom) {
			try {								
				$query = "CALL cinemaRooms_hasShows(?)";
				$parameters["id"] = $cinemaRoom->getId();
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
