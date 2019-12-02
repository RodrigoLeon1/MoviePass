<?php

    namespace Models;

    use Models\CreditAccount as CreditAccount;

    class PaymentCreditCard {
        
        private $id;
        private $code_auth;
        private $date;
        private $total;
        private $creditAccount;

        public function getId() {
            return $this->id;
        }
        
        public function getCodeAuth() {
            return $this->code_auth;
        }

        public function getDate() {
            return $this->date;
        }

        public function getTotal() {
            return $this->total;
        }

        public function getCreditAccount() {
            return $this->creditAccount;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setCodeAuth($code_auth) {
            $this->code_auth = $code_auth;
        }

        public function setDate($date) {
            $this->date = $date;
        }        

        public function setTotal($total) {
            $this->total = $total;
        }        

        public function setCreditAccount(CreditAccount $creditAccount) {
            $this->creditAccount = $creditAccount;
        }        
    }

?>