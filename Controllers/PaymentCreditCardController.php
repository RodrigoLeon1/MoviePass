<?php

    namespace Controllers;    
    
    use Models\CreditAccount as CreditAccount;
    use Models\PaymentCreditCard as PaymentCreditCard;
    use DAO\PaymentCreditCardDAO as PaymentCreditCardDAO;

    class PaymentCreditCardController {
        
        private $paymentCreditCardDAO;

        public function __construct() {
            $this->paymentCreditCardDAO = new PaymentCreditCardDAO();
        }

        public function add($code_auth, $date, $total, $id_creditAccount) {
            $paymentCreditCard = new PaymentCreditCard();
            $paymentCreditCard->setCodeAuth($code_auth);
            $paymentCreditCard->setDate($date);
            $paymentCreditCard->setTotal($total);

            $creditAccount = new CreditAccount();
            $creditAccount->setId($id_creditAccount);

            $paymentCreditCard->setCreditAccount($creditAccount);

            return $this->paymentCreditCardDAO->add($paymentCreditCard);
        }

        public function addObject(PaymentCreditCard $paymentCreditCard) {
            return $this->paymentCreditCardDAO->add($paymentCreditCard);
        }

    }
?>