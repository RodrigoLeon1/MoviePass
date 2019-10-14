<?php

    namespace Models;

    class Role {

        private $role;
        private $description;
        
        public function getRole() {
            return $this->role;
        }

        public function setRole($role) {
            $this->role = $role;
            return $this;
        }


        public function getDescription() {
            return $this->description;
        }

        public function setDescription($description) {
            $this->description = $description;
            return $this;
        }

    }

    ?>
