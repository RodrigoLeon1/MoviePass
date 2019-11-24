<?php

    namespace DAO;

	use \Exception as Exception;
	use DAO\Connection as Connection;
	use DAO\ICinemaRoomDAO as ICinemaRoomDAO;
	use Models\CinemaRoom as CinemaRoom;
	use Models\Cinema as Cinema;
	use Models\Show as Show;

    class CinemaRoomDAO implements ICinemaRoomDAO {

        private $cinemaRoomList = array();
		private $connection;
		private $tableName = "cinema_rooms";

        public function add(CinemaRoom $cinemaRoom) {
			try {
				$query = "CALL cinema_rooms_add(?, ?, ?, ?)";
				$parameters["name"] = $cinemaRoom->getName();
				$parameters["capacity"] = $cinemaRoom->getCapacity();
				$parameters["price"] = $cinemaRoom->getPrice();
				$parameters["id_cinema"] = $cinemaRoom->getCinema()->getId();
                $this->connection = Connection::getInstance();
				$this->connection->executeNonQuery($query, $parameters, QueryType::StoredProcedure);
				return true;
			}
			catch (Exception $e) {
				return false;
			}
        }

        public function getAll() {
			try {								
				$query = "CALL cinemaRooms_GetAll()";
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
				foreach($results as $row) {
					$cinemaRoom = new CinemaRoom();
					$cinemaRoom->setId($row["cinema_room_id"]);
					$cinemaRoom->setName($row["cinema_room_name"]);
					$cinemaRoom->setCapacity($row["cinema_room_capacity"]);
					$cinemaRoom->setPrice($row["cinema_room_price"]);

					$cinema = new Cinema();
					$cinema->setId($row["cinema_id"]);
					$cinema->setName($row["cinema_name"]);
					$cinema->setAddress($row["cinema_address"]);

					$cinemaRoom->setCinema($cinema);

					array_push ($this->cinemaRoomList, $cinemaRoom);
				}				
				return $this->cinemaRoomList;
			}
			catch(Exception $e) {
				return false;
			}
		}
		
		public function deleteById(CinemaRoom $cinemaRoom) {
			try {
				$query = "CALL cinemaRooms_deleteById(?)";
				$parameters ["id"] = $cinemaRoom->getId();
				$this->connection = Connection::GetInstance();
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
				return true;
			}
			catch (Exception $e) {
				return false;
			}
		}
		
		public function getById(CinemaRoom $cinemaRoom) {
			try {
				$query = "CALL cinemaRooms_getById(?)";
				$parameters ["id"] = $cinemaRoom->getId();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
				
				$cinemaRoom = new CinemaRoom();
				foreach($results as $row) {
					$cinemaRoom->setId($row["id"]);
					$cinemaRoom->setName($row["name"]);
					$cinemaRoom->setCapacity($row["capacity"]);
					$cinemaRoom->setPrice($row["price"]);

					$cinema = new Cinema();
					$cinema->setId($row["FK_id_cinema"]);

					$cinemaRoom->setCinema($cinema);

				}
				return $cinemaRoom;
			}
			catch (Exception $e) {
				return false;
			}
		}

		public function checkRoomNameInCinema($name, $id_cinema) {
			try {
				$query = "CALL cinemaRooms_getByNameAndCinema(?, ?)";
				$parameters ["name"] = $name;
				$parameters ["id_cinema"] = $id_cinema;
				$this->connection = Connection::GetInstance();
				$results = $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
				
				return $results;
			}
			catch (Exception $e) {
				return false;
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
				return true;
			}
			catch (Exception $e) {
				return false;
			}
		}

		public function getByName(CinemaRoom $cinemaRoom) {
			try {								
				$query = "CALL cinemaRooms_getByName(?)";
				$parameters["name"] = $cinemaRoom->getName();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);				

				return $results;
			}
			catch (Exception $e) {
				return false;
			}			
		}

		public function getShowsOfCinemaRoom(CinemaRoom $cinemaRoom) {
			try {								
				$query = "CALL cinemaRooms_hasShows(?)";
				$parameters["id"] = $cinemaRoom->getId();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);				

				return $results;
			}
			catch (Exception $e) {
				return false;
			}
		}

		public function getByIdShow(Show $show) {
			try {
				$query = "CALL cinemaRooms_getByIdShow(?)";
				$parameters ["id_show"] = $show->getId();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
				
				$cinemaRoom = new CinemaRoom();
				foreach($results as $row) {					
					$cinemaRoom->setCapacity($row["capacity"]);
				}
				return $cinemaRoom;
			}
			catch (Exception $e) {
				return false;
			}
		}


		public function getSales(CinemaRoom $cinemaRoom) {
			try {								
				$query = "CALL tickets_getTicketsOfCinemaRoom(?)";
				$parameters["id_cinema"] = $cinemaRoom->getId();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);				
				
				$total = 0;
				
				foreach ($results as $values) {
					$total += $values["count_tickets"] * $values["price"];
				}				

				return $total;
			}
			catch (Exception $e) {
				return false;
			}
		}

    }

 ?>
