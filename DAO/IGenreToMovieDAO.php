<?php

    namespace DAO;

    use Models\GenreToMovie as GenreToMovie;
    use Models\Genre as Genre;
    use Models\Movie as Movie;
    use Models\Show as Show;

    interface IGenreToMovieDAO {
        
        function add(GenreToMovie $genreToMovie);
        function getGenresOfNowPlaying();
        function getGenresOfMovieFromApi(Movie $movie);
        function getAll();
        function getByGenre(Genre $genre);
        function getByDate(Show $show);
        function getByGenreAndDate(Genre $genre, Show $show);
        function getGenresOfMovie(Movie $movie);
        function getGenresOfShows();

    }

?>