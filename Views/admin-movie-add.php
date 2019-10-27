<main>
        <h2 class="dash-title">Add Movie</h2>
        <hr>
            
        <?php if($alert != null): ?>
        <div class="error-container">
            <i class="icon ion-md-close-circle-outline"></i>
            <h3><?= $alert ?></h3>
        </div>
        <?php endif; ?>
        
        <div class="dashboard-container">            
            <div class="content-container">
                <label>
                    <h4>Insert name of movie:</h4>
                    <input type="text" name="name" id="movie-name" required>
                </label>
                <button class="btn" id="btn-s">Search</button>
            </div>
        </div>     
        
        <div class="suggestions-container">
            <p>Suggestions:</p>    
            <div class="" id="movie-container"></div>
        </div>   
    
    </main>
</body>

    <script>    

        let movie = document.getElementById('movie-name');
        let btn = document.getElementById('btn-s');
        let container = document.getElementById('movie-container');

        //Cada vez que el usuario presiones el boton, se ejecutara lo siguiente
        btn.addEventListener('click', () => {
            
            //Guardamos el valor que ingrese el usuario en el input
            let movieTitle = movie.value;                        

            let movies = getMovies(movieTitle);                                        
            console.log(movies);

            getMovies(movieTitle)
                .then(res => {
                    const elements = res.results.reduce((acc, user) => acc + movieTemplate(user), "");

                    const list = `
                        <ul class="movie-list">
                            ${elements}
                        </ul>
                    `;
                    container.innerHTML = list;
                });            

        });        
    
        //Genera el <li> para cada pelicula
        function movieTemplate(movie) {            
            return `
                <li class="movie-item">
                   <p class="movie-name">
                        <b>${movie.title}</b>
                        <b><img src="<?= IMG_PATH_TMDB ?>${movie.poster_path}" alt=""></b>
                    </p>                    
                </li>
            `;
        }

        function getMovies(str) {
            return fetch(`https://api.themoviedb.org/3/search/movie?api_key=<?= API_N ?>&query=${str}`)
                .then(res => res.json())                                              
        }


        /*
        function showHint(str) {
            if (str.length == 0) {
                // document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {

                        var resultado =  JSON.parse(this.responseText);
                        console.log(resultado);

                        // document.getElementById("txtHint").innerHTML = this.responseText;
                        document.getElementById("txtHint").innerHTML = resultado.results[0].title;

                        resultado.results.forEach(e => {
                            console.log(e);
                            suggestionContainer.appendChild(drawMovieItem(e.title));
                        });

                        // console.log(this.r);
                    }
                };
                xmlhttp.open("GET", "https://api.themoviedb.org/3/search/movie?api_key=<?= API_N ?>&query=" + str, true);
                xmlhttp.send();                
            }            
        }  
        */

    </script>
</html>