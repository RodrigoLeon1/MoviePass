<?php

    namespace DAO;

    use Models\Ticket as Ticket;
    use Models\Show as Show;

    interface ITicketDAO {
        
        function add(Ticket $ticket);
        function getByNumber(Ticket $ticket);
        function getAll();
        function getByShowId(Show $show);
        function getGeneralInfo();
        function getTicketsOfShows(Show $show);
        
    }

?>