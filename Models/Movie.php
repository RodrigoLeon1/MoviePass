<?php

    namespace Models;

    class Movie {

        private $popularity;
        private $vote_count;
        private $video;
        private $poster_path;
        private $id;
        private $adult;
        private $backdrop_path;
        private $original_language;
        private $original_title;
        private $genre_ids;
        private $title;
        private $vote_average;
        private $overview;
        private $release_date;

        public function getPopularity() {
            return $this->popularity;
        }

        public function setPopularity($popularity) {
            $this->popularity = $popularity;
            return $this;
        }


        public function getVoteCount() {
            return $this->vote_count;
        }

        public function setVoteCount($vote_count) {
            $this->vote_count = $vote_count;
            return $this;
        }


        public function getVideo() {
            return $this->video;
        }

        public function setVideo($video) {
            $this->video = $video;
            return $this;
        }


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


        public function getAdult() {
            return $this->adult;
        }

        public function setAdult($adult) {
            $this->adult = $adult;
            return $this;
        }


        public function getBackdropPath() {
            return $this->backdrop_path;
        }

        public function setBackdropPath($backdrop_path) {
            $this->backdrop_path = $backdrop_path;
            return $this;
        }


        public function getOriginalLanguage() {
            return $this->original_language;
        }

        public function setOriginalLanguage($original_language) {
            $this->original_language = $original_language;
            return $this;
        }


        public function getOriginalTitle() {
            return $this->original_title;
        }

        public function setOriginalTitle($original_title) {
            $this->original_title = $original_title;
            return $this;
        }


        public function getGenreIds() {
            return $this->genre_ids;
        }

        public function setGenreIds($genre_ids) {
            $this->genre_ids = $genre_ids;
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
    }
?>
