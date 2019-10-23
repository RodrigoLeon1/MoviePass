<?php

	namespace Models;

	use Models\ProfileUser as ProfileUser;
	use Models\Role as Role;

    class User extends ProfileUser {

        private $mail;
        private $password;
        private $role;

        public function getMail() {
            return $this->mail;
        }

        public function setMail($mail) {
            $this->mail = $mail;
            return $this;
        }

        public function getPassword() {
            return $this->password;
        }

        public function setPassword($password) {
            $this->password = $password;
            return $this;
        }

		public function getRole() {
			return $this->role->getId();
		}

		public function setRole(Role $role) {
			$this->role = new Role();
			$this->role = $role;
			return $this->role;
		}
	}

?>
