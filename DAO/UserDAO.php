<?php

    namespace DAO;

    use Models\User as User;

    class UserDAO {

        private $userList = array();

        public function add(User $user) {
            $this->retrieveData();
            array_push($this->userList, $user);
            $this->saveData();
        }

        public function getAll() {
            $this->retrieveData();
            return $this->userList;
        }

        private function saveData() {
            $arrayToEncode = array();

            foreach ($this->userList as $user) {
                $valuesArray["mail"] = $user->getMail();
                $valuesArray["password"] = $user->getPassword();
                $valuesArray["firstname"] = $user->getFirstName();
                $valuesArray["lastname"] = $user->getLastName();
                $valuesArray["dni"] = $user->getDni();
                $valuesArray["role"] = $user->getRole();
                array_push($arrayToEncode, $valuesArray);
            }
            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents($this->getJsonFilePath(), $jsonContent);
        }

        private function retrieveData() {
            $this->userList = array();
            $jsonPath = $this->getJsonFilePath();
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
            foreach ($arrayToDecode as $valuesArray) {
                $user = new User();
                $user->setMail($valuesArray["mail"]);
                $user->setPassword($valuesArray["password"]);
                $user->setFirstName($valuesArray["firstname"]);
                $user->setLastName($valuesArray["lastname"]);
                $user->setDni($valuesArray["dni"]);
                $user->setRole($valuesArray["role"]);
                array_push($this->userList, $user);
            }
        }

        function getJsonFilePath() {

            $initialPath = "Data/users.json";

            if(file_exists($initialPath)){
                $jsonFilePath = $initialPath;
            }else{
                $jsonFilePath = "../".$initialPath;
            }

            return $jsonFilePath;
        }
    }

 ?>
