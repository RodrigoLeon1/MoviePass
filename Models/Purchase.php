<?php

    namespace Models;
    
    use Models\PaymentCreditCard as PaymentCreditCard;

    class Purchase {
        
        private $id;
        private $ticket_quantity;
        private $discount;
        private $date;
        private $total;
        private $dni;
        private $paymentCreditCard;

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
            return $this;
        }

        public function getTicketQuantity() {
            return $this->ticket_quantity;
        }

        public function setTicketQuantity($ticket_quantity) {
            $this->ticket_quantity = $ticket_quantity;
            return $this;
        }

        public function getDiscount() {
            return $this->discount;
        }

        public function setDiscount($discount) {
            $this->discount = $discount;
            return $this;
        }

        public function getDate() {
            return $this->date;
        }

        public function setDate($date) {
            $this->date = $date;
            return $this;
        }

        public function getTotal() {
            return $this->total;
        }
        
        public function setTotal($total) {
            $this->total = $total;
            return $this;
        }

        public function getDni() {
            return $this->dni;
        }

        public function setDni($dni) {
            $this->dni = $dni;
            return $this;
        }

        public function getPaymentCreditCard() {
            return $this->paymentCreditCard;
        }

        public function setPaymentCreditCard(PaymentCreditCard $paymentCreditCard) {
            $this->paymentCreditCard = $paymentCreditCard;
            return $this;
        }        
    }

?>