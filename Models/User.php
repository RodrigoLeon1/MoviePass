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
			return $this->role;
		}

		public function setRole($role) {
			$this->role = $role;
			return $this;
		}
	}

?>
