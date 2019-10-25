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
        <div class="register-container" style="margin-bottom: 25rem">            
            <div class="register-content">
                
                <h3>Enter purchase data</h3>

                <form action="" method="post" class="register-form">  
                    <label> 
                        <h4>Cinema</h4>
                        <select name="cinema" class="select_Style" required>    
                        <?php foreach($cinemas as $value){?>

                            <option value=""><?php $value->getName(); ?></option>
                            
                        <?php  }  ?>
                            
                        </select>
                    </label>
                    <label>
                        <h4>Number of tickets</h4>               
                        <input type="number" name="numberOfTickets" id="" min="1">
                    </label>                                      
                    <label> 
                        <h4>Day</h4>
                        <input type="date" name="date" min="<?php $date ?>" >
                    </label>
                    <label> 
                        <h4>Hour</h4>
                        <input type="time" name="hour" >
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
                    <button class="btn-l" type="submit">Register</button>
                </form>

            </div>
            
            <div class="theatre">  
                <h3>Seats cinema</h3>
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

    </main>