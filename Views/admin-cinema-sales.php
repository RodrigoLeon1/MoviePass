<main>
        <h2 class="dash-title">Cinemas sales</h2>
        <hr>
        
        <div class="dashboard-container">            
            <div class="content-container">
                <table border="1">
                    <thead>
                        <tr>                            
                            <th>Id</th>
                            <th>Cinema</th>
                            <th>Total</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cinemas as $cinema): ?>
                            <tr>  
                                <td><?= $cinema->getId() ?></td>
                                <td><?= $cinema->getName() ?></td>
                                <td>$<?= $this->cinemaDAO->getSales($cinema) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>