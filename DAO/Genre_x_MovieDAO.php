<?php

    namespace DAO;

	use Models\Genre_x_Movie as Genre_x_Movie;
	use Models\Movie as Movie;

    class Genre_x_MovieDAO {

        private $genre_x_MovieList = array();
        private $tableName = "genre_x_movie";

        public function Add(Genre_x_Movie $genre_x_movie) {
            try {
				$query = "CALL genres_x_movies(?, ?)";
                $parameters["id_genre"] = $genre_x_movie->getIdGenre();
                $parameters["id_movie"] = $genre_x_movie->getidMovie();
				
				$this->connection = Connection::GetInstance();
				$this->connection->executeNonQuery($query, $parameters, QueryType::StoredProcedure);
			}catch (Exception $e) {
				throw $ex;
			}
        }

        public function getAll() {
			try {
				$query = "SELECT * FROM " . $this->tableName;
				$this->connection = Connection::getInstance();
				$resultSet = $this->connection->execute($query);
				foreach ($resultSet as $row) {
					$genre_x_movie = new Genre_x_Movie ();
                    $genre_x_movie->setIdGenre($row["id_genre"]);
                    $genre_x_movie->setIdMovie($row["id_movie"]);
					
					array_push($this->genre_x_movieList, $genre_x_movie);
				}
				return $this->genreList;
			}
			catch (Exception $ex) {
				throw $ex;
			}
		}
		
		public function getByGenre($id) {
			$movies = array();
			$query = "CALL genrexmovie_getByGenre(?)";
			$parameters["id"] = $id;
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
				array_push($movies, $movie);
			}
			return $movies;
		} 
	}


?>