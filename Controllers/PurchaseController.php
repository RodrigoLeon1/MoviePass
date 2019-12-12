<?php

    namespace Controllers;

    use Models\User as User;    
    use Models\Show as Show;
    use Models\Purchase as Purchase;
    use Models\CreditAccount as CreditAccount;  
    use Models\PaymentCreditCard as PaymentCreditCard;    
    use DAO\PurchaseDAO as PurchaseDAO;
    use Controllers\ShowController as ShowController;
    use Controllers\UserController as UserController; 
    use Controllers\MovieController as MovieController;
    use Controllers\TicketController as TicketController;
    use Controllers\PaymentCreditCardController as PaymentCreditCardController;    

    class PurchaseController {

        private $purchaseDAO;

        public function __construct() {
            $this->purchaseDAO = new PurchaseDAO();
            $this->userController = new UserController();
        }

        public function add($ticket_quantity, $id_show, $id_card, $cardNumber, $cardSecurity, $expirationDate) {                    
            $ticketController = new TicketController();
            $showController = new ShowController();
            $paymentCreditCardController = new PaymentCreditCardController();

            $date = date('Y-m-d');
            $user = $_SESSION["loggedUser"];
            $dni = $user->getDni();
            $discount = 0;
            // $qr = ; 
            $price = $showController->getShowById($id_show)->getCinemaRoom()->getPrice();

            // Discount -> 25% of discount of ticket price
            if ($this->applyDiscount($ticket_quantity)) {                
                $totalWithoutDiscount = $ticket_quantity * $price;                                
                $discountValue = ($price * .25);                                
                $newPriceTicket = $price - $discountValue;                      
                $total = $ticket_quantity * $newPriceTicket;   
                $discount = $totalWithoutDiscount - $total;            
            } else {                
                $total = $ticket_quantity * $price;
            }
               
            $paymentCreditCard = new PaymentCreditCard();            
            $paymentCreditCard->setCodeAuth($cardSecurity);
            $paymentCreditCard->setDate($expirationDate);        //Expiration date or date of purchase?     
            $paymentCreditCard->setTotal($total);                        
            $creditAccount = new CreditAccount();
            $creditAccount->setId($id_card);
            $paymentCreditCard->setCreditAccount($creditAccount);

            $purchase = new Purchase();            
            $purchase->setTicketQuantity($ticket_quantity);
            $purchase->setDiscount($discount);
            $purchase->setDate($date);
            $purchase->setTotal($total);
            $purchase->setDni($dni);             
                        
            if ($id_payment = $paymentCreditCardController->addObject($paymentCreditCard)) {                
                $paymentCreditCard->setId($id_payment);
                $purchase->setPaymentCreditCard($paymentCreditCard);
                if ($id_purchase = $this->purchaseDAO->add($purchase)) {  
                    for ($i = 0; $i < $ticket_quantity; $i++) {
                        if ($ticketController->add(0, $id_show, $id_purchase)) {
                            continue;
                        }                    
                    }  
                    return $this->purchaseSuccess($id_purchase);                          
                }
            } 	
            return $this->userController->userPath();	
        }

        private function applyDiscount($ticket_quantity) {
            $date= getdate();
            $today = $date['wday'];
            // The discount only applies if the quantity of tickets if greater than or equal 2
            if($ticket_quantity >= 2) {                
                $tuesday = 2;   // 2 -> Tuesday 
                $wednesday = 3; // 3 -> Wednesday
                if($today == $tuesday || $today == $wednesday ) {
                    return true;
                }
            }
            return false;
        }

        public function buyTicketPath($idShow) {            
            if (isset($_SESSION["loggedUser"])) {              
                $showController = new ShowController();
                $show = $showController->getShowById($idShow);    
                $creditAccountController = new CreditAccountController();
                $creditAccounts = $creditAccountController->getAllCompanies();
                if ($show && $creditAccounts) {
                    $title = 'Buy ticket - ' . $show->getMovie()->getTitle();
                    $img = IMG_PATH_TMDB . $show->getMovie()->getBackdropPath();
                    $available = $this->numberOfTicketsAvailable($idShow);    
                    require_once(VIEWS_PATH . "header.php");			
                    require_once(VIEWS_PATH . "navbar.php");
                    require_once(VIEWS_PATH . "header-s.php");
                    require_once(VIEWS_PATH . "purchase-ticket.php");
                    require_once(VIEWS_PATH . "footer.php");                    
                } else {
                    $movieController = new MovieController();
                    return $movieController->nowPlaying();
                }                                
            } else {                
                return $this->userController->loginPath(LOGIN_NEEDED);
            }
        }

        public function purchaseSuccess($id) {
            if (isset($_SESSION["loggedUser"])) {  
                $title = 'Purchase';                
                $purchaseTemp = new Purchase();
                $purchaseTemp->setId($id);
                $purchase = $this->purchaseDAO->getById($purchaseTemp);
                if ($purchase) {
                    require_once(VIEWS_PATH . "header.php");			            
                    require_once(VIEWS_PATH . "navbar.php");            
                    require_once(VIEWS_PATH . "purchase-success.php");
                    require_once(VIEWS_PATH . "footer.php"); 
                } else {
                    $movieController = new MovieController();
                    return $movieController->nowPlaying();
                }
            } else {                
                return $this->userController->loginPath(LOGIN_NEEDED);
            }
        }

        public function numberOfTicketsAvailable($id_show) {
            $showController = new ShowController();
            $ticketController = new TicketController();
            
            $tickets = $ticketController->ticketsNumber($id_show);
            $capacity = $showController->getShowById($id_show)->getCinemaRoom()->getCapacity();
            
            return $capacity - $tickets;
        }

        public function ticketsAvailable($id_show) {
            $quantity = $this->numberOfTicketsAvailable($id_show);              
            return ($quantity > 0) ? true : false;
        }

        //
        public function getPurchases() {
            return $this->purchaseDAO->getAll();
        }

        public function getById($id) {
            $purchase = new Purchase();
            $purchase->setId($id);
            return $this->purchaseDAO->getById($purchase);
        }

        public function getPurchasesByUser($user) {
            return $this->purchaseDAO->getByDni($user);
        }

        public function getPurchasesByThisUser() {
            $user = $_SESSION["loggedUser"];
            return $this->purchaseDAO->getByDni($user);
        }
        
    }

?>