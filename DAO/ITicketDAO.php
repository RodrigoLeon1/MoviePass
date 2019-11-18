<?php
    namespace DAO;

    use Models\Ticket as Ticket;
    use Models\Show as Show;

    interface ITicketDAO {
        
        function add(Ticket $ticket);
        function getByNumber($number);
        function getAll();
        function getByShowId($id);
        function getGeneralInfo();
        function getTicketsOfShows(Show $show);
        
    }

?>