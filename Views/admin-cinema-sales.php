<main>
        <h2 class="dash-title">Cinemas sales</h2>
        <hr>
        
        <div class="dashboard-container">            
            <div class="content-container">
                <table border="1" id="myTable">
                    <div class="filter-container">
                        <i class="icon ion-md-search"></i>
                        <input class="filter-input" type="text" class="filter" id="myInput" onkeyup="myFunction()" placeholder="Search for cinemas..">
                    </div>  
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
                                <td><?= $cinema->getId(); ?></td>
                                <td><?= $cinema->getName(); ?></td>
                                <td>$<?= $this->cinemaDAO->getSales($cinema); ?></td>
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
            td = tr[i].getElementsByTagName("td")[1];
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