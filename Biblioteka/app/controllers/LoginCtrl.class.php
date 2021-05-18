<?php

namespace app\controllers;

use core\App;
use core\Utils;
use core\RoleUtils;
use core\ParamUtils;
use core\SessionUtils;
use app\forms\LoginForm;
use app\transfer\User;

class LoginCtrl {
    private $form;
    private $role;
    private $pass;
    
    public function __construct() { $this->form = new LoginForm(); }

    public function validate() {
        $this->form->login = ParamUtils::getFromRequest('login');
        $this->form->pass = ParamUtils::getFromRequest('pass');

        if (!isset($this->form->login)) return false;

        if (empty($this->form->login)) { Utils::addErrorMessage('Nie podano loginu'); }
        if (empty($this->form->pass)) { Utils::addErrorMessage('Nie podano hasła'); }

        if (App::getMessages()->isError()) return false;
              
        $role = App::getDB()->get("employee", "role", [ "login" => $this->form->login]);
        $pass = App::getDB()->get("employee", "password", [ "login" => $this->form->login]);
        
        if (isset($pass) && $this->form->pass == $pass) { 
            RoleUtils::addRole($role);
            
            $_SESSION['user'] = serialize(new User($this->form->login, $role));
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
