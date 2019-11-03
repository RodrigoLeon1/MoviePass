<?php

    namespace DAO;

	use \Exception as Exception;
	use DAO\Connection as Connection;
	use Models\GenreToMovie as GenreToMovie;
	use Models\Movie as Movie;

    class GenreToMovieDAO {

		private $genreToMovieList = array();		
        private $tableName = "genres_x_movies";

		/*
        public function Add(GenreToMovie $GenreToMovie) {
            try {
		 		$query = "CALL genres_x_movies(?, ?)";
                $parameters["id_genre"] = $GenreToMovie->getIdGenre();
                $parameters["id_movie"] = $GenreToMovie->getidMovie();
				
		 		$this->connection = Connection::GetInstance();
		 		$this->connection->executeNonQuery($query, $parameters, QueryType::StoredProcedure);
		 	} catch (Exception $e) {
				throw $ex;
			}
        }*/

		public function Add(GenreToMovie $genreToMovie) {
            try {
				$query = "INSERT INTO " . $this->tableName . " (FK_id_genre, FK_id_movie) VALUES (:FK_id_genre, :FK_id_movie);";
				$parameters["FK_id_genre"] = $genreToMovie->getIdGenre();
				$parameters["FK_id_movie"] = $genreToMovie->getIdMovie();
				$this->connection = Connection::getInstance();
				$this->connection->executeNonQuery($query, $parameters);
            }
            catch (Exception $e) {
                throw $e;
            }
        }

        public function infoMovie() {
            $jsonPath = NOW_PLAYING_PATH;
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
            foreach ($arrayToDecode as $valuesArray) {
                foreach ($valuesArray as $values) {
                    $genreMovie = new GenreToMovie();
                    $genreMovie->setIdMovie($values["id"]);
                    foreach($values["genre_ids"] as $genre) {
                        $genreMovie->setIdGenre($genre);
						$this->Add($genreMovie);						
                    }
                }
            }
        }

        public function getAll() {
			try {
				$query = "SELECT * FROM " . $this->tableName;
				$this->connection = Connection::getInstance();
				$resultSet = $this->connection->execute($query);
				foreach ($resultSet as $row) {
					$genreToMovie = new GenreToMovie ();
                    $genreToMovie->setIdGenre($row["id_genre"]);
                    $genreToMovie->setIdMovie($row["id_movie"]);
					
					array_push($this->genreToMovieList, $genreToMovie);
				}
				return $this->genreList;
			}
			catch (Exception $ex) {
				throw $ex;
			}
		}
		
		public function getByGenre($id) {
			$movies = array();	
			try {
				$query = "SELECT * FROM " . $this->tableName . " INNER JOIN movies ON FK_id_movie = movies.id 
																 INNER JOIN shows ON movies.id = shows.FK_id_movie
																 WHERE (FK_id_genre = :id_genre)
																 GROUP BY movies.id ";			
				$parameters["id_genre"] = $id;
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters);			
				foreach($results as $row) {
					$movie = new Movie();
					$movie->setId($row["FK_id_movie"]);
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
					array_push($movies, $movie);
				}			
			}
			catch (Exception $ex) {
				throw $ex;
			}
			return $movies;
		} 

		public function getByDate($date) {
			$movies = array();	
			try {
				$query = "SELECT * FROM " . $this->tableName . " INNER JOIN movies ON FK_id_movie = movies.id 
																 INNER JOIN shows ON movies.id = shows.FK_id_movie
																 WHERE (shows.date_start = :date)
																 GROUP BY movies.id ";			
				$parameters["date"] = $date;
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters);			
				foreach($results as $row) {
					$movie = new Movie();
					$movie->setId($row["FK_id_movie"]);
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
					array_push($movies, $movie);
				}			
			}
			catch (Exception $ex) {
				throw $ex;
			}
			return $movies;
		} 		

		public function getByGenreAndDate($id, $date) {
			$movies = array();	
			try {
				$query = "SELECT * FROM " . $this->tableName . " INNER JOIN movies ON FK_id_movie = movies.id 
																 INNER JOIN shows ON movies.id = shows.FK_id_movie
																 WHERE (FK_id_genre = :id_genre AND shows.date_start = :date)";		
				$parameters["id_genre"] = $id;
				$parameters["date"] = $date;
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters);			
				foreach($results as $row) {
					$movie = new Movie();
					$movie->setId($row["FK_id_movie"]);
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
					array_push($movies, $movie);
				}			
			}
			catch (Exception $ex) {
				throw $ex;
			}
			return $movies;
		}		

		public function getGenresOfMovie(Movie $movie) {
			$genres = array();
			try {
				$query = "SELECT * FROM " . $this->tableName . " INNER JOIN movies ON movies.id = FK_id_movie
																 INNER JOIN genres ON FK_id_genre = genres.id						
																 WHERE (FK_id_movie = :id_movie)";							
				$parameters["id_movie"] = $movie->getId();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters);			
				foreach($results as $row) {				
					$genre = $row["name"];
					array_push($genres, $genre);
				}	
			}
			catch (Exception $ex) {
				throw $ex;
			}		
			return $genres;
		}

		
		public function getNameGenre($id) {			
			$genreName = "";
			try {
				$query = "SELECT * FROM " . $this->tableName . " INNER JOIN genres ON FK_id_genre = genres.id						
																 WHERE (FK_id_genre = :id_genre)";			
				$parameters["id_genre"] = $id;
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters);			
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