<?php

    namespace Controllers;

    use DAO\PurchaseDAO as PurchaseDAO;
    use Models\Purchase as Purchase;
    use Models\Show as Show;
    use Models\User as User;
    use Controllers\ShowController as ShowController;
    use Controllers\TicketController as TicketController;
    

    class PurchaseController
    {
        private $purchaseDAO;

        public function __construct()
        {
            $this->purchaseDAO = new PurchaseDAO();
        }

        public function Add($ticket_quantity, $id_show, $discount = "")
        {

            $ticketController = new TicketController();
            $showController = new ShowController();
            $date = date('Y-m-d');
            $user = $_SESSION["loggedUser"];
            $dni = $user->getDni();
            echo 'dni: '.$dni;
            $price = $showController->getShowById($id_show)->getCinema()->getPrice();
            $total = $ticket_quantity * $price;
            
				$purchase = new Purchase();            
                $purchase->setTicketQuantity($ticket_quantity);
                $purchase->setDiscount($discount);
                $purchase->setDate($date);
                $purchase->setTotal($total);
                $purchase->setDni($dni);
                $result = $this->purchaseDAO->Add($purchase);
                var_dump($result);
                /*
                for($i=0 ; $i<$ticket_quantity ; $i++)
                {
                    $ticketController->Add( ,$id_show, );
                }*/
			
        }

        public function buyTicketPath($idShow) {            
            if (isset($_SESSION["loggedUser"])) {  
                
                
                $showController = new ShowController();
                $show = $showController->getShowById($idShow); 
                
                
                $title = 'Buy ticket - ' . $show->getMovie()->getTitle();
                $img = IMG_PATH_TMDB . $show->getMovie()->getBackdropPath();

                require_once(VIEWS_PATH . "header.php");			
                require_once(VIEWS_PATH . "navbar.php");
                require_once(VIEWS_PATH . "header-s.php");
                require_once(VIEWS_PATH . "purchase-ticket.php");
                require_once(VIEWS_PATH . "footer.php");    
                
                
            } else {
                $userController = new UserController();
                return $userController->loginPath(LOGIN_NEEDED);
            }
        }

        public function getPurchases()
        {
            return $this->purchaseDAO->getAll();
        }

        public function getById($id)
        {
            return $this->purchaseDAO->getById();
        }

        public function numberOfTicketsAvailable($id_show)
        {
            $showController = new ShowController();
            $ticketController = new TicketController();
            
            $tickets = $ticketController->ticketsNumber($id_show);
            $capacity = $showController->getShowById($id_show)->getCinema()->getCapacity();
            
            return $capacity - $tickets;
        }

        public function ticketsAvailable($id_show)
        {
            $quantity = $this->numberOfTicketsAvailable($id_show);

            
            if($quantity > 0)
            {
                return true;
            }else
            {
                return false;
            }
            
            // return ($quantity > 0) ? true : false;
        }

        public function getPurchasesByUser($user)
        {
            return $this->purchaseDAO->getByDni($user->getDni());
        }

        public function getPurchasesByThisUser()
        {
            $user = $_SESSION["loggedUser"];
            return $this->purchaseDAO->getByDni($user->getDni());
        }
        
    }

?>