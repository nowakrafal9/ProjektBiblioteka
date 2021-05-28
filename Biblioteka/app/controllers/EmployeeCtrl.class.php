<?php
    namespace app\controllers;

    use core\App;
    use core\Utils;
    use core\FunctionsDB;
    use core\ParamUtils;
    use core\SessionUtils;
    
    use app\forms\EmployeeForm;
    
    class EmployeeCtrl {
        private $employee;
        
        public function __construct() { $this->employee = new EmployeeForm(); }
        
        public function getForm() {
            $this->employee->login = ParamUtils::getFromRequest('login');
            $this->employee->name = ParamUtils::getFromRequest('name');
            $this->employee->surname = ParamUtils::getFromRequest('surname');

            return !App::getMessages()->isError();
        }
        
        public function getFromURL() {
            $this->employee->id_employee = ParamUtils::getFromCleanURL(1,true,'Błędne wywołanie aplikacji');

            return !App::getMessages()->isError();
        }
        
        public function action_employeeList() {
            # Get params
                $this->getForm();
            
            # Set filter params
                $filter_params = [];
                if (isset($this->employee->login) && strlen($this->employee->login) > 0) {
                    $filter_params['login[~]'] = $this->employee->login.'%';
                }
                if (isset($this->employee->name) && strlen($this->employee->name) > 0) {
                    $filter_params['name[~]'] = $this->employee->name.'%';
                }
                if (isset($this->employee->surname) && strlen($this->employee->surname) > 0) {
                    $filter_params['surname[~]'] = $this->employee->surname.'%';
                }
                App::getSmarty()->assign('searchForm', $this->employee);
            
            # Prepare $where for DB operation
                $order = ["login"];
                $where = FunctionsDB::prepareWhere($filter_params, $order);
                
            # Get employee list from DB
                $column = ["id_employee", "login", "name", "surname", "active"];
                App::getSmarty()->assign('records', FunctionsDB::getRecords("select", "employee", null, $column, $where));

            # Get number of employees found
                FunctionsDB::countRecords("employee", $where); 
            
            # Redirect to page
                $this->generateView("Employee_employeeList.tpl");
        }
        
        public function action_employeeInfo() {
            # Get params
                $this->getFromURL();
            
            # Get employee info
                $where = ["id_employee" => $this->employee->id_employee];
                App::getSmarty()->assign('r', FunctionsDB::getRecords("get", "employee", null, "*", $where));

            # Redirect to page
                $this->generateView("Employee_employeeInfo.tpl");
        }
        
        public function generateView($page) {
            App::getSmarty()->assign('user', SessionUtils::loadObject("user", true));
            App::getSmarty()->display($page);
        }
    }
