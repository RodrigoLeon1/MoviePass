<main>
        <h2 class="dash-title">Cinema rooms sales</h2>
        <hr>
        
        <div class="dashboard-container">            
            <div class="content-container">
                <table border="1">
                    <thead>
                        <tr>                            
                            <th>Id</th>
                            <th>Cinema</th>
                            <th>Room</th>
                            <th>Price</th>
                            <th>Total</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rooms as $room): ?>
                            <tr>  
                                <td><?= $room->getId() ?></td>
                                <td><?= $room->getCinema()->getName() ?></td>
                                <td><?= $room->getName() ?></td>
                                <td>$<?= $room->getPrice() ?></td>
                                <td>$<?= $this->cinemaRoomDAO->getSales($room) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>