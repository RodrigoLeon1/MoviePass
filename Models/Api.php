<?php

    namespace Models;

    class Api {

        private $url = "https://api.themoviedb.org/3";
        private $apiToquen = "api_key=5d5fe41bdf62bea9ea2f194984b9ad74";
        private $slashMovie = "/movie";
        private $language = "&language=en-US";
        private $page = "&page=";

        public function getApiToquen() {
            return $this->apiToquen;
        }

        public function setApiToquen($apiToquen) {
            $this->apiToquen = $apiToquen;
            return $this;
        }


        public function getUrl() {
            return $this->url;
        }

        public function setUrl($url) {
            $this->url = $url;
            return $this;
        }

        public function getSlashMovie() {
            return $this->slashMovie;
        }

        public function setSlashMovie($slashMovie) {
            $this->slashMovie = $slashMovie;
            return $this;
        }

        public function getLanguage() {
            return $this->language;
        }

        public function setLanguage($language) {
            $this->language = $language;
            return $this;
        }


        public function getPage() {
            return $this->page;
        }

        public function setPage($page) {
            $this->page = $page;
            return $this;
        }

    }

?>
