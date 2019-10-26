<?php

    namespace DAO;

	use \Exception as Exception;
	use DAO\Connection as Connection;
    use Models\Show as Show;

    class ShowDAO {

        private $showList = array();
		private $connection;
		private $tableName = "show";

        public function add(Show $show) {
			try {
				$query = "INSERT INTO " . $this->tableName . " (id_show, id_cinema, id_movie, day, hour) VALUES (:id_show, :id_cinema, :id_movie, :day, :hour);";
				$parameters["id_cinema"] = $show->getIdCinema();
				$parameters["id_movie"] = $show->getIdMovie();
                $parameters["day"] = $show->getDay();
                $parameters["hour"] = $show->getHour();
                $this->connection = Connection::getInstance();
				$this->connection->executeNonQuery($query, $parameters);
			}
			catch (Exception $e) {
				throw $e;
			}
        }

        public function getAll () {
			$query = "SELECT * FROM " . $this->tableName;
            $this->connection = Connection::GetInstance();
            $results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
            foreach($results as $row)
            {
                $show = new Show();
				$show->setIdShow($row["id_show"]);
                $show->setIdCinema($row["id_cinema"]);
                $show->setIdMovie($row["id_movie"]);
                $show->setDay($row["day"]);
                $show->set($row["hour"]);
				array_push ($this->showList, $show);
            }
            return $this->showList;
		}

		

    }

 ?>
