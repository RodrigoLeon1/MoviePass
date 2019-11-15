<?php

    namespace Models;

    class CinemaRoom {

        private $id;
        private $name;
        private $capacity;
        private $price;

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

    }

?>
