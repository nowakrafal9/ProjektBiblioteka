<?php
    namespace app\transfer;
    
    class User {
        public $login;
        public $role;
        public $id_employee;
        
        public function __construct($login, $role) {
            $this->login = $login;
            $this->role = $role;
        }
    }
