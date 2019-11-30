<?php
    namespace DAO;

    use Models\Cinema as Cinema;

    interface ICinemaDAO {
        
        function add(Cinema $cinema);
        function getAll();
        function enableById(Cinema $cinema);
        function disableById(Cinema $cinema);
        function getById(Cinema $cinema);
        function modify(Cinema $cinema);
        function getByName(Cinema $cinema);
        function getShowsOfCinema(Cinema $cinema);
        function getSales(Cinema $cinema);

    }

?>