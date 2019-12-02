<main>
    <h2 class="dash-title">Tickets sold and remainder</h2>
    <hr>
    
    <div class="dashboard-container">            
        <div class="content-container">
            <table border="1" id="myTable">
				<div class="filter-container">
					<div class="filter-search">						
						<i class="icon ion-md-search"></i>
						<input class="filter-input" type="text" class="filter" id="myInput" placeholder="Search for cinemas..">
					</div>
					<div class="filter-options">						
						<p>Filter by:</p>
						<input type="radio" name="filter" id="input-cinema" value="cinema" checked> Cinema
						<input type="radio" name="filter" id="input-movie" value="movie"> Movie						
						<input type="radio" name="filter" id="input-date" value="date"> Date	
					</div>
				</div>
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
<script>
	let outerInput = document.getElementById('myInput');
	let inputCinema = document.getElementById('input-cinema');
	let inputMovie = document.getElementById('input-movie');
	let inputDate = document.getElementById('input-date');
	
	inputCinema.addEventListener('click', () => {
		outerInput.placeholder = `Search for cinemas..`;	
	});

	inputMovie.addEventListener('click', () => {
		outerInput.placeholder = `Search for movies..`;			
	});

	inputDate.addEventListener('click', () => {
		outerInput.placeholder = `Search for date (Y-m-d)..`;			
	});

	outerInput.addEventListener('keyup', function() {
		let innerInput, filter, table, tr, td, i, txtValue;
		innerInput = document.getElementById('myInput');
		filter = innerInput.value.toUpperCase();
		table = document.getElementById('myTable');
		tr = table.getElementsByTagName('tr');
		
		for (i = 0; i < tr.length; i++) {
			if (innerInput.placeholder.includes('cinemas')) {
				td = tr[i].getElementsByTagName('td')[1];
			} else if (innerInput.placeholder.includes('movies')) {
				td = tr[i].getElementsByTagName('td')[5];
			} else {
				td = tr[i].getElementsByTagName('td')[3];
			}
			if (td) {
				txtValue = td.textContent || td.innerText;
				if (txtValue.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = '';
				} else {
					tr[i].style.display = 'none';
				}
			}
		}
	});

</script>
</body>
</html>