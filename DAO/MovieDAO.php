<?php

    namespace DAO;

	use \Exception as Exception;
	use DAO\Connection as Connection;
	use Models\Movie as Movie;

    class MovieDAO {

		private $movieList = array();		
		private $upcoming = array();
		private $tableName = "movies";

		public function add(Movie $movie) {
			try {
				$query = "CALL movies_add(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$parameters["id"] = $movie->getId();
				$parameters["popularity"] = $movie->getPopularity();
				$parameters["vote_count"] = $movie->getVoteCount();
				$parameters["video"] = $movie->getVideo();
				$parameters["poster_path"] = $movie->getPosterPath();
				$parameters["adult"] = $movie->getAdult();
				$parameters["backdrop_path"] = $movie->getBackdropPath();
				$parameters["original_language"] = $movie->getOriginalLanguage();
				$parameters["original_title"] = $movie->getOriginalTitle();
				$parameters["genre_ids"] = $movie->getGenreIds();
				$parameters["title"] = $movie->getTitle();
				$parameters["vote_average"] = $movie->getVoteAverage();
				$parameters["overview"] = $movie->getOverview();
				$parameters["release_date"] = $movie->getReleaseDate();
				$this->connection = Connection::GetInstance();
				$this->connection->executeNonQuery($query, $parameters, QueryType::StoredProcedure);				
			}
			catch (Exception $e) {
				throw $ex;
			}
        }

		// Tambien agrega el runtime
		public function addMovie(Movie $movie) {
			try {				
				$query = "CALL movies_add_details(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$parameters["id"] = $movie->getId();
				$parameters["popularity"] = $movie->getPopularity();
				$parameters["vote_count"] = $movie->getVoteCount();
				$parameters["video"] = $movie->getVideo();
				$parameters["poster_path"] = $movie->getPosterPath();
				$parameters["adult"] = $movie->getAdult();
				$parameters["backdrop_path"] = $movie->getBackdropPath();
				$parameters["original_language"] = $movie->getOriginalLanguage();
				$parameters["original_title"] = $movie->getOriginalTitle();	
				// $parameters["genre_ids"] = $movie->getGenreIds();			
				$parameters["title"] = $movie->getTitle();
				$parameters["vote_average"] = $movie->getVoteAverage();
				$parameters["overview"] = $movie->getOverview();
				$parameters["release_date"] = $movie->getReleaseDate();
				$parameters["runtime"] = $movie->getRuntime();
				$this->connection = Connection::GetInstance();				
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);							
			}
			catch (Exception $ex) {
				throw $ex;
			}			
		}

        public function getAll() {
			try {				
				$query = "CALL movies_getAll()";
				$this->connection = Connection::getInstance();				
				$resultSet = $this->connection->execute($query, array(), QueryType::StoredProcedure);
				foreach ($resultSet as $row) {
					$movie = new Movie ();
					$movie->setId($row["id"]);
					$movie->setPopularity($row["popularity"]);
					$movie->setVoteCount($row["vote_count"]);
					$movie->setVideo($row["video"]);
					$movie->setPosterPath($row["poster_path"]);
					$movie->setAdult($row["adult"]);
					$movie->setBackdropPath($row["backdrop_path"]);
					$movie->setOriginalLanguage($row["original_language"]);
					$movie->setOriginalTitle($row["original_title"]);
					$movie->setGenreIds($row["genre_ids"]);
					$movie->setTitle($row["title"]);
					$movie->setVoteAverage($row["vote_average"]);
					$movie->setOverview($row["overview"]);
					$movie->setReleaseDate($row["release_date"]);
					$movie->setRuntime($row["runtime"]);
					array_push($this->movieList, $movie);
				}
				return $this->movieList;
			}
			catch (Exception $ex) {
				throw $ex;
			}
        }

		public function getNowPlayingMoviesFromDAO() {
            $jsonPath = NOW_PLAYING_PATH;
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
            foreach ($arrayToDecode as $valuesArray) {
				foreach ($valuesArray as $values) {
					$movie = new Movie();
					$movie->setPopularity($values["popularity"]);
					$movie->setVoteCount($values["vote_count"]);
					$movie->setVideo($values["video"]);
					$movie->setPosterPath($values["poster_path"]);
					$movie->setId($values["id"]);
					$movie->setAdult($values["adult"]);
					$movie->setBackdropPath($values["backdrop_path"]);
					$movie->setOriginalLanguage($values["original_language"]);
					$movie->setOriginalTitle($values["original_title"]);
					$movie->setGenreIds($values["genre_ids"]);
					$movie->setTitle($values["title"]);
					$movie->setVoteAverage($values["vote_average"]);
					$movie->setOverview($values["overview"]);
					$movie->setReleaseDate($values["release_date"]);
					$this->add($movie);
				}
            }
		}

		public function getRunTimeMovieFromDAO () {
			try {
				$query = "SELECT id FROM " . $this->tableName;
				$this->connection = Connection::getInstance();
				$resultSet = $this->connection->execute($query);
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
				throw $ex;
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
				$movie->setPopularity($arrayToDecode["popularity"]);
				$movie->setVoteCount($arrayToDecode["vote_count"]);
				$movie->setVideo($arrayToDecode["video"]);
				$movie->setPosterPath($arrayToDecode["poster_path"]);
				$movie->setId($arrayToDecode["id"]);
				$movie->setAdult($arrayToDecode["adult"]);
				$movie->setBackdropPath($arrayToDecode["backdrop_path"]);
				$movie->setOriginalLanguage($arrayToDecode["original_language"]);
				$movie->setOriginalTitle($arrayToDecode["original_title"]);	
				$movie->setGenreIds($arrayToDecode["genres"]);
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

		// PASAR A OBJ
		public function getById($id) {
			try {
				$query = "CALL movies_getById(?)";
				$parameters ["id"] = $id;
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
				$movie = new Movie();
				foreach ($results as $values) {
					$movie->setPopularity($values["popularity"]);
					$movie->setVoteCount($values["vote_count"]);
					$movie->setVideo($values["video"]);
					$movie->setPosterPath($values["poster_path"]);
					$movie->setId($values["id"]);
					$movie->setAdult($values["adult"]);
					$movie->setBackdropPath($values["backdrop_path"]);
					$movie->setOriginalLanguage($values["original_language"]);
					$movie->setOriginalTitle($values["original_title"]);
					$movie->setGenreIds($values["genre_ids"]);
					$movie->setTitle($values["title"]);
					$movie->setVoteAverage($values["vote_average"]);
					$movie->setOverview($values["overview"]);
					$movie->setReleaseDate($values["release_date"]);
					$movie->setRuntime($values["runtime"]);
				}
				return $movie;
			}
			catch (Exception $e) {
				throw $e;
			}
		}

		public function getByTitle(Movie $movie) {
			try {
				$movies = array();
				$query = "CALL movies_getByTitle(?)";
				$parameters ["title"] = $movie->getTitle();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
				$movie = new Movie();
				foreach ($results as $values) {
					$movie->setId($values["movie_id"]);
				}
				return $movie;
			}
			catch (Exception $e) {
				throw $e;
			}
		}		

		// PASAR A OBJ
		public function existMovie($movie) {
			try {
				$query = "CALL movies_getById(?)";
				$parameters ["id"] = $movie->getId();
				$this->connection = Connection::GetInstance();
				return $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);				
			}
			catch (Exception $e) {
				throw $e;
			}
		}

		public function deleteById(Movie $movie) {
			try {				
				$query = "CALL movies_deleteById(?)";
				$parameters ["id"] = $movie->getId();
				$this->connection = Connection::GetInstance();
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
			}
			catch (Exception $e) {
				throw $e;
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
				throw $e;
			}
		}

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
				throw $e;
			}
		}

    }

 ?>
