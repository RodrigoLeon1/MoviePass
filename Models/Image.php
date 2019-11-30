<?php

    namespace Models;

    use Models\User as User;

    class Image {
        
        private $imageId;
        private $name;
        private $user;
        
        public function getImageId() {
            return $this->imageId;
        }

        public function setImageId($imageId) {
            $this->imageId = $imageId;
        }  
       
        public function getName() {
            return $this->name;
        }

        public function setName($name) {
            $this->name = $name;
        }        

        public function getUser() {
            return $this->user;
        }

        public function setUser(User $user) {
            $this->user = $user;
        }        
        
    }
?>