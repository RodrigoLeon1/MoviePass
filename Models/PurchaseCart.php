<?php

    namespace Models;

    use Models\Movie as Movie;        
    use Models\Purchase as Purchase;
	use Models\Cinema as Cinema;

    class PurchaseCart {
        
        private $purchase;
        private $movie;        
        private $cinema;

        public function getPurchase() {
            return $this->purchase;
        }

        public function setPurchase(Purchase $purchase) {
            $this->purchase = $purchase;
            return $this;
        }

        public function getMovie() {
            return $this->movie;
        }

        public function setMovie(Movie $movie) {
            $this->movie = $movie;
            return $this;
        }       

        public function getCinema() {
            return $this->cinema;
        }

        public function setCinema(Cinema $cinema) {
            $this->cinema = $cinema;
            return $this;
        }        

    }

?>