<?php
    namespace app\controllers;

    use core\App;
    use core\Utils;
    use core\ParamUtils;
    
    use app\forms\BorrowedBooksForm;
    use app\forms\ReaderListForm;
    
    class BorrowedBooksCtrl2 {
        private $book;
        private $reader;
        private $records;
        private $numRecords;
        
        public function __construct() { 
            $this->book = new BorrowedBooksForm(); 
            $this->reader = new ReaderListForm();
        }
        
        public function getForm1() {
            $this->$book->id_book = ParamUtils::getFromRequest('id_book');
            $this->$book->id_reader = ParamUtils::getFromRequest('id_reader');
            $this->$book->status = ParamUtils::getFromRequest('status');
     
            return !App::getMessages()->isError();
        } 
        
        public function getForm2() {
            $this->reader->id_reader = ParamUtils::getFromRequest('id_reader');
            $this->reader->name = ParamUtils::getFromRequest('name');
            $this->reader->surname = ParamUtils::getFromRequest('surname');
     
            return !App::getMessages()->isError();
        } 
        
        public function getURL() {
            $this->borrowed->id_book = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');
            $this->borrowed->id_reader = ParamUtils::getFromCleanURL(2, false);
                
            return !App::getMessages()->isError();
        }
        
        public function getRecords($mode, $table, $join, $column, $where) {
            try {
                if($mode == "borrowedInfo"){ $this->records = App::getDB()->get($table,$join,$column,$where); }
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                if (App::getConf()->debug) { Utils::addErrorMessage($e->getMessage()); }
            }        
            
            return $this->records;
        }
        
        public function countRecords($table, &$where){
            try {
                $this->numRecords = App::getDB()->count($table, $where);
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas liczenia rekordów');
                if (App::getConf()->debug){ Utils::addErrorMessage($e->getMessage()); }
            }
            
            App::getSmarty()->assign('numRecords', $this->numRecords);
        }
        
        public function prepareWhere($filter_params, $order) {
            $num_params = sizeof($filter_params);
                
            if ($num_params > 1) {
                $where = ["AND" => &$filter_params];
            } else {
                $where = &$filter_params;
            }
            $where ["ORDER"] = $order;
            
            return $where;
        }
        
        public function action_borrowedList(){ 
            # Get params
                $this->getForm1();
            
            # Set filter params
                $filter_params = [];
                if (isset($this->borrowed->id_book) && strlen($this->borrowed->id_book) > 0) {
                    $filter_params['id_book[~]'] = $this->borrowed->id_book.'%';
                }
                if (isset($this->borrowed->id_reader) && strlen($this->borrowed->id_reader) > 0) {
                    $filter_params['id_borrower[~]'] = $this->borrowed->id_reader.'%';
                }
                
            # Prepare $where for DB operation
                $order = ["return_date"];
                $where = $this->prepareWhere($filter_params, $order);
                
            # Get borrowed books list
                try {
                    $this->records = App::getDB()->select("borrowed_books", [ "id_book", "id_borrower", "borrow_date", "return_date"], $where);
                } catch (\PDOException $e) {
                    Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                    if (App::getConf()->debug)
                        Utils::addErrorMessage($e->getMessage());
                }
                App::getSmarty()->assign('records', $this->records);
                
            # Get number of borrowed books
                $this->countRecords("borrowed_books", $where); 
                      
            # Get today date
                App::getSmarty()->assign('dateToday', date("Y-m-d"));
                
            # Redirect to page
                App::getSmarty()->assign('pageMode',"borrowedList");
                $this->generateView();
        }
        
        public function action_borrowedInfo(){ 
            # Get params
                $this->getURL();
 
            # Get borrowed book info
                $where = ["borrowed_books.id_book" => $this->borrowed->id_book];
                
                $join = ["[><]book_stock" => ["book_stock.id_book" => "id_book"], 
                         "[><]borrower_info" => ["borrower_info.id_borrower" => "id_borrower"]];        
                App::getSmarty()->assign('id_book', $this->getRecords("borInf", "borrowed_books", $join, "borrowed_books.id_book", $where));
                App::getSmarty()->assign('title', $this->getRecords("borInf", "borrowed_books", $join, "book_stock.title", $where));
                App::getSmarty()->assign('borrow_date', $this->getRecords("borInf", "borrowed_books", $join, "borrowed_books.borrow_date", $where));
                App::getSmarty()->assign('return_date', $this->getRecords("borInf", "borrowed_books", $join, "borrowed_books.return_date", $where));
                
                $join = ["[><]borrower_info" => ["borrower_info.id_borrower" => "id_borrower"]];            
                App::getSmarty()->assign('id_borrower', $this->getRecords("borInf", "borrowed_books", $join, "borrowed_books.id_borrower", $where));
                App::getSmarty()->assign('name', $this->getRecords("borInf", "borrowed_books", $join, "borrower_info.name", $where));
                App::getSmarty()->assign('name', $this->getRecords("borInf", "borrowed_books", $join, "borrower_info.surname", $where));
                App::getSmarty()->assign('name', $this->getRecords("borInf", "borrowed_books", $join, "borrower_info.phone_number", $where));
                
//                App::getSmarty()->assign('id_book', $this->getBorrowedRecords("borrowed_books.id_book"));
//                App::getSmarty()->assign('title', $this->getBorrowedRecords("book_stock.title"));
//                App::getSmarty()->assign('borrow_date', $this->getBorrowedRecords("borrowed_books.borrow_date"));
//                App::getSmarty()->assign('return_date', $this->getBorrowedRecords("borrowed_books.return_date"));
//                
//                App::getSmarty()->assign('id_borrower', $this->getBorrowerRecords("borrowed_books.id_borrower"));    
//                App::getSmarty()->assign('name', $this->getBorrowerRecords("borrower_info.name"));
//                App::getSmarty()->assign('surname', $this->getBorrowerRecords("borrower_info.surname"));
//                App::getSmarty()->assign('phone_number', $this->getBorrowerRecords("borrower_info.phone_number"));
                           
            # Redirect to page
                App::getSmarty()->assign('pageMode',"borrowedInfo");
                $this->generateView();
        }
        
        public function generateView() {
            App::getSmarty()->assign('user',unserialize($_SESSION['user']));
            App::getSmarty()->display('Borrowed.tpl');
        }
    }
