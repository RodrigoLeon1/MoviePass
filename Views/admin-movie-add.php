<main>
        <h2 class="dash-title">Add Movie</h2>
        <hr>
        
        <!-- 
        <?php ?>
        <div class="error-container">
            <i class="icon ion-md-close-circle-outline"></i>
            <h3>Error message</h3>
        </div>
        <?php ?> -->
        
        <div class="dashboard-container">            
            <form class="content-container" action="<?= FRONT_ROOT ?>movie/add" method="post">
                <label>
                    <h4>Insert name of movie:</h4>
                    <!-- Cambiar evento -->
                    <input type="text" name="name" id="" onkeyup="showHint(this.value)" required>
                </label>
                <button type="submit">Search</button>
            </form>
        </div>
        <p>Suggestions: <span id="txtHint"></span></p>
    </main>
</body>

    <script>    
        function showHint(str) {
            if (str.length == 0) {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {

                        var resultado =  JSON.parse(this.responseText);
                        console.log(resultado);

                        // document.getElementById("txtHint").innerHTML = json_decode(this.responseText);
                        console.log(this.r);
                    }
                };
                xmlhttp.open("GET", "https://api.themoviedb.org/3/search/movie?api_key=<?= API_N ?>&query=" + str, true);
                xmlhttp.send();                

            }
        }

    </script>

</html>