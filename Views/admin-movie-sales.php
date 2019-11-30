<main>
        <h2 class="dash-title">Movies sales</h2>
        <hr>
        
        <div class="dashboard-container">            
            <div class="content-container">
                <table border="1" id="myTable">
                    <div class="filter-container">
                        <i class="icon ion-md-search"></i>
                        <input class="filter-input" type="text" class="filter" id="myInput" onkeyup="myFunction()" placeholder="Search for movies..">
                    </div>                    
                    <thead>
                        <tr>
                            <th>Poster</th>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Total</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movies as $movie): ?>
                            <tr>  
                                <td>
                                    <img src="<?= IMG_PATH_TMDB . $movie->getPosterPath(); ?>" alt="">
                                </td>
                                <td><?= $movie->getId(); ?></td>
                                <td><?= $movie->getTitle(); ?></td>
                                <td>$<?= $this->movieDAO->getSales($movie); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
	function myFunction() {
	// Declare variables
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("myInput");
	filter = input.value.toUpperCase();
	table = document.getElementById("myTable");
	tr = table.getElementsByTagName("tr");

	// Loop through all table rows, and hide those who don't match the search query
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[2];
		if (td) {
		txtValue = td.textContent || td.innerText;
		if (txtValue.toUpperCase().indexOf(filter) > -1) {
			tr[i].style.display = "";
		} else {
			tr[i].style.display = "none";
		}
		}
	}
	}

</script>
</body>
</html>