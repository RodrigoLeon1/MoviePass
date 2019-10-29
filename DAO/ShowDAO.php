<?php

    namespace DAO;

	use \Exception as Exception;
	use DAO\Connection as Connection;
	use DAO\MovieDAO as MovieDAO;
    use Models\Show as Show;
    use Models\Movie as Movie;
    use Models\Cinema as Cinema;

    class ShowDAO {

        private $showList = array();
        private $moviesOnShowList = array();
		private $tableName = "shows";
		private $movieDAO;

		public function __construct () {
			$this->movieDAO = new MovieDAO ();
		}

        public function add(Show $show) {
			try {
				$query = "INSERT INTO " . $this->tableName . " (FK_id_cinema, FK_id_movie, date, time) VALUES (:FK_id_cinema, :FK_id_movie, :date, :time);";
				$parameters["FK_id_cinema"] = $show->getCinema()->getId();
				$parameters["FK_id_movie"] = $show->getMovie()->getId();
                $parameters["date"] = $show->getDate();
                $parameters["time"] = $show->getTime();
                $this->connection = Connection::getInstance();
				$this->connection->executeNonQuery($query, $parameters);
			}
			catch (Exception $e) {
				throw $e;
			}
        }

        public function getAll () {
			$query = "CALL shows_getAll";
            $this->connection = Connection::GetInstance();
            $results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
            foreach($results as $row) {
				$movie = new Movie ();
				$movie->setId($row["movies_now_playing_id"]);
				$movie->setTitle($row["movies_now_playing_title"]);
				$cinema = new Cinema();
				$cinema->setId($row["cinemas_id"]);
				$cinema->setName($row["cinemas_name"]);
				$show = new Show ();
				$show->setId($row["shows_id"]);
				$show->setDate($row["shows_date"]);
				$show->setTime($row["shows_time"]);
				$show->setMovie($movie);
				$show->setCinema($cinema);
				array_push ($this->showList, $show);
            }
            return $this->showList;
		}

		public function deleteById ($id) {
			try {
				$query = "CALL shows_deleteById(?)";
				$parameters ["id"] = $id;
				$this->connection = Connection::GetInstance();
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
			}
			catch (Exception $e) {
				throw $e;
			}
		}

		public function getById ($id) {
			try {
				$query = "CALL shows_getById(?)";
				$parameters ["id"] = $id;
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
				$show = new Show();
				foreach($results as $row) {
					$movie = new Movie ();
					$movie->setId($row["movies_now_playing_id"]);
					$movie->setTitle($row["movies_now_playing_title"]);
					$cinema = new Cinema();
					$cinema->setId($row["cinemas_id"]);
					$cinema->setName($row["cinemas_name"]);
					$show->setId($row["shows_id"]);
					$show->setDate($row["shows_date"]);
					$show->setTime($row["shows_time"]);
					$show->setMovie($movie);
					$show->setCinema($cinema);
				}
				return $show;
			}
			catch (Exception $e) {
				throw $e;
			}
		}

		public function modify(Show $show) {
			try {
				$query = "CALL shows_modify(?, ?, ?, ?, ?)";
				$parameters["id"] = $show->getId();
				$parameters["id_cinema"] = $show->getCinema()->getId();
				$parameters["id_movie"] = $show->getMovie()->getId();
				$parameters["date"] = $show->getDate();
				$parameters["time"] = $show->getTime();
				$this->connection = Connection::getInstance();
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
			}
			catch (Exception $e) {
				throw $e;
			}
		}

		public function moviesOnShow () {
			$this->getAll();
			foreach ($this->showList as $show) {
				$id = $show->getMovie()->getId();
				if($this->getMoviesIdWithoutRepeating($id)) {
					$movie = $this->movieDAO->getById($id);
					array_push($this->moviesOnShowList, $movie);
				}
			}
			return $this->moviesOnShowList;
		}

		public function getMoviesIdWithoutRepeating($id) {
			if (count ($this->moviesOnShowList) == 0) {
				return 1;
			}
			else {
				foreach ($this->moviesOnShowList as $movie) {
					if ($movie->getId() == $id) {
						return 0;
					}
				}
				return 1;
			}
		}


	}

 ?>
