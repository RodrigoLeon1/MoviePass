<?php

    namespace Controllers;

    use DAO\ShowDAO as ShowDAO;
    use Models\Show as Show;
    use DAO\CinemaDAO as CinemaDAO;
    use Models\Cinema as Cinema;

    class ShowController {
        private $showDAO;
        private $cinemaDAO;
    
        public function __construct() {
            $this->showDAO = new ShowDAO();
            $this->cinemaDAO = new CinemaDAO();
        }
    
        public function add($id_cinema, $id_movie, $day, $hour) {
            $show = new Show();
            $show->setIdCinema($id_cinema);
            $show->setIdMovie($id_movie);
            $show->setDay($day);
            $show->setHour($hour);
            $this->showDAO->Add($show);
            $this->addShowPath();
        }
        
        public function addShowPath() {
            if ($_SESSION["loggedUser"]) {
                $admin = $_SESSION["loggedUser"];
				require_once(VIEWS_PATH . "admin-head.php");
				require_once(VIEWS_PATH . "admin-header.php");
				require_once(VIEWS_PATH . "admin-show-add.php");
			}
        }

    }

    

?>