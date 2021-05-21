<?php
    namespace app\controllers;

    use core\App;
    use core\FunctionsDB;
    use core\Utils;
    use core\ParamUtils;
    use core\SessionUtils;
        
    use app\forms\BorrowedBooksForm;
    use app\forms\ReaderListForm;
    
    class BorrowedBooksCtrl {
        private $book;
        private $reader;
        
        public function __construct() { 
            $this->book = new BorrowedBooksForm(); 
            $this->reader = new ReaderListForm();
        }
        
        public function getForm1/* Form for filtering borrowed books */() {
            $this->book->id_book = ParamUtils::getFromRequest('id_book');
            $this->book->id_reader = ParamUtils::getFromRequest('id_reader');
            $this->book->status = ParamUtils::getFromRequest('status');
     
            return !App::getMessages()->isError();
        } 
        
        public function getForm2/* Form for searching reader */() {
            $this->reader->id_reader = ParamUtils::getFromRequest('id_reader');
            $this->reader->name = ParamUtils::getFromRequest('name');
            $this->reader->surname = ParamUtils::getFromRequest('surname');
     
            return !App::getMessages()->isError();
        } 
        
        public function getURL() {
            $this->book->id_book = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');
            $this->book->id_reader = ParamUtils::getFromCleanURL(2, false);
                
            return !App::getMessages()->isError();
        }
              
        public function action_borrowedList(){ 
            # Get params
                $this->getForm1();
            
            # Set filter params
                $filter_params = [];
                if (isset($this->book->id_book) && strlen($this->book->id_book) > 0) {
                    $filter_params['id_book[~]'] = $this->book->id_book.'%';
                }
                if (isset($this->book->id_reader) && strlen($this->book->id_reader) > 0) {
                    $filter_params['id_borrower[~]'] = $this->book->id_reader.'%';
                }
                
            # Prepare $where for DB operation
                $order = ["return_date"];
                $where = FunctionsDB::prepareWhere($filter_params, $order);
                
            # Get borrowed books list
                $column = ["id_book", "id_borrower", "borrow_date", "return_date"];
                App::getSmarty()->assign('records', FunctionsDB::getRecords("select", "borrowed_books", null, $column, $where));
                       
            # Get number of borrowed books
                FunctionsDB::countRecords("borrowed_books", $where); 
                      
            # Get today date
                App::getSmarty()->assign('dateToday', date("Y-m-d"));
                
            # Redirect to page
                App::getSmarty()->assign('pageMode',"borrowedList");
                $this->generateView('Borrowed.tpl');
        }
        
        public function action_borrowedInfo(){ 
            # Get params
                $this->getURL();
 
            # Get borrowed book info
                $where = ["borrowed_books.id_book" => $this->book->id_book];
                
                $join = ["[><]book_stock" => ["book_stock.id_book" => "id_book"], 
                         "[><]borrower_info" => ["borrower_info.id_borrower" => "id_borrower"]];        
                App::getSmarty()->assign('id_book', FunctionsDB::getRecords("get", "borrowed_books", $join, "borrowed_books.id_book", $where));
                App::getSmarty()->assign('title', FunctionsDB::getRecords("get", "borrowed_books", $join, "book_stock.title", $where));
                App::getSmarty()->assign('borrow_date', FunctionsDB::getRecords("get", "borrowed_books", $join, "borrowed_books.borrow_date", $where));
                App::getSmarty()->assign('return_date', FunctionsDB::getRecords("get", "borrowed_books", $join, "borrowed_books.return_date", $where));
                
                $join = ["[><]borrower_info" => ["borrower_info.id_borrower" => "id_borrower"]];            
                App::getSmarty()->assign('id_borrower', FunctionsDB::getRecords("get", "borrowed_books", $join, "borrowed_books.id_borrower", $where));
                
                $join = ["[><]borrower_info" => ["borrowed_books.id_borrower" => "id_borrower"]]; 
                App::getSmarty()->assign('name', FunctionsDB::getRecords("get", "borrowed_books", $join, "borrower_info.name", $where));
                App::getSmarty()->assign('surname', FunctionsDB::getRecords("get", "borrowed_books", $join, "borrower_info.surname", $where));
                App::getSmarty()->assign('phone_number', FunctionsDB::getRecords("get", "borrowed_books", $join, "borrower_info.phone_number", $where));
             
            # Redirect to page
                App::getSmarty()->assign('pageMode',"borrowedInfo");
                $this->generateView('Borrowed.tpl');
        }
        
        public function action_bookBorrow(){ 
            # Get params
                $this->getURL();
                
            # Get today date
                $today = date("Y-m-d");
            
            # Choose path to go
                if(isset($this->book->id_reader)){
                    App::getSmarty()->assign('pageMode',"bookBorrowed");
                }
                else{
                    App::getSmarty()->assign('pageMode',"bookBorrowed");
                }
                
            # Redirect to page
                $this->generateView('BookBorrowed.tpl');
        }
        
        public function action_bookReturn(){ 
            # Get params
                $this->getURL();
            
                try {
                    App::getDB()->delete("borrowed_books", [ "id_book" => $this->book->id_book]);
                    App::getDB()->update("book_stock", [ "borrowed" => 0 ], [ "id_book" => $this->book->id_book]);
                } catch (\PDOException $e) {
                    Utils::addErrorMessage('Wystąpił błąd podczas modyfikacji rekordów');
                    if (App::getConf()->debug)
                        Utils::addErrorMessage($e->getMessage());
                }    
                          
            # Redirect to page
                $this->generateView('BookReturned.tpl');
        }
        
        public function generateView($destination) {
            App::getSmarty()->assign('user', SessionUtils::loadObject("user", true));
            App::getSmarty()->display($destination);
        }
    }