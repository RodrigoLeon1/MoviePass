<?php
    namespace DAO;

    use Models\Cinema as Cinema;

    interface ICinemaDAO {
        
        function add(Cinema $cinema);
        function getAll();
        function deleteById(Cinema $cinema);
        function getById(Cinema $cinema);
        function modify(Cinema $cinema);
        function getByName(Cinema $cinema);
        function getShowsOfCinema(Cinema $cinema);
        function getSales(Cinema $cinema);

    }

?>