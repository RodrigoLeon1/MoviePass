<?php

    namespace Models;

    class Genre_x_Movie {
        
        private $id_genre;
        private $id_movie;

        public function getIdGenre() {
            return $this->id_genre;
        }
        public function getIdMovie() {
            return $this->id_movie;
        }

        public function setIdGenre($id_genre) {
            $this->id_genre = $id_genre;
        }
        public function setIdMovie($id_movie) {
            $this->id_movie = $id_movie;
        }
    }

?>