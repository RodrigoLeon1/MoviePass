<?php

    namespace Models;

	use Models\Cinema as Cinema;
	use Models\Movie as Movie;

    class Show
    {
        private $id;
        private $cinema;
        private $movie;
        private $date;
        private $time;

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

		public function getCinema() {
			return $this->cinema;
		}

		public function setCinema(Cinema $cinema) {
			$this->cinema = $cinema;
			return $this;
		}

		public function getMovie() {
            return $this->movie;
        }

        public function setMovie(Movie $movie) {
            $this->movie = $movie;
            return $this;
        }

		public function getDate() {
			return $this->date;
        }

        public function setDate($date) {
            $this->date = $date;
            return $this;
        }

		public function getTime() {
            return $this->time;
        }

        public function setTime($time) {
            $this->time = $time;
            return $this;
        }

    }

?>
