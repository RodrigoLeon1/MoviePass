    <main>
        <h2 class="dash-title">Tickets sold and remainder</h2>
        <hr>
        
        <div class="dashboard-container">            
            <div class="content-container">
                <table border="1">
                    <thead>
                        <tr>
                            <th>Id Show</th>
                            <th>Cinema</th>
                            <th>Room</th>
                            <th>Date</th>
                            <th>Hour</th>
                            <th>Movie</th>
                            <th>Tickets sold</th>
                            <th>Remainder</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tickets as $ticket): ?>
                            <tr>  
                                <td><?= $ticket->getShow()->getId(); ?></td>
                                <td><?= $ticket->getShow()->getCinemaRoom()->getCinema()->getName(); ?></td>
                                <td><?= $ticket->getShow()->getCinemaRoom()->getName(); ?></td>
                                <td><?= $ticket->getShow()->getDateStart(); ?></td>
                                <td><?= $ticket->getShow()->getTimeStart(); ?></td>
                                <td><?= $ticket->getShow()->getMovie()->getTitle(); ?></td>
                                <td><?= $this->getTicketsSold($ticket->getShow()->getId()); ?></td>
                                <td><?= $this->getTickesRemainder($ticket->getShow()->getId()); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>