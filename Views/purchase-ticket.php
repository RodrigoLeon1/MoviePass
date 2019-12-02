    <main>    
        <div class="container">            
            <div class="purchase-container">

                <div class="show-info">
                    <h3 class="cinema-name">Show information</h3>                        
                    <div class="show-complete-info">
                        <h3>
                            <i class="icon ion-md-videocam"></i> 
                            <?= $show->getMovie()->getTitle(); ?>
                        </h3>
                        <h3>
                            <i class="icon ion-logo-usd"></i> 
                            Price for ticket: $<span id="price-ticket"><?= $show->getCinemaRoom()->getPrice(); ?></span>  
                        </h3>                        
                        <h3>
                            <i class="icon ion-md-calendar"></i> 
                            <?= $show->getCinemaRoom()->getCinema()->getName() ?> - <?= $show->getCinemaRoom()->getName() ?>
                        </h3>
                        <h3>
                            <i class="icon ion-md-pin"></i> 
                            <?= $show->getCinemaRoom()->getCinema()->getAddress(); ?>
                        </h3>                        
                        <h3>
                            <i class="icon ion-md-calendar"></i> 
                            <?= date('F j, Y', strtotime($show->getDateStart())); ?>
                            at 
                            <?= date('H:i', strtotime($show->getTimeStart())); ?>
                        </h3>
                    </div>
                    <div class="show-total">
                        <h3 class="cinema-name">
                            <i class="icon ion-md-cart"></i>     
                            Total: $<span id="cart-total">0</span>
                            <div class="ticket-information">
                                <h4>Ticket type: General</h4>
                                <h4>Tickets: <span id="ticket-quantity">0</span> </h4>
                                <h4>Discount: N/A</h4>
                            </div>
                        </h3>
                    </div>
                </div>

                <div class="purchase-form">                    
                    <form action="<?= FRONT_ROOT ?>purchase/Add" method="POST" class="register-form">                        
                        <label>
                            <h4>Insert quantity of tickets</h4>               
                            <input type="number" name="ticket_quantity" id="numberTickets" min="1" max="<?= $available; ?>" required>
                        </label> 
                        
                        <input type="hidden" name="id_show" value="<?= $show->getId(); ?>">                        

                        <label>
                            <h4>Card</h4>
                            <div class="card-container">
                                <?php foreach($creditAccounts as $creditAccount): ?>
                                    <input type="radio" name="card" value="<?= $creditAccount->getId(); ?>"><?= $creditAccount->getCompany(); ?>                                    
                                <?php endforeach; ?>
                            </div>
                        </label>

                        <label>
                            <h4>Insert card number</h4>               
                            <input type="text" name="cardNumber" maxlength="16" minlength="16" required>
                        </label>

                        <label>
                            <h4>Security code</h4>               
                            <input type="text" name="cardSecurity" maxlength="3" minlength="3" required>
                        </label>

                        <label>
                            <h4>Expiration date</h4>               
                            <input type="month" name="expirationDate" required>
                        </label>

                        <button class="btn-l" type="submit">Buy</button>
                    </form> 

                </div>

            </div>
        </div>
        <!-- <div class="container purchase-seats">                
                <h2>Seats cinema</h2>
                <div class="theatre">  
                    <div class="cinema-seats left">
                        <div class="cinema-row row-1">
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                        </div>

                        <div class="cinema-row row-2">
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                        </div>

                        <div class="cinema-row row-3">
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                        </div>

                        <div class="cinema-row row-4">
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                        </div>

                        <div class="cinema-row row-5">
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                        </div>

                        <div class="cinema-row row-6">
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                        </div>

                        <div class="cinema-row row-7">
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                            <div class="seat"></div>
                        </div>                        
                    </div>                                      
                </div>  
        </div>  -->
    </main>
                                
    <script>

        let priceTicket = document.getElementById('price-ticket');        
            priceTicket = parseInt(priceTicket.innerHTML);

        let cartTotal = document.getElementById('cart-total');
        let tickets = document.getElementById('numberTickets');    
        let ticketQuantity = document.getElementById('ticket-quantity'); 
                
        //Cada vez que el usuario ingrese una cantidad numerica de ticket, se renderizara el total de la compra
        tickets.addEventListener('keyup', function getNumberTickets() {      
            console.log(priceTicket, this.value)  ;
            cartTotal.innerHTML = renderTotal(priceTicket, this.value);
            ticketQuantity.innerHTML = this.value;
        });        
        
        function renderTotal(price, tickets) {
            return tickets * price;
        }

    </script>