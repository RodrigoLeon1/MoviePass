<?php

    namespace Models;

    class Cinema {

        private $id;
        private $name;        
        private $address;
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

        public function getAddress() {
            return $this->address;
        }

        public function setAddress($address) {
            $this->address = $address;
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
