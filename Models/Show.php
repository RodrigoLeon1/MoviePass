<?php

    namespace Models;

    class Show
    {
        private $id_show;
        private $id_cinema;
        private $id_movie;
        private $day;
        private $hour;
        

        public function getIdShow()
        {
            return $this->id_show;
        }
        public function getIdCinema()
        {
            return $this->id_cinema;
        }
        public function getIdMovie()
        {
            return $this->id_movie;
        }
        public function getDay()
        {
            return $this->day;
        }
        public function getHour()
        {
            return $this->hour;
        }

        public function setIdShow($id_show)
        {
            $this->id_show = $id_show;
        }
        public function setIdCinema($id_cinema)
        {
            $this->id_cinema = $id_cinema;
        }
        public function setIdMovie($id_movie)
        {
            $this->id_movie = $id_movie;
        }
        public function setDay($day)
        {
            $this->day = $day;
        }
        public function setHour($hour)
        {
            $this->hour = $hour;
        }
    }

?>