<?php

    namespace DAO;

    use \Exception as Exception;
    use DAO\Connection as Connection;
    use DAO\IGenreDAO as IGenreDAO;
    use Models\Genre as Genre;

    class GenreDAO implements IGenreDAO {

        private $genreList = array();
        private $connection;
        private $tableName = "genres";

        public function add(Genre $genre) {
            try {
				$query = "CALL genres_add(?, ?)";
                $parameters["id_genre"] = $genre->getIdGenre();
                $parameters["name"] = $genre->getName();				
				$this->connection = Connection::GetInstance();
                $this->connection->executeNonQuery($query, $parameters, QueryType::StoredProcedure);
                return true;
			}catch (Exception $e) {
				return false;
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
				return false;
			}
        }
        
        public function getById(Genre $genre) {
            try {
                $genre = null;
                $query = "CALL genres_getById (?)";
                $parameters["id"] = $genre->getId();
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
                foreach($results as $row) {
                    $genre = new Genre();
                    $genre->setIdGenre($row["id_genre"]);
                    $genre->setName($row["name"]);
                }
                return $genre;    
            } catch (Exception $ex) {
                return false;
            }            
        }
            
        public function getByName(Genre $genre) {
            try {
                $genre = null;
                $query = "CALL genres_getByName (?)";
                $parameters["name"] = $genre->getName();
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
                foreach($results as $row) {
                    $genre = new Genre();
                    $genre->setIdGenre($row["id_genre"]);
                    $genre->setName($row["name"]);
                }
                return $genre;
            } catch (Exception $ex) {
                return false;
            }
        }
        
        public function getNameGenre(Genre $genre) {			
            try {						
                $genreName = "";
                $query = "CALL genres_getById(?)";
				$parameters["id"] = $genre->getIdGenre();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);			
				foreach($results as $row) {								
					$genreName = $row["name"];				
				}		
                return $genreName;
			}
			catch (Exception $ex) {
				return false;
			}	
		}

    }

?>