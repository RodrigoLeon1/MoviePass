<body>
    <header>
        <div class="movie-h account-head">                
            <h3 class="section-title text-s">
                <i class="icon ion-md-cart"></i>
                <?= $title; ?>
            </h3>
        </div>
    </header>
        
    <main>
        <div class="container">
            <?php if (!empty($purchasesCart)): ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Movie</th>
                        <th>Cinema</th>
                        <th>Ticket quantity</th>
                        <th>Discount</th>							
                        <th>Date</th>		
                        <th>Total with discount</th>												
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($purchasesCart as $purchaseCart): ?>
                        <tr>
                            <td><?= $purchaseCart->getPurchase()->getId(); ?></td>        
                            <td><?= $purchaseCart->getMovie()->getTitle(); ?></td>
                            <td><?= $purchaseCart->getCinema()->getName(); ?></td>
                            <td><?= $purchaseCart->getPurchase()->getTicketQuantity(); ?></td>
                            <td>$<?= $purchaseCart->getPurchase()->getDiscount(); ?></td>								
                            <td><?= $purchaseCart->getPurchase()->getDate(); ?></td>	
                            <td>$<?= $purchaseCart->getPurchase()->getTotal(); ?></td>								
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>            
            <h3 class="info">
                <i class="icon ion-md-sad"></i>
                No purchases found
            </h3>
            <?php endif; ?>
        </div>
        <br>
        <br>
        <br>
    </main>