<?php

    namespace Models;    

    class CreditAccount {
        
        private $id;
        private $company;        

        public function getId() {
            return $this->id;
        }

        public function getCompany() {
            return $this->company;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setCompany($company) {
            $this->company = $company;
        }      
    }

?>