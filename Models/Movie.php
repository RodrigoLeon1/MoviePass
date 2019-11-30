<?php

    namespace Models;

    class Movie {
        
        private $poster_path;
        private $id;        
        private $backdrop_path;        
        private $title;
        private $vote_average;
        private $overview;
        private $release_date;        
        private $runtime;        
        private $is_active;

        public function getPosterPath() {
            return $this->poster_path;
        }

        public function setPosterPath($poster_path) {
            $this->poster_path = $poster_path;
            return $this;
        }

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
            return $this;
        }

        public function getBackdropPath() {
            return $this->backdrop_path;
        }

        public function setBackdropPath($backdrop_path) {
            $this->backdrop_path = $backdrop_path;
            return $this;
        }

        public function getTitle() {
            return $this->title;
        }

        public function setTitle($title) {
            $this->title = $title;
            return $this;
        }

        public function getVoteAverage() {
            return $this->vote_average;
        }

        public function setVoteAverage($vote_average) {
            $this->vote_average = $vote_average;
            return $this;
        }

        public function getOverview() {
            return $this->overview;
        }

        public function setOverview($overview) {
            $this->overview = $overview;
            return $this;
        }

        public function getReleaseDate() {
            return $this->release_date;
        }

        public function setReleaseDate($release_date) {
            $this->release_date = $release_date;
            return $this;
        }

        public function getRuntime() {
            return $this->runtime;
        }

        public function setRuntime($runtime) {
            $this->runtime = $runtime;
            return $this;
        }

        public function getIsActive() {
            return $this->is_active;
        }

        public function setIsActive($is_active) {
            $this->is_active = $is_active;
            return $this;
        }
    }
	
?>
