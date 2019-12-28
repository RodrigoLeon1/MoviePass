<?php

    namespace DAO;

	use \Exception as Exception;
	use Models\Show as Show;
	use Models\Genre as Genre;
	use Models\Movie as Movie;
	use Models\GenreToMovie as GenreToMovie;
	use DAO\QueryType as QueryType;
	use DAO\Connection as Connection;
	use DAO\IGenreToMovieDAO as IGenreToMovieDAO;

    class GenreToMovieDAO implements IGenreToMovieDAO {

		private $genreToMovieList = array();		
		private $connection;
        private $tableName = "genres_x_movies";

		public function add(GenreToMovie $genreToMovie) {
            try {				
				$query = "CALL genresxmovies_add(?, ?)";
				$parameters["FK_id_genre"] = $genreToMovie->getIdGenre();
				$parameters["FK_id_movie"] = $genreToMovie->getIdMovie();
				$this->connection = Connection::getInstance();
				$this->connection->executeNonQuery($query, $parameters, QueryType::StoredProcedure);
				return true;
            }
            catch (Exception $e) {
                return false;
            }
        }
		
		// Go over the movies of 'now playing' and add their genres into the db		
        public function getGenresOfNowPlaying() {
            $jsonPath = NOW_PLAYING_PATH;
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
            foreach ($arrayToDecode as $valuesArray) {
                foreach ($valuesArray as $values) {
                    $genreMovie = new GenreToMovie();
                    $genreMovie->setIdMovie($values["id"]);
                    foreach($values["genre_ids"] as $genre) {
                        $genreMovie->setIdGenre($genre);
						$this->add($genreMovie);												
                    }
                }
			}
			return true;
		}
		
		// Given a movie, gets their genres from the db and add into the db		
		public function getGenresOfMovieFromApi(Movie $movie) {
			$jsonPath = $jsonPath = MOVIE_DETAILS_PATH . $movie->getId() . "?api_key=" . API_N . "&language=en-US";
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();									
			$genreMovie = new GenreToMovie();
			$genreMovie->setIdMovie($movie->getId());
			$genres = $arrayToDecode["genres"];				
			foreach ($genres as $genre) {
				$genreMovie->setIdGenre($genre["id"]);															
				$this->add($genreMovie);				
			}
			return true;
		}

        public function getAll() {
			try {
				$query = "CALL genresxmovies_getAll()";								
				$this->connection = Connection::getInstance();
				$resultSet = $this->connection->execute($query, array(), QueryType::StoredProcedure);
				foreach ($resultSet as $row) {
					$genreToMovie = new GenreToMovie ();
                    $genreToMovie->setIdGenre($row["id_genre"]);
                    $genreToMovie->setIdMovie($row["id_movie"]);					
					array_push($this->genreToMovieList, $genreToMovie);
				}
				return $this->genreList;
			}
			catch (Exception $ex) {
				return false;
			}
		}
		
		public function getByGenre(Genre $genre) {
			try {
				$movies = array();	
				$query = "CALL genresxmovies_getByGenre(?)";
				$parameters["id_genre"] = $genre->getIdGenre();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);			
				foreach ($results as $row) {
					$movie = new Movie();					
					$movie->setId($row["id"]);					
					$movie->setPosterPath($row["poster_path"]);					
					$movie->setBackdropPath($row["backdrop_path"]);										
					$movie->setTitle($row["title"]);
					$movie->setVoteAverage($row["vote_average"]);
					$movie->setOverview($row["overview"]);
					$movie->setReleaseDate($row["release_date"]);					
					array_push($movies, $movie);
				}			
				return $movies;
			}
			catch (Exception $ex) {
				return false;
			}
		} 

		public function getByDate(Show $show) {
			try {
				$movies = array();	
				$query = "CALL genresxmovies_getByDate(?)";
				$parameters["date"] = $show->getDateStart();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);			
				foreach ($results as $row) {
					$movie = new Movie();
					$movie->setId($row["id"]);					
					$movie->setPosterPath($row["poster_path"]);					
					$movie->setBackdropPath($row["backdrop_path"]);										
					$movie->setTitle($row["title"]);
					$movie->setVoteAverage($row["vote_average"]);
					$movie->setOverview($row["overview"]);
					$movie->setReleaseDate($row["release_date"]);					
					array_push($movies, $movie);
				}			
				return $movies;
			}
			catch (Exception $ex) {
				return false;
			}
		} 		

		// fix?
		public function getByGenreAndDate(Genre $genre, Show $show) {
			try {
				$movies = array();	
				$query = "CALL genresxmovies_getByGenreAndDate(?, ?)";
				$parameters["id_genre"] = $genre->getIdGenre();
				$parameters["date_show"] = $show->getDateStart();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);			
				// var_dump($results);
				foreach ($results as $row) {
					$movie = new Movie();
					$movie->setId($row["id"]);					
					$movie->setPosterPath($row["poster_path"]);					
					$movie->setBackdropPath($row["backdrop_path"]);							
					$movie->setTitle($row["title"]);
					$movie->setVoteAverage($row["vote_average"]);
					$movie->setOverview($row["overview"]);
					$movie->setReleaseDate($row["release_date"]);					
					array_push($movies, $movie);
				}							
				return $movies;
			}
			catch (Exception $ex) {				
				return false;
			}
		}		

		public function getGenresOfMovie(Movie $movie) {
			try {						
				$genres = array();
				$query = "CALL genresxmovies_getGenresOfMovie(?)";
				$parameters["id_movie"] = $movie->getId();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);			
				foreach ($results as $row) {				
					$genre = $row["name"];
					array_push($genres, $genre);
				}	
				return $genres;
			}
			catch (Exception $ex) {
				return false;
			}		
		}	

		public function getGenresOfShows() {
			try {							
				$genres = array();
				$query = "CALL genresxmovies_getGenresOfShows()";				
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);			
				foreach ($results as $row) {				
					$genre = new Genre();
                    $genre->setIdGenre($row["id"]);
					$genre->setName($row["name"]);
					array_push($genres, $genre);
				}	
				return $genres;			
			}
			catch (Exception $ex) {
				return false;
			}		
		}
	}

?>