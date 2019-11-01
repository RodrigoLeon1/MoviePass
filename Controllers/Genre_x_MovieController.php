<?php

    namespace Controllers;

    use Models\Genre as Genre;
    use Models\Movie as Movie;
    use Models\Genre_x_Movie as Genre_x_Movie;
    use DAO\GenreDAO as GenreDAO;
    use DAO\Genre_x_MovieDAO as Genre_x_MovieDAO;

    class Genre_x_MovieController {

        private $genresxmoviesDAO;
        private $genreDAO;

        public function __construct() {
            $this->genresxmoviesDAO = new Genre_x_MovieDAO();
            $this->genresDAO = new GenreDAO();
        }

        public function genreByName($name) {
            return $this->genreDAO->getByName($name);
        }

        public function genreById($id) {
            return $this->genreDAO->getByName($name);
        }

        public function searchMovieByGenre($genre) {
            $movies = array();
            if(is_numeric($genre)) {
                $movies = $this->genresxmoviesDAO->getByGenre($genre);
            } else {
                $aux = $this->genreByName($genre);
                $movies = $this->genresxmoviesDAO->getByGenre($aux->getId());
            }
        }

        public function getAllGenres() {
            return $this->genresDAO->getAll();
        }
    }

?>