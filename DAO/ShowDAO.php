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
			$this->movieDAO = new MovieDAO();
		}

        public function add(Show $show) {
			try {			
				$query = "INSERT INTO " . $this->tableName . " (FK_id_cinema, FK_id_movie, date_start, time_start, date_end, time_end) VALUES (:FK_id_cinema, :FK_id_movie, :date_start, :time_start, :date_end, :time_end);";
				$parameters["FK_id_cinema"] = $show->getCinema()->getId();
				$parameters["FK_id_movie"] = $show->getMovie()->getId();
				$parameters["date_start"] = $show->getDateStart();
				$parameters["time_start"] = $show->getTimeStart();
				$parameters["date_end"] = $show->getDateEnd();
				$parameters["time_end"] = $show->getTimeEnd();
				$this->connection = Connection::getInstance();
				$this->connection->executeNonQuery($query, $parameters);				
			}
			catch (Exception $e) {
				throw $e;
			}
        }

		/*
		public function checkPlace (Show $show) {
			$this->getAll();
			if ($this->showList != null) {
				foreach ($this->showList as $showList) {
					if ($showList->getMovie()->getId() == $show->getMovie()->getId()) {
						if ($showList->getDateStart() == $show->getDateStart()) {
							return 0;
						}
					}
				}
			}
			return 1;
		}

		public function appendTime ($show) {
			$movie = $this->movieDAO->getById($show->getMovie()->getId()); // Get Movie On Show In Order To Get It's Runtime
			//Modify Time Lapse
			$timeStart = strtotime ("-15 minutes", strtotime($show->getDateStart() . $show->getTimeStart()));
			$plusRunTime = "+" . $movie->getRuntime() . " minutes";
			$timeEnd = strtotime ($plusRunTime, strtotime($show->getDateStart() . $show->getTimeStart()));
			$timeEnd += strtotime ("+15 minutes", strtotime($timeEnd));
			// Assign time to paramenters
			$show->setDateStart(date ('Y-m-d', $timeStart));
			$show->setTimeStart(date ('H:i:s', $timeStart));
			$show->setDateEnd(date ('Y-m-d', $timeEnd));
			$show->setTimeEnd(date ('H:i:s', $timeEnd));
		}

		public function checkTime (Show $show) {
			$existance = $this->getByCinemaId($show); // Get Shows That Belong To That Particular Cinema
			$this->appendTime ($show);
			$flag = 1;
			if ($existance != null) {
				foreach ($existance as $showsOnDB) {
					if ( ($showsOnDB["date_start"] == $show->getDateStart()) ) {
						if ( ($showsOnDB["time_start"] > $show->getTimeStart()) && ($showsOnDB["time_start"] > $show->getTimeEnd()) ) {
							$flag *= 1;
						}
						else if ( ($showsOnDB["time_end"] < $show->getTimeStart()) && ($showsOnDB["time_end"] < $show->getTimeEnd()) ) {
							$flag *= 1;
						}
						else {
							$flag *= 0;
						}
					}
				}
			}
			else if ($existance == null) {
				$flag *= $this->checkPlace($show);
			}
			return $flag;
		}
		*/

		public function getByMovieId (Show $show) {
			try {
				$query = "CALL shows_getByMovieId (?)";
				$parameters ["id_movie"] = $show->getMovie()->getId();
				$this->connection = Connection::GetInstance();
				return $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
			}
			catch (Exception $e) {
				throw $e;
			}
		}

		public function getByCinemaId (Show $show) {
			try {
				$query = "CALL shows_getByCinemaId (?)";
				$parameters ["id_cinema"] = $show->getCinema()->getId();
				$this->connection = Connection::GetInstance();
				return $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
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
				$movie->setId($row["movies_id"]);
				$movie->setTitle($row["movies_title"]);
				$cinema = new Cinema();
				$cinema->setId($row["cinemas_id"]);
				$cinema->setName($row["cinemas_name"]);
				$show = new Show ();
				$show->setId($row["shows_id"]);
				$show->setDateStart($row["shows_date_start"]);
				$show->setTimeStart($row["shows_time_start"]);
				$show->setDateEnd($row["shows_date_end"]);
				$show->setTimeEnd($row["shows_time_end"]);
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
					$movie->setId($row["movies_id"]);
					$movie->setTitle($row["movies_title"]);
					$movie->setBackdropPath($row["movies_backdrop_path"]);
					$cinema = new Cinema();
					$cinema->setId($row["cinemas_id"]);
					$cinema->setName($row["cinemas_name"]);
					$cinema->setAddress($row["cinemas_address"]);
					$cinema->setPrice($row["cinemas_ticket_value"]);
					$cinema->setCapacity($row["cinemas_capacity"]);
					$show->setId($row["shows_id"]);
					$show->setDateStart($row["shows_date_start"]);
					$show->setTimeStart($row["shows_time_start"]);
					$show->setDateEnd($row["shows_date_end"]);
					$show->setTimeEnd($row["shows_time_end"]);
					$show->setMovie($movie);
					$show->setCinema($cinema);
				}
				return $show;
			}
			catch (Exception $e) {
				throw $e;
			}
		}

		public function modify (Show $show) {
			try {
				$query = "CALL shows_modify(?, ?, ?, ?, ?, ?, ?)";
				$parameters["id"] = $show->getId();
				$parameters["id_cinema"] = $show->getCinema()->getId();
				$parameters["id_movie"] = $show->getMovie()->getId();
				$this->timeCheck($show);
				$parameters["date_start"] = $show->getDateStart();
				$parameters["time_start"] = $show->getTimeStart();
				$parameters["date_end"] = $show->getDateEnd();
				$parameters["time_end"] = $show->getTimeEnd();
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
		
		public function getShowsOfMovie(Movie $movie) {
			$shows = array();
			try {
				$query = "CALL shows_getShowsOfMovie(?)";
				$parameters["id_movie"] = $movie->getId();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
				foreach($results as $row) {
					$show = new Show();
					$cinema = new Cinema();
					$cinema->setName($row["cinema_name"]);
					$cinema->setAddress($row["cinema_address"]);
					$show->setId($row["show_id"]);
					$show->setDateStart($row["show_date_start"]);
					$show->setTimeStart($row["show_time_start"]);
					$show->setCinema($cinema);
					array_push($shows, $show);
				}

				return $shows;
			}
			catch (Exception $e) {
				throw $e;
			}
		}


	}

 ?>
