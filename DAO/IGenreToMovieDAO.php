<?php
    namespace DAO;

    use Models\GenreToMovie as GenreToMovie;
    use Models\Movie as Movie;

    interface IGenreToMovieDAO {
        
        function add(GenreToMovie $genreToMovie);
        function getGenresOfNowPlaying();
        function getGenresOfMovieFromApi(Movie $movie);
        function getAll();
        function getByGenre($id);
        function getByDate($date);
        function getByGenreAndDate($id, $date);
        function getGenresOfMovie(Movie $movie);
        function getGenresOfShows();

    }

?>