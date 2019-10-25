<?php

	namespace Models;

	class ProfileUser {

		private $firstName;
		private $lastName;
		private $dni;

		public function getFirstName() {
            return $this->firstName;
        }

        public function setFirstName($firstName) {
            $this->firstName = $firstName;
            return $this;
        }

        public function getLastName() {
            return $this->lastName;
        }

        public function setLastName($lastName) {
            $this->lastName = $lastName;
            return $this;
        }

        public function getDni() {
            return $this->dni;
        }

        public function setDni($dni) {
            $this->dni = $dni;
            return $this;
        }

	}

 ?>
