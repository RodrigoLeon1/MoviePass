<?php

    namespace DAO;

    use Models\Cinema as Cinema;
    use Models\CinemaRoom as CinemaRoom;
    use Models\Show as Show;

    interface ICinemaRoomDAO {
        
        function add(CinemaRoom $cinemaRoom);
        function getAll();
        function enableById(CinemaRoom $cinemaRoom);
        function disableById(CinemaRoom $cinemaRoom);
        function getById(CinemaRoom $cinemaRoom);
        function checkRoomNameInCinema(CinemaRoom $cinemaRoom, Cinema $cinema);
        function modify(CinemaRoom $cinemaRoom);
        function getByName(CinemaRoom $cinemaRoom);
        function getShowsOfCinemaRoom(CinemaRoom $cinemaRoom);
        function getByIdShow(Show $show);
        function getSales(CinemaRoom $cinemaRoom);

    }

?>