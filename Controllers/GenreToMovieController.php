<?php

    namespace Controllers;
    
    use Models\Movie as Movie;
    use Models\Genre as Genre;
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

        /*
        public function addGenreMovie($id_genre, $id_movie) {            
            $genreMovie = new Genre_x_Movie();
            $genreMovie->setIdGenre($id_genre);
            $genreMovie->setIdMovie($id_movie);
           
            $this->genresToMoviesDAO->Add($genreMovie);
        }*/

    
        //Genre
        public function genreByName($name) {
            return $this->genreDAO->getByName($name);
        }

        public function genreById($id) {
            return $this->genreDAO->getByName($name);
        }

        public function getAllGenres() {
            return $this->genresDAO->getAll();
        }        

        
        //GenreToMovie
        public function addGenresMovieToDb(){
            $this->genresToMoviesDAO->infoMovie();
        }

        public function searchMoviesOnShowByGenre($genre) {
            $movies = array();
            if(is_numeric($genre)) {
                $movies = $this->genresToMoviesDAO->getByGenre($genre);
            } else {                
                $aux = $this->genreByName($genre);
                $movies = $this->genresToMoviesDAO->getByGenre($aux->getId());
            }
            return $movies;
        }

        public function searchMoviesOnShowByDate($date) {
            $movies = array();
            $movies = $this->genresToMoviesDAO->getByDate($date);            
            return $movies;
        }         

        public function searchMoviesOnShowByGenreAndDate($genre, $date) {
            $movies = array();            
            $movies = $this->genresToMoviesDAO->getByGenreAndDate($genre, $date);
            return $movies;
        }        

        public function getGenresOfMovie(Movie $movie) {
            return $this->genresToMoviesDAO->getGenresOfMovie($movie);
        }

        public function getNameOfGenre($id) {            
            return $this->genresToMoviesDAO->getNameGenre($id);
        }


    }

?>