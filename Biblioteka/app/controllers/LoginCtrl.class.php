<?php
    namespace app\controllers;

    use core\App;
    use core\Utils;
    use core\FunctionsDB;
    use core\ParamUtils;
    use core\RoleUtils;
    use core\SessionUtils;

    use app\forms\LoginForm;

    use app\transfer\User;

    class LoginCtrl {
        private $form;
        private $pass;

        public function __construct() { $this->form = new LoginForm(); }

        public function validate() {
            $this->form->login = ParamUtils::getFromRequest('login');
            $this->form->pass = ParamUtils::getFromRequest('pass');

            if (!isset($this->form->login)) return false;

            if (empty($this->form->login)) { Utils::addErrorMessage('Nie podano loginu'); }
            if (empty($this->form->pass)) { Utils::addErrorMessage('Nie podano hasła'); }

            if (App::getMessages()->isError()) return false;

            $where = ["login" => $this->form->login];
            $column = ["password", "role", "id_employee", "active"];
            $employee = FunctionsDB::getRecords("get", "employee", null, $column, $where);

            if (isset($employee["password"]) && $this->form->pass == $employee["password"] && $employee["active"] == 1) { 
                RoleUtils::addRole($employee["role"]);
                
                SessionUtils::storeObject("user", new User($this->form->login, $employee["role"]));
                SessionUtils::store("id_employee", $employee["id_employee"]);
            } else { Utils::addErrorMessage('Niepoprawny login lub hasło'); }

            return !App::getMessages()->isError();
        }

        public function action_login() {
            if ($this->validate()) { App::getRouter()->redirectTo("main"); } 
            else { $this->generateView(); }
        }

        public function action_logout() {
            session_destroy();

            App::getRouter()->redirectTo('login');
        }

        public function generateView() {
            App::getSmarty()->assign('form', $this->form);
            
            App::getSmarty()->display('LoginView.tpl');
        }
    }
