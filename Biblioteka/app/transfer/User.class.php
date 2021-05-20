<?php
    namespace app\transfer;
    
    class User {
        public $login;
        public $role;
        public $id_employee;
        
        public function __construct($login, $role, $id_employee) {
            $this->login = $login;
            $this->role = $role;
            $this->id_employee = $id_employee;
        }
    }
