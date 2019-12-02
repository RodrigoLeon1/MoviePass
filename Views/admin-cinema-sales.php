<main>
    <h2 class="dash-title">Cinemas sales</h2>
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