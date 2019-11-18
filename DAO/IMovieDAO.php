<?php
    namespace DAO;

    use Models\Movie as Movie;

    interface IMovieDAO {
        
        function add(Movie $movie);
        function addMovie(Movie $movie);
        function getAll();
        function getNowPlayingMoviesFromDAO();
        function getRunTimeMovieFromDAO();
        function getKeyMovieTrailer(Movie $movie);
        function getMovieDetailsById(Movie $movie);
        function getComingSoonMovies();
        function getById(Movie $movie);
        function getByTitle(Movie $movie);
        function deleteById(Movie $movie);
        function getShowsOfMovie(Movie $movie);
        function getSales(Movie $movie);
        
    }

?>