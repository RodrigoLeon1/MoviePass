<?php

    namespace DAO;

    use Models\Show as Show;
    use Models\Movie as Movie;
    use Models\Cinema as Cinema;
    use Models\Ticket as Ticket;
	use Models\CinemaRoom as CinemaRoom;
    use DAO\QueryType as QueryType;
    use DAO\Connection as Connection;
    use DAO\ITicketDAO as ITicketDAO;
    
    class TicketDAO implements ITicketDAO {
        
        private $tableName = "tickets";
        private $connection;

        public function add(Ticket $ticket) {
            try {                
                $query = "CALL tickets_Add(?, ?, ?)";
                $parameters['qr'] = $ticket->getQr();
                $parameters['id_purchase'] = $ticket->getIdPurchase();                            
                $parameters['id_show'] = $ticket->getShow()->getId();   

                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
                return true;
            } catch(Exception $e) {
                return false;
            }
        }
        
        public function getByNumber(Ticket $ticket) {
            try {
                $query = "CALL tickets_GetByNumber(?)";
                $parameters['number'] = $ticket->getTicketNumber();

                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
                $ticket = new Ticket();
                foreach($results as $row) {
                    $ticket->setTicketNumber($row['ticket_number']);
                    $ticket->setQR($row['QR']);
                    $ticket->setIdPurchase($row['id_purchase']);
                    $ticket->setIdShow($row['id_show']);
                }
                return $purchase;                
            } catch(Exception $e) {
                return false;
            }
        }

        public function getAll() {
            try {		
                $ticketList = array();		
                $query = "CALL tickets_GetAll()";
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
                foreach($results as $row) {
                    $ticket = new Ticket();
                    $ticket->setTicketNumber($row['ticket_number']);
                    $ticket->setQR($row['QR']);
                    $ticket->setIdPurchase($row['id_purchase']);
                    $ticket->setIdShow($row['id_show']);
                    array_push ($ticketList, $ticket);
                }				
                return $ticketList;
            }
            catch(Exception $e) {
                return false;
            }
        }
        
        public function getByShowId(Show $show) {
            try {
                $query = "CALL tickets_GetByShowId(?)";
                $parameters['id'] = $show->getId();
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
                $ticketList = array();
                foreach($results as $row) {
                    $ticket = new Ticket();
                    $ticket->setTicketNumber($row['ticket_number']);
                    $ticket->setQR($row['QR']);
                    $ticket->setIdPurchase($row['FK_id_purchase']);
                    $show = new Show();
                    $show->setId($row["FK_id_show"]);
                    $ticket->setShow($show);
                    array_push($ticketList, $ticket);
                }
                return $ticketList;
                
            } catch(Exception $e) {
                return false;
            }
        }
        
        public function getGeneralInfo() {
            try {
                $query = "CALL tickets_GetInfoTicket()";                
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
                $ticketList = array();
                foreach($results as $row) {
                    $ticket = new Ticket();
                    
                    $cinema = new Cinema();
                    $cinema->setId($row["cinema_id"]);
                    $cinema->setName($row["cinema_name"]);

                    $cinemaRoom = new CinemaRoom();
                    $cinemaRoom->setName($row["cinema_room_name"]);
                    $cinemaRoom->setCinema($cinema);

                    $movie = new Movie();
                    $movie->setTitle($row["movie_title"]);

                    $show = new Show();
                    $show->setId($row["show_id"]);
                    $show->setDateStart($row["show_date_start"]);
                    $show->setTimeStart($row["show_time_start"]);
                    $show->setMovie($movie);
                    $show->setCinemaRoom($cinemaRoom);

                    $ticket->setShow($show);

                    array_push($ticketList, $ticket);
                }

                return $ticketList;
                
            } catch(Exception $e) {
                return false;
            }
        }

        public function getInfoShowTickets() {
            try {
                $query = "CALL tickets_ShowsTickets()";                
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
                $ticketList = array();
                foreach($results as $row) {
                    $ticket = new Ticket();
                    
                    $cinema = new Cinema();
                    $cinema->setId($row["cinema_id"]);
                    $cinema->setName($row["cinema_name"]);

                    $cinemaRoom = new CinemaRoom();
                    $cinemaRoom->setName($row["cinema_room_name"]);
                    $cinemaRoom->setCinema($cinema);

                    $movie = new Movie();
                    $movie->setTitle($row["movie_title"]);

                    $show = new Show();
                    $show->setId($row["show_id"]);
                    $show->setDateStart($row["show_date_start"]);
                    $show->setTimeStart($row["show_time_start"]);
                    $show->setMovie($movie);
                    $show->setCinemaRoom($cinemaRoom);

                    $ticket->setShow($show);

                    array_push($ticketList, $ticket);
                }

                return $ticketList;
                
            } catch(Exception $e) {
                return false;
            }
        }

        public function getTicketsOfShows(Show $show) {
            try {
                $query = "CALL tickets_getTicketsOfShows(?)";
                $parameters['id_show'] = $show->getId();
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
                $results = $results[0];

                return $results["count(FK_id_show)"];
                
            } catch(Exception $e) {
                return false;
            }
        }

    }
?>