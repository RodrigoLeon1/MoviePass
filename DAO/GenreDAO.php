<?php

    namespace DAO;

    use \Exception as Exception;
    use DAO\Connection as Connection;
    use Models\Genre as Genre;

    class GenreDAO {

        private $genreList = array();
        private $tableName = "genres";

        public function Add(Genre $genre) {
            try {
				$query = "CALL genres(?, ?)";
                $parameters["id_genre"] = $genre->getIdGenre();
                $parameters["name"] = $genre->getName();
				
				$this->connection = Connection::GetInstance();
				$this->connection->executeNonQuery($query, $parameters, QueryType::StoredProcedure);
			}catch (Exception $e) {
				throw $ex;
			}
        }

        public function getAll() {
			try {                
                $query = "CALL genres_GetAll()";
				$this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($query, array(), QueryType::StoredProcedure);
				foreach ($resultSet as $row) {
					$genre = new Genre();
                    $genre->setIdGenre($row["id"]);
                    $genre->setName($row["name"]);
					
					array_push($this->genreList, $genre);
                }
				return $this->genreList;
			}
			catch (Exception $ex) {
				throw $ex;
			}
        }

        public function getById($id) {
            $genre = NULL;
            $query = "CALL genres_getById (?)";
            $parameters["id"] = $id;
            $this->connection = Connection::GetInstance();
            $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
            foreach($results as $row) {
                $genre = new Genre();
                $genre->setIdGenre($row["id_genre"]);
                $genre->setName($row["name"]);
            }
            return $genre;
        }
    
        public function getByName($name) {
            $genre = NULL;
            $query = "CALL genres_getByName (?)";
            $parameters["name"] = $name;
            $this->connection = Connection::GetInstance();
            $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
            foreach($results as $row) {
                $genre = new Genre();
                $genre->setIdGenre($row["id_genre"]);
                $genre->setName($row["name"]);
            }
            return $genre;
        }

        public function getNameGenre($id) {			
			$genreName = "";
			try {						
                $query = "CALL genres_getById(?)";
				$parameters["id"] = $id;
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);			
				foreach($results as $row) {								
					$genreName = $row["name"];				
				}		
			}
			catch (Exception $ex) {
				throw $ex;
			}	
			return $genreName;
		}


    }

?>