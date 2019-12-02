<?php

    namespace Controllers;    
    
    use Models\CreditAccount as CreditAccount;
    use DAO\CreditAccountDAO as CreditAccountDAO;

    class CreditAccountController {
        
        private $creditAccountDAO;

        public function __construct() {
            $this->creditAccountDAO = new CreditAccountDAO();
        }

        public function add($company) {
            $creditAccount = new CreditAccount();            
            $creditAccount->setCompany($company);
            return $this->creditAccountDAO->add($creditAccount);
        }

        public function getAllCompanies() {
            return $this->creditAccountDAO->getAll();
        }

    }
?>