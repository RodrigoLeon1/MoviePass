<?php

    namespace DAO;

    use Models\Movie as Movie;

    class MovieDAO {

		private $movieList = array();
		private $tableName = "movies_now_playing";

		public function add(Movie $movie) {
			// try {
				$query = "CALL movies_add_now_playing(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
			// }
			// catch (Exception $e) {
				// throw $ex;
			// }
        }

        public function getAll() {
			try {
				$cellList = array ();
				$query = "SELECT * FROM " . $this->tableName;
				$this->connection = Connection::getInstance();
				$resultSet = $this->connection->execute($query);
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
		
		public function getKeyMovieTrailer($idMovie) {			
			$jsonPath = MOVIE_DETAILS_PATH . $idMovie . "/videos?api_key=" . API_N . "&language=en-US";
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
					
					$movie->setRuntime($values["runtime"]);
					
				}
            }
		}

		//problemas aca
		public function getComingSoonMovies() {
			$comingSoonMovies = array();
            $jsonPath = COMING_SOON_PATH;
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
					// $this->add($movie);
					array_push($comingSoonMovies, $movie);
				}
			}			
			return $comingSoonMovies;
		}
    }

 ?>
