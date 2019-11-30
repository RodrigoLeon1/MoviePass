<body>
    <header>
        <div class="movie-h account-head">                
            <h3 class="section-title text-s">
                <i class="icon ion-md-happy"></i>
                <?= $title; ?>
            </h3>
        </div>
    </header>

    <main>    
        <div class="container">            
            <div class="purchase-success">
                
                <i class="icon ion-md-checkmark-circle"></i>
                <h2>PURCHASE WITH SUCCESS</h2>

                <div class="purchase-details">
                    <h3>ID Purchase: <?= $purchase->getId(); ?></h3>
                    <h3>Total: $<?= $purchase->getTotal(); ?> </h3>
                    <h3>Ticket Quantity: <?= $purchase->getTicketQuantity(); ?> </h3>
                    <h3>Discount: $<?= $purchase->getDiscount(); ?></h3>
                    <h3>Date of purchase: <?= $purchase->getDate(); ?></h3>
                    <h3>DNI of buyer: <?= $purchase->getDni(); ?></h3>                    
                </div>

            </div>
        </div>
    </main>