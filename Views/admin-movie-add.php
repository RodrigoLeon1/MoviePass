<main>
        <h2 class="dash-title">Add Movie</h2>
        <hr>

        <?php if($success != null): ?>
        <div class="alert-container success-container">
            <i class="icon ion-md-checkmark"></i>
            <h3><?= $success; ?></h3>
        </div>
        <?php endif; ?>        

        <?php if($alert != null): ?>
        <div class="alert-container error-container">
            <i class="icon ion-md-close-circle-outline"></i>
            <h3><?= $alert; ?></h3>
        </div>
        <?php endif; ?>
        
        <div class="dashboard-container">            
            <div class="content-container">
                <label>
                    <h4>Insert name of movie:</h4>
                    <input type="text" name="name" id="movie-name" required>
                </label>
                <button class="btn" id="btn-s">
                    <i class="icon ion-md-search"></i>
                    Search
                </button>
            </div>
        </div>     
        
        <div class="suggestions-container">            
            <p>
                <i class="icon ion-md-information-circle-outline"></i>    
                Suggestions:
            </p>    
            <div id="movie-container"></div>
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

            //Realizamos la peticion a la API con el nombre de pelicula que el usuario haya ingresado
            getMovies(movieTitle)
                .then(res => {
                    const elements = res.results.reduce((acc, movie) => acc + movieTemplate(movie), "");

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
                    <img src="<?= IMG_PATH_TMDB ?>${movie.poster_path}" alt="">
                    <div class="movie-add">
                        <div>
                            <h3>${movie.title}</h3>
                            <p>${movie.overview}</p>
                        </div>
                    </div>   
                    <div class="movie-add">     
                        <a href="<?= FRONT_ROOT ?>movie/add/?id=${movie.id}" class="btn">
                            <i class="icon ion-md-checkmark"></i>
                            Add
                        </a>       
                    </div>
                </li>
            `;
        }

        function getMovies(str) {
            return fetch(`https://api.themoviedb.org/3/search/movie?api_key=<?= API_N ?>&query=${str}`)
                .then(res => res.json());                                              
        }

    </script>
</html>