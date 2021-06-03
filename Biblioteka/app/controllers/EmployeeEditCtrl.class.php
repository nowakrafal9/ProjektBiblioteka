<?php
    namespace app\controllers;

    use core\App;
    use core\Utils;
    use core\ParamUtils;
    use core\SessionUtils;
    
    use app\forms\EmployeeForm;
    
    class EmployeeEditCtrl {
        private $employee;
        private $pageMode;
        
        public function __construct() { $this->employee = new EmployeeForm(); }
        
        public function getFromURL(){
            $this->employee->id_employee = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');
            
            return !App::getMessages()->isError();
        }
        
        public function validateSave() {         
            $this->employee->id_employee = ParamUtils::getFromRequest('id_employee', true, 'Błędne wywołanie aplikacji');
            $this->employee->name = ParamUtils::getFromRequest('name', true, 'Błędne wywołanie aplikacji');
            $this->employee->surname = ParamUtils::getFromRequest('surname', true, 'Błędne wywołanie aplikacji');
            $this->employee->employee_code = ParamUtils::getFromRequest('employee_code', true, 'Błędne wywołanie aplikacji');
            $this->employee->login = ParamUtils::getFromRequest('login', true, 'Błędne wywołanie aplikacji');
            $this->employee->password = ParamUtils::getFromRequest('password', true, 'Błędne wywołanie aplikacji');
            $this->employee->role = ParamUtils::getFromRequest('role', true, 'Błędne wywołanie aplikacji');
            $this->employee->active = ParamUtils::getFromRequest('active', false);
            
            if (App::getMessages()->isError()){ return false; }
            
            if (empty(trim($this->employee->name))) { Utils::addErrorMessage('Wprowadź imie'); }
            if (empty(trim($this->employee->surname))) { Utils::addErrorMessage('Wprowadź nazwisko'); }
            if (empty(trim($this->employee->employee_code))) { Utils::addErrorMessage('Wprowadź kod pracownika'); }
            if (empty(trim($this->employee->login))) { Utils::addErrorMessage('Wprowadź login'); }
            if (empty(trim($this->employee->password))) { Utils::addErrorMessage('Wprowadź hasło'); }
            if (empty(trim($this->employee->role))) { Utils::addErrorMessage('Wybierz role'); }
            
            if (App::getMessages()->isError()){ return false; }
            
            if(!preg_match('/^[a-zA-ząćęłńóśźżĄĘŁŃÓŚŹŻ\x20]{3,50}$/', $this->employee->name)){ Utils::addErrorMessage("Podano niepoprawne imię"); }
            if(!preg_match('/^[a-zA-ząćęłńóśźżĄĘŁŃÓŚŹŻ\x20]{3,50}$/', $this->employee->surname)){ Utils::addErrorMessage("Podano niepoprawne nazwisko"); }
            if(!preg_match('/^[0-9]{1,9}$/', $this->employee->employee_code)){ Utils::addErrorMessage("Podano niepoprawny kod pracownika"); }
            if(!preg_match('/^[0-9a-zA-Z_@]{5,45}$/', $this->employee->password)){ Utils::addErrorMessage("Podano niepoprawne hasło"); }
            
            if (App::getMessages()->isError()){ return false; }
            
            $exists = App::getDB()->has("employee", ["employee_code" => $this->employee->employee_code, "id_employee[!]" => $this->employee->id_employee]);     
            if($exists) { Utils::addErrorMessage('Podany kod pracownika jest już zajęty'); }
            
            $exists = App::getDB()->has("employee", ["login" => $this->employee->login, "id_employee[!]" => $this->employee->id_employee]);     
            if($exists) { Utils::addErrorMessage('Podany login jest już zajęty'); }
            
            if (App::getMessages()->isError()){ return false; }
            
            return !App::getMessages()->isError();
        }

        public function action_employeeAdd(){
            $this->pageMode = "employeeAdd";
            $this->generateView();
        }
        
        public function action_employeeEdit() {
            if ($this->getFromURL()) {
                try {
                   $r = APP::getDB()-> get("employee",'*',["id_employee" =>$this->employee->id_employee]);
                   
                   $this->employee->id_employee = $r["id_employee"];
                   $this->employee->name = $r["name"];
                   $this->employee->surname = $r["surname"];
                   $this->employee->employee_code = $r["employee_code"];
                   $this->employee->login = $r["login"];
                   $this->employee->password = $r["password"];
                   $this->employee->role = $r["role"];
                   $this->employee->active = $r["active"];
                    
                } catch (Exception $e) {
                    Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                    if (App::getConf()->debug){ Utils::addErrorMessage($e->getMessage()); }
                } 
            }
            $this->pageMode = "employeeEdit";
            $this->generateView();
        }
        
        public function action_employeeSave() {
            if ($this->validateSave()){
                if (empty(trim($this->employee->active))){ $this->employee->active = 0;}
                try {
                    if ($this->employee->id_employee == '') {
                            App::getDB()->insert("employee", [
                                "name" => $this->employee->name,
                                "surname" => $this->employee->surname,
                                "employee_code" => $this->employee->employee_code,
                                "login" => $this->employee->login,
                                "password" => $this->employee->password,
                                "role" => $this->employee->role,
                                "active" => $this->employee->active
                            ]);
                    }else{
                        App::getDB()->update("employee", [
                            "name" => $this->employee->name,
                            "surname" => $this->employee->surname,
                            "employee_code" => $this->employee->employee_code,
                            "login" => $this->employee->login,
                            "password" => $this->employee->password,
                            "role" => $this->employee->role,
                            "active" => $this->employee->active
                        ], ["id_employee" => $this->employee->id_employee]);
                    }
                } catch (Exception $e) {
                    Utils::addErrorMessage('Wystąpił problem podczas modyfikacji rekordów');
                    if (App::getConf()->debug){ Utils::addErrorMessage($e->getMessage()); }
                }
                App::getRouter()->redirectTo('employeeList');
            }
            else{
                $this->generateView();              
            }    
        }
        
        public function generateView() {
            App::getSmarty()->assign('pageMode', $this->pageMode);
            App::getSmarty()->assign('form', $this->employee);
            App::getSmarty()->assign('user', SessionUtils::loadObject("user", true));
            App::getSmarty()->display('Employee_edit.tpl');
        }
}
