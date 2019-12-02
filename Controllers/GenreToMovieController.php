<?php

    namespace Controllers;
    
    use Models\Movie as Movie;
    use Models\Genre as Genre;
    use Models\Show as Show;
    use Models\GenreToMovie as GenreToMovie;
    use DAO\GenreDAO as GenreDAO;
    use DAO\GenreToMovieDAO as GenreToMovieDAO;

    class GenreToMovieController {

        private $genresToMoviesDAO;
        private $genreDAO;

        public function __construct() {
            $this->genresToMoviesDAO = new GenreToMovieDAO();
            $this->genresDAO = new GenreDAO();
        }
    
        //Genre
        public function genreByName($name) {
            $genre = new Genre();
            $genre->setName($name);
            return $this->genreDAO->getByName($genre);
        }

        public function genreById($id) {
            return $this->genreDAO->getByName($name);
        }

        public function getAllGenres() {
            return $this->genresDAO->getAll();
        }        

        
        //GenreToMovie
        public function getGenresOfMoviesOnShows() {
            return $this->genresToMoviesDAO->getGenresOfShows();
        }

        public function addGenresMovieToDb(){
            $this->genresToMoviesDAO->getGenresOfNowPlaying();
        }

        public function addGenresBD(Movie $movie) {                        
            return $this->genresToMoviesDAO->getGenresOfMovieFromApi($movie);            
        }

        public function searchMoviesOnShowByGenre($id) {
            $movies = array();    
            $genre = new Genre();
            $genre->setIdGenre($id);
            $movies = $this->genresToMoviesDAO->getByGenre($genre);            
            return $movies;
        }

        public function searchMoviesOnShowByDate($date) {
            $movies = array();
            $show = new Show();
            $show->setDateStart($date);
            $movies = $this->genresToMoviesDAO->getByDate($show);            
            return $movies;
        }         

        // arreglar
        public function searchMoviesOnShowByGenreAndDate($idGenre, $date) {
            $movies = array();     
            $genre = new Genre();
            $genre->setIdGenre($idGenre);
            $show = new Show();
            $show->setDateStart($date);
            $movies = $this->genresToMoviesDAO->getByGenreAndDate($genre, $show);
            return $movies;
        }        

        public function getGenresOfMovie(Movie $movie) {
            return $this->genresToMoviesDAO->getGenresOfMovie($movie);
        }

        public function getNameOfGenre($id) {                     
            $genre = new Genre();
            $genre->setIdGenre($id);
            return $this->genresDAO->getNameGenre($genre);
        }


    }

?>