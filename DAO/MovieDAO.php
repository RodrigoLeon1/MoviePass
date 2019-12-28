<?php

    namespace DAO;

	use \Exception as Exception;
	use Models\Movie as Movie;
	use DAO\IMovieDAO as IMovieDAO;
	use DAO\QueryType as QueryType;
	use DAO\Connection as Connection;

    class MovieDAO implements IMovieDAO {

		private $movieList = array();		
		private $upcoming = array();
		private $tableName = "movies";
		private $connection;

		public function add(Movie $movie) {
			try {
				$query = "CALL movies_add(?, ?, ?, ?, ?, ?, ?, ?)"; 
				$parameters["id"] = $movie->getId();				
				$parameters["poster_path"] = $movie->getPosterPath();				
				$parameters["backdrop_path"] = $movie->getBackdropPath();												
				$parameters["title"] = $movie->getTitle();
				$parameters["vote_average"] = $movie->getVoteAverage();
				$parameters["overview"] = $movie->getOverview();
				$parameters["release_date"] = $movie->getReleaseDate();
				$this->connection = Connection::GetInstance();
				$this->connection->executeNonQuery($query, $parameters, QueryType::StoredProcedure);
				return true;				
			}
			catch (Exception $e) {
				return false;
			}
        }

		// Also, add the runtime
		public function addMovie(Movie $movie) {
			try {				
				$query = "CALL movies_add_details(?, ?, ?, ?, ?, ?, ?, ?)";
				$parameters["id"] = $movie->getId();				
				$parameters["poster_path"] = $movie->getPosterPath();				
				$parameters["backdrop_path"] = $movie->getBackdropPath();														
				$parameters["title"] = $movie->getTitle();
				$parameters["vote_average"] = $movie->getVoteAverage();
				$parameters["overview"] = $movie->getOverview();
				$parameters["release_date"] = $movie->getReleaseDate();
				$parameters["runtime"] = $movie->getRuntime();
				$this->connection = Connection::GetInstance();				
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
				return true;							
			}
			catch (Exception $ex) {
				return false;
			}			
		}

        public function getAll() {
			try {				
				$query = "CALL movies_getAll()";
				$this->connection = Connection::getInstance();				
				$resultSet = $this->connection->execute($query, array(), QueryType::StoredProcedure);
				foreach ($resultSet as $row) {
					$movie = new Movie();
					$movie->setId($row["id"]);					
					$movie->setPosterPath($row["poster_path"]);					
					$movie->setBackdropPath($row["backdrop_path"]);														
					$movie->setTitle($row["title"]);
					$movie->setVoteAverage($row["vote_average"]);
					$movie->setOverview($row["overview"]);
					$movie->setReleaseDate($row["release_date"]);
					$movie->setRuntime($row["runtime"]);
					$movie->setIsActive($row["is_active"]);
					array_push($this->movieList, $movie);
				}
				return $this->movieList;
			}
			catch (Exception $ex) {
				return false;
			}
		}

		public function getCount() {
			try {				
				$query = "SELECT count(*) AS total FROM " . $this->tableName;
				$this->connection = Connection::getInstance();				
				$results = $this->connection->execute($query, array());								
				foreach ($results as $row) {
					return $row["total"];
				}
			}
			catch (Exception $ex) {
				return false;
			}
		}

		public function getMoviesWithLimit($start) {
			try {				
				$query = "SELECT * FROM " . $this->tableName . " ORDER BY title ASC LIMIT " . $start . "," . MAX_ITEMS_PAGE;
				$this->connection = Connection::getInstance();				
				$resultSet = $this->connection->execute($query, array());
				foreach ($resultSet as $row) {
					$movie = new Movie();
					$movie->setId($row["id"]);					
					$movie->setPosterPath($row["poster_path"]);					
					$movie->setBackdropPath($row["backdrop_path"]);														
					$movie->setTitle($row["title"]);
					$movie->setVoteAverage($row["vote_average"]);
					$movie->setOverview($row["overview"]);
					$movie->setReleaseDate($row["release_date"]);
					$movie->setRuntime($row["runtime"]);
					$movie->setIsActive($row["is_active"]);
					array_push($this->movieList, $movie);
				}
				return $this->movieList;
			}
			catch (Exception $ex) {
				return false;
			}
		}
		
		public function getAllActives() {
			try {				
				$query = "CALL movies_getAllActives()";
				$this->connection = Connection::getInstance();				
				$resultSet = $this->connection->execute($query, array(), QueryType::StoredProcedure);
				foreach ($resultSet as $row) {
					$movie = new Movie();
					$movie->setId($row["id"]);					
					$movie->setPosterPath($row["poster_path"]);					
					$movie->setBackdropPath($row["backdrop_path"]);														
					$movie->setTitle($row["title"]);
					$movie->setVoteAverage($row["vote_average"]);
					$movie->setOverview($row["overview"]);
					$movie->setReleaseDate($row["release_date"]);
					$movie->setRuntime($row["runtime"]);
					$movie->setIsActive($row["is_active"]);
					array_push($this->movieList, $movie);
				}
				return $this->movieList;
			}
			catch (Exception $ex) {
				return false;
			}
        }

		public function getNowPlayingMoviesFromDAO() {
            $jsonPath = NOW_PLAYING_PATH;
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
            foreach ($arrayToDecode as $valuesArray) {
				foreach ($valuesArray as $values) {
					$movie = new Movie();					
					$movie->setPosterPath($values["poster_path"]);
					$movie->setId($values["id"]);					
					$movie->setBackdropPath($values["backdrop_path"]);															
					$movie->setTitle($values["title"]);
					$movie->setVoteAverage($values["vote_average"]);
					$movie->setOverview($values["overview"]);
					$movie->setReleaseDate($values["release_date"]);
					$this->add($movie);
				}
            }
		}

		public function getRunTimeMovieFromDAO() {
			try {				
				$query = "CALL movies_getId()";
				$this->connection = Connection::getInstance();
				$resultSet = $this->connection->execute($query, array(), QueryType::StoredProcedure);
				foreach ($resultSet as $row) {
					$jsonPath = MOVIE_DETAILS_PATH . $row["id"] . "?api_key=" . API_N . URL_API_LANGUAGE;
					$jsonContent = file_get_contents($jsonPath);
					$arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
					$query = "CALL movies_add_runtime (?, ?)";
					$parameters["id"] = $row["id"];
					$parameters["runtime"] = $arrayToDecode["runtime"];
					$this->connection = Connection::GetInstance();
					$this->connection->executeNonQuery($query, $parameters, QueryType::StoredProcedure);
				}
			}
			catch (Exception $ex) {
				return false;
			}

		}

		public function getKeyMovieTrailer(Movie $movie) {
			$jsonPath = MOVIE_DETAILS_PATH . $movie->getId() . "/videos?api_key=" . API_N . "&language=en-US";
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
			foreach ($arrayToDecode as $valuesArray) {
				$key = $valuesArray[0]["key"];
			}
			return $key;
        }

		public function getMovieDetailsById(Movie $movie) {
			$jsonPath = MOVIE_DETAILS_PATH . $movie->getId() . "?api_key=" . API_N . "&language=en-US";
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $valuesArray) {	
				$movie = new Movie();				
				$movie->setPosterPath($arrayToDecode["poster_path"]);
				$movie->setId($arrayToDecode["id"]);				
				$movie->setBackdropPath($arrayToDecode["backdrop_path"]);												
				$movie->setTitle($arrayToDecode["title"]);
				$movie->setVoteAverage($arrayToDecode["vote_average"]);
				$movie->setOverview($arrayToDecode["overview"]);
				$movie->setReleaseDate($arrayToDecode["release_date"]);
				$movie->setRuntime($arrayToDecode["runtime"]);
				
				return $movie;				
			}
		}
		
		public function getComingSoonMovies() {		
			$movies = array();
			$jsonPath = COMING_SOON_PATH;

            $jsonContent = file_get_contents($jsonPath);
			$arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();	

            foreach ($arrayToDecode["results"] as $valuesArray) {												
				$movie = new Movie();										
				$movie->setId($valuesArray["id"]);
				$movie->setPosterPath($valuesArray["poster_path"]);
				$movie->setTitle($valuesArray["title"]);
				$movie->setVoteAverage($valuesArray["vote_average"]);
				$movie->setOverview($valuesArray["overview"]);		
				$movie->setReleaseDate($valuesArray["release_date"]);					
				array_push($movies, $movie);
			}			

			return $movies;
		}
			
		public function getById(Movie $movie) {
			try {
				$query = "CALL movies_getById(?)";
				$parameters ["id"] = $movie->getId();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
				foreach ($results as $values) {					
					$movie = new Movie();
					$movie->setId($values["id"]);
					$movie->setPosterPath($values["poster_path"]);					
					$movie->setBackdropPath($values["backdrop_path"]);														
					$movie->setTitle($values["title"]);
					$movie->setVoteAverage($values["vote_average"]);
					$movie->setOverview($values["overview"]);
					$movie->setReleaseDate($values["release_date"]);
					$movie->setRuntime($values["runtime"]);
					$movie->setIsActive($values["is_active"]);
				}
				return $movie;
			}
			catch (Exception $e) {
				return false;
			}
		}

		public function getByTitle(Movie $movie) {
			try {
				$movies = array();
				$query = "CALL movies_getByTitle(?)";
				$parameters ["title"] = $movie->getTitle();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);				
				foreach ($results as $values) {
					$movie = new Movie();
					$movie->setId($values["movie_id"]);					
					$movie->setTitle($values["movie_title"]);
					$movie->setPosterPath($values["movie_poster_path"]);										
					$movie->setVoteAverage($values["movie_vote_average"]);
					$movie->setOverview($values["movie_overview"]);
					array_push($movies, $movie);
				}
				return $movies;
			}
			catch (Exception $e) {
				return false;
			}
		}				

		public function existMovie(Movie $movie) {
			try {
				$query = "CALL movies_getById(?)";
				$parameters ["id"] = $movie->getId();
				$this->connection = Connection::GetInstance();
				return $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);				
				return true;
			}
			catch (Exception $e) {
				return false;
			}
		}
		
		public function enableById(Movie $movie) {
			try {				
				$query = "CALL movies_enableById(?)";
				$parameters ["id"] = $movie->getId();
				$this->connection = Connection::GetInstance();
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
				return true;
			}
			catch (Exception $e) {
				return false;
			}
		}

		public function disableById(Movie $movie) {
			try {				
				$query = "CALL movies_disableById(?)";
				$parameters ["id"] = $movie->getId();
				$this->connection = Connection::GetInstance();
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
				return true;
			}
			catch (Exception $e) {
				return false;
			}
		}

		public function getShowsOfMovie(Movie $movie) {
			try {								
				$query = "CALL movies_hasShows(?)";
				$parameters["id_movie"] = $movie->getId();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);				
				return $results;
			}
			catch (Exception $e) {
				return false;
			}
		}

		// pasar a controladora
		public function getSales(Movie $movie) {
			try {								
				$query = "CALL tickets_getTicketsOfMovie(?)";
				$parameters["id_movie"] = $movie->getId();
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
