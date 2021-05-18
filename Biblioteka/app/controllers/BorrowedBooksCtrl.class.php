<?php
    namespace app\controllers;

    use core\App;
    use core\Utils;
    use core\ParamUtils;
    
    class BorrowedBooksCtrl {
        private $borrowed;
        private $records;
        
        public function validateList() {
            // Get form HTML
            
            return !App::getMessages()->isError();
        }   
        
        public function action_borrowedList(){ 
            // Get params
                $this->validateList();
            
            $where ["ORDER"] = ["id_book"];
            
            try {
            $this->records = App::getDB()->select("borrowed_books", [ "id_book", "id_borrower", "borrow_date", "return_date"], $where);
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
            
            App::getSmarty()->assign('records', $this->records);
            App::getSmarty()->assign('dateToday', date("Y-m-d"));
            
            //App::getSmarty()->assign('user', SessionUtils::loadData('user'));
            App::getSmarty()->assign('user',unserialize($_SESSION['user']));
           
            App::getSmarty()->display('BorrowedList.tpl');
        }
    }
