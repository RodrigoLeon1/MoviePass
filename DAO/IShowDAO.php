<?php
    namespace DAO;

    use Models\Show as Show;
    use Models\Movie as Movie;

    interface IShowDAO {
        
        function add(Show $show);
        function getByMovieId(Show $show);
        function getByCinemaRoomId(Show $show);
        function getAll();
        function deleteById(Show $show);
        function getById($id);
        function modify(Show $show);
        function moviesOnShow();
        function getMoviesIdWithoutRepeating($id);
        function getShowsOfMovie(Movie $movie);
        
    }

?>