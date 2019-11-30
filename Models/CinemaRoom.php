<?php

    namespace Models;

    use Models\Cinema as Cinema;

    class CinemaRoom {

        private $id;
        private $name;
        private $capacity;
        private $price;
        private $cinema;
        private $is_active;

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
            return $id;
        }

		public function getName() {
            return $this->name;
        }

        public function setName($name) {
            $this->name = $name;
            return $this;
        }

        public function getCapacity() {
            return $this->capacity;
        }

        public function setCapacity($capacity) {
            $this->capacity = $capacity;
            return $this;
        }

        public function getPrice() {
            return $this->price;
        }

        public function setPrice($price) {
            $this->price = $price;
            return $this;
        }

        public function getCinema() {
            return $this->cinema;
        }

        public function setCinema(Cinema $cinema) {
            $this->cinema = $cinema;
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
