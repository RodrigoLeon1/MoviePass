<?php
    namespace DAO;

    use Models\CinemaRoom as CinemaRoom;
    use Models\Show as Show;

    interface ICinemaRoomDAO {
        
        function add(CinemaRoom $cinemaRoom);
        function getAll();
        function deleteById(CinemaRoom $cinemaRoom);
        function getById(CinemaRoom $cinemaRoom);
        function checkNameInCinema($name, $id_cinema);
        function modify(CinemaRoom $cinemaRoom);
        function getByName(CinemaRoom $cinemaRoom);
        function getShowsOfCinemaRoom(CinemaRoom $cinemaRoom);
        function getByIdShow(Show $show);
        function getSales(CinemaRoom $cinemaRoom);

    }

?>