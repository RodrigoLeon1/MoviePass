<?php

    namespace DAO;

    use Models\Cinema as Cinema;

    class CinemaDAO
    {

        private $cinemaList = array();

        public function add(Cinema $cinema) {
            $this->retrieveData();
            array_push($this->cinemaList, $cinema);
            $this->saveData();
        }

        public function getAll() {
            $this->retrieveData();
            return $this->cinemaList;
        }

        private function saveData() {
            $arrayToEncode = array();

            foreach ($this->cinemaList as $cinema) {
                $valuesArray["id"] = $cinema->getId();
                $valuesArray["name"] = $cinema->getName();
                $valuesArray["address"] = $cinema->getAddress();
                $valuesArray["capacity"] = $cinema->getCapacity();
                $valuesArray["price"] = $cinema->getPrice();
                array_push($arrayToEncode, $valuesArray);
            }
            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents($this->getJsonFilePath(), $jsonContent);
        }

		public function remove($id)
		{
			$this->RetrieveData();
			$this->cinemaList = array_filter($this->cinemaList, function($cellPhone) use($id){
				return $cellPhone->getId() != $id;
			});		
			$this->SaveData();
		}

        private function retrieveData()
        {
            $this->cinemaList = array();
            $jsonPath = $this->getJsonFilePath();
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
            foreach ($arrayToDecode as $valuesArray) {
                $cinema = new Cinema();
                $cinema->setId($valuesArray["id"]);
                $cinema->setName($valuesArray["name"]);
                $cinema->setAddress($valuesArray["address"]);
                $cinema->setCapacity($valuesArray["capacity"]);
                $cinema->setPrice($valuesArray["price"]);
                array_push($this->cinemaList, $cinema);
            }
        }

        function getJsonFilePath(){

            $initialPath = "Data/cinemas.json";

            if(file_exists($initialPath)){
                $jsonFilePath = $initialPath;
            }else{
                $jsonFilePath = "../".$initialPath;
            }

            return $jsonFilePath;
        }
    }

 ?>
