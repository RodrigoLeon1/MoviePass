<?php

    namespace DAO;

	use \Exception as Exception;
	use DAO\Connection as Connection;
	use DAO\IGenreToMovieDAO as IGenreToMovieDAO;
	use Models\Genre as Genre;
	use Models\GenreToMovie as GenreToMovie;
	use Models\Movie as Movie;

    class GenreToMovieDAO implements IGenreToMovieDAO {

		private $genreToMovieList = array();		
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
		
		//Recorre las peliculas de 'now playing' y carga sus respectivos generos en la bd
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
						$this->Add($genreMovie);												
                    }
                }
            }
		}
		
		//Dado una pelicula, obtiene sus generos de la API y los carga en la db
		public function getGenresOfMovieFromApi(Movie $movie) {
			$jsonPath = $jsonPath = MOVIE_DETAILS_PATH . $movie->getId() . "?api_key=" . API_N . "&language=en-US";
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();						
			
			$genreMovie = new GenreToMovie();
			$genreMovie->setIdMovie($movie->getId());
			$genres = $arrayToDecode["genres"];				
			foreach($genres as $genre) {
				$genreMovie->setIdGenre($genre["id"]);															
				$this->Add($genreMovie);				
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
				return false;
			}
		}
		
		public function getByGenre($id) {
			try {
				$movies = array();	
				$query = "CALL genresxmovies_getByGenre(?)";
				$parameters["id_genre"] = $id;
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);			
				foreach($results as $row) {
					$movie = new Movie();					
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
					// $movie->setRuntime($row["runtime"]);
					array_push($movies, $movie);
				}			
				return $movies;
			}
			catch (Exception $ex) {
				return false;
			}
		} 

		public function getByDate($date) {
			try {
				$movies = array();	
				$query = "CALL genresxmovies_getByDate(?)";
				$parameters["date"] = $date;
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);			
				foreach($results as $row) {
					$movie = new Movie();
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
					// $movie->setRuntime($row["runtime"]);
					array_push($movies, $movie);
				}			
				return $movies;
			}
			catch (Exception $ex) {
				return false;
			}
		} 		

		public function getByGenreAndDate($id, $date) {
			try {
				$movies = array();	
				$query = "CALL genresxmovies_getByGenreAndDate(?, ?)";
				$parameters["id_genre"] = $id;
				$parameters["date_show"] = $date;
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);			
				foreach($results as $row) {
					$movie = new Movie();
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
				foreach($results as $row) {				
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
				foreach($results as $row) {				
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