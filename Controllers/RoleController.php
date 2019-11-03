<?php

    namespace Controllers;    
    
    use DAO\RoleDAO as RoleDAO;

    class RoleController {
        
        private $roleDAO;

        public function __construct() {
            $this->roleDAO = new RoleDAO();
        }

        public function getAllRoles() {
            return $this->roleDAO->getAll();
        }


    }
?>