<?php
    namespace app\controllers;

    use core\App;
    use core\Utils;
    use core\ParamUtils;
    
    use app\forms\BorrowedBooksForm;
    
    class BorrowedBooksCtrl {
        private $borrowed;
        private $records;
        private $numRecords;
        
        public function __construct() { $this->borrowed = new BorrowedBooksForm(); }
        
        public function validateList() {
            // Get form HTML
                $this->borrowed->id_book = ParamUtils::getFromRequest('id_book');
                $this->borrowed->id_reader = ParamUtils::getFromRequest('id_reader');
                $this->borrowed->status = ParamUtils::getFromRequest('status');
            
            return !App::getMessages()->isError();
        }   
        
        public function action_borrowedList(){ 
            // Get params
                $this->validateList();
            
            // Set filter params
                $filter_params = [];
                if (isset($this->borrowed->id_book) && strlen($this->borrowed->id_book) > 0) {
                    $filter_params['id_book[~]'] = $this->borrowed->id_book.'%';
                }
                if (isset($this->borrowed->id_reader) && strlen($this->borrowed->id_reader) > 0) {
                    $filter_params['id_borrower[~]'] = $this->borrowed->id_reader.'%';
                }
            // Prepare $where for DB operation
                $num_params = sizeof($filter_params);
                if ($num_params > 1) {
                    $where = ["AND" => &$filter_params];
                } else {
                    $where = &$filter_params;
                }
                $where ["ORDER"] = ["return_date"];
                
            // Get borrowed books list
                try {
                $this->records = App::getDB()->select("borrowed_books", [ "id_book", "id_borrower", "borrow_date", "return_date"], $where);
                } catch (\PDOException $e) {
                    Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                    if (App::getConf()->debug)
                        Utils::addErrorMessage($e->getMessage());
                }
                App::getSmarty()->assign('records', $this->records);
                
            // Get number of borrowed books
                $this->numRecords = 0;
                if(!is_null($this->records)){
                    foreach($this->records as $r){
                        $this->numRecords++;      
                    }
                }
                App::getSmarty()->assign('numRecords', $this->numRecords);
                      
            // Get today date
                App::getSmarty()->assign('dateToday', date("Y-m-d"));
            
            // Get logged user name
                App::getSmarty()->assign('user',unserialize($_SESSION['user']));
           
            // Redirect to page
                App::getSmarty()->display('BorrowedList.tpl');
        }
        
        public function action_borrowedInfo(){ 
            // Get logged user name
                App::getSmarty()->assign('user',unserialize($_SESSION['user']));
                
            // Redirect to page
                App::getSmarty()->display('BorrowedInfo.tpl');
        }
    }
