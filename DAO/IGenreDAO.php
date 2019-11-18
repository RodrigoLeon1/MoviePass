<?php
    namespace DAO;

    use Models\Genre as Genre;

    interface IGenreDAO {
        
        function add(Genre $genre);
        function getAll();
        function getById(Genre $genre);
        function getByName(Genre $genre);
        function getNameGenre(Genre $genre);        

    }

?>