<body>
    <header>
        <div class="movie-h" style="background-image: url('<?= FRONT_ROOT ?>Views/assets/img/cinema.jpg');">            
            <h3 class="section-title text-s">
                <i class="icon ion-md-videocam"></i>
                <?= $title ?>
            </h3>
        </div>
    </header>

    <main>    
        <div class="container">            
            <div class="purchase-container">

                <div class="show-info">
                    <h3 class="cinema-name">Show information</h3>                        
                    <div class="show-complete-info">
                        <h3>
                            <i class="icon ion-md-calendar"></i> 
                            Paseo Aldrey
                        </h3>
                        <h3>
                            <i class="icon ion-md-videocam"></i> 
                            Terminator 3
                        </h3>
                        <h3>
                            <i class="icon ion-logo-usd"></i> 
                            Price for ticket: $300
                        </h3>
                        <h3>
                            <i class="icon ion-md-calendar"></i> 
                            June18, 2019 at 8:00
                        </h3>
                        <h3>
                            <i class="icon ion-md-pin"></i> 
                            Sarmiento 2685
                        </h3>
                    </div>
                    <div class="show-total">
                        <h3 class="cinema-name">
                            <i class="icon ion-md-cart"></i>     
                            Total: $300
                        </h3>
                    </div>
                </div>

                <div class="purchase-form">                    
                    <form action="" method="POST" class="register-form">                        
                        <label>
                            <h4>Select Tickets</h4>               
                            <input type="number" name="numberOfTickets" id="numberTickets" min="1">
                        </label> 

                        <label>
                            <h4>Card</h4>
                            <div class="card-container">
                                <input type="radio" name="card" value="visa" id="visa">Visa
                                <input type="radio" name="card" value="mastercard" id="mastercard">MasterCard                          
                            </div>
                        </label>

                        <label>
                            <h4>Insert card number</h4>               
                            <input type="text" name="" id="" maxlength="16" minlength="16">
                        </label>

                        <label>
                            <h4>Security code</h4>               
                            <input type="text" name="" id="" maxlength="3" minlength="3">
                        </label>

                        <label>
                            <h4>Expiration date</h4>               
                            <input type="month" name="" id="">
                        </label>

                        <button class="btn-l" type="submit">Buy</button>
                    </form> 

                </div>

            </div>

            <div class="purchase-seats">                
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
            </div> 

        </div>
    </main>
