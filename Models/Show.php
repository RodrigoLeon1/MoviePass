<?php

    namespace Models;

	use Models\CinemaRoom as CinemaRoom;
	use Models\Movie as Movie;

    class Show {
        private $id;
        private $cinemaRoom;
        private $movie;
        private $dateStart;
        private $timeStart;
        private $dateEnd;
        private $timeEnd;

		public function __construct () {
			$this->cinema = new Cinema ();
			$this->movie = new Movie ();
		}

		public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
            return $this;
        }

		public function getCinemaRoom() {
			return $this->cinemaRoom;
		}

		public function setCinemaRoom(CinemaRoom $cinemaRoom) {
			$this->cinemaRoom = $cinemaRoom;
			return $this;
		}

		public function getMovie() {
            return $this->movie;
        }

        public function setMovie(Movie $movie) {
            $this->movie = $movie;
            return $this;
        }

		public function getDateStart() {
			return $this->dateStart;
        }

        public function setDateStart($dateStart) {
            $this->dateStart = $dateStart;
            return $this;
        }

		public function getTimeStart() {
            return $this->timeStart;
        }

        public function setTimeStart($timeStart) {
            $this->timeStart = $timeStart;
            return $this;
        }

		public function getDateEnd() {
			return $this->dateEnd;
        }

        public function setDateEnd($dateEnd) {
            $this->dateEnd = $dateEnd;
            return $this;
        }

		public function getTimeEnd() {
            return $this->timeEnd;
        }

        public function setTimeEnd($timeEnd) {
            $this->timeEnd = $timeEnd;
            return $this;
        }

    }

?>
