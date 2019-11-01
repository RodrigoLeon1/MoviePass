<?php

    namespace Models;

    class Genre {
        
        private $id_genre;
        private $name;

        public function getIdGenre() {
            return $this->id_genre;
        }
        public function getName() {
            return $this->name;
        }

        public function setIdGenre($id_genre) {
            $this->id_genre = $id_genre;
        }
        public function setName($name) {
            $this->name = $name;
        }
    }

?>