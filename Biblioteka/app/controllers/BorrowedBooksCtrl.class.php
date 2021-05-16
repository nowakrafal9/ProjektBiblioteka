<?php
    namespace app\controllers;

    use core\App;
    use core\Utils;
    use core\ParamUtils;
    
    class BorrowedBooksCtrl {
        private $borrow;
        private $records;
        
        public function validate() {

            return !App::getMessages()->isError();
        }   
        
        public function action_borrowedBooks(){ 
            $this->validate();
            
            $where ["ORDER"] = ["book_code"];
            
            try {
            $this->records = App::getDB()->select("borrowed_books", [ "book_code", "id_borrower", "borrow_date", "return_date"], $where);
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
            
            App::getSmarty()->assign('records', $this->records);
            App::getSmarty()->assign('dateToday', date("Y-m-d"));
            
            //App::getSmarty()->assign('user', SessionUtils::loadData('user'));
            App::getSmarty()->assign('user',unserialize($_SESSION['user']));
           
            App::getSmarty()->display('BorrowedBooks.tpl');
        }
    }
