<main>
    <h2 class="dash-title">Cinema rooms sales</h2>
    <hr>
    
    <div class="dashboard-container">            
        <div class="content-container">
            <table border="1" id="myTable">
                <div class="filter-container">
                    <div class="filter-search">		
                        <i class="icon ion-md-search"></i>
                        <input class="filter-input" type="text" class="filter" id="myInput" placeholder="Search for cinemas..">
                    </div>
                </div>                    
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
                            <td><?= $room->getId(); ?></td>
                            <td><?= $room->getCinema()->getName(); ?></td>
                            <td><?= $room->getName(); ?></td>
                            <td>$<?= $room->getPrice(); ?></td>
                            <td>$<?= $this->cinemaRoomDAO->getSales($room); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
	<script>

		let outerInput = document.getElementById('myInput');

		outerInput.addEventListener('keyup', function() {
			let innerInput, filter, table, tr, td, i, txtValue;
			innerInput = document.getElementById('myInput');
			filter = innerInput.value.toUpperCase();
			table = document.getElementById('myTable');
			tr = table.getElementsByTagName('tr');
			
			for (i = 0; i < tr.length; i++) {
				td = tr[i].getElementsByTagName("td")[1];
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