<?php

    namespace Models;

    use Models\Show as Show;

    class Ticket {

        private $ticket_number;
        private $qr;
        private $id_purchase;
        private $show;

        public function getTicketNumber() {
            return $this->ticket_number;
        }

        public function setTicketNumber($ticket_number) {
            $this->ticket_number = $ticket_number;
            return $this;
        }

        public function getQr() {
            return $this->qr;
        }

        public function setQr($qr) {
            $this->qr = $qr;
            return $this;
        }

        public function getIdPurchase() {
            return $this->id_purchase;
        }

        public function setIdPurchase($id_purchase) {
            $this->id_purchase = $id_purchase;
            return $this;
        }

        public function getShow() {
            return $this->show;
        }

        public function setShow(Show $show) {
            $this->show = $show;
            return $this;
        }

    }

    ?>