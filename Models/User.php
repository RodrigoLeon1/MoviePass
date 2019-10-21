<?php

    namespace Models;

    class User {

        private $mail;
        private $password;
        private $firstName;
        private $lastName;
        private $dni;
        private $role;

        public function getMail() {
            return $this->mail;
        }

        public function setMail($mail) {
            $this->mail = $mail;
            return $this;
        }


        public function getPassword() {
            return $this->password;
        }

        public function setPassword($password) {
            $this->password = $password;
            return $this;
        }

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


        public function getRole() {
            return $this->role;
        }

        public function setRole($role) {
            $this->role = $role;
            return $this;
        }

    }

?>
