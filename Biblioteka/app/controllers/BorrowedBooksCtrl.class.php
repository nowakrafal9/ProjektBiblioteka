<?php
    namespace app\controllers;

    use core\App;
    use core\Utils;
    use core\ParamUtils;
    
    use app\forms\BorrowedBooksForm;
    use app\forms\ReaderListForm;
     
    class BorrowedBooksCtrl {
        private $borrowed;
        private $borrower;
        private $records;
        private $numRecords;
        
        public function __construct() { 
            $this->borrowed = new BorrowedBooksForm(); 
            $this->reader = new ReaderListForm();
        }
        
        public function getBorrowedFormParams() {
            // Get form HTML
                $this->borrowed->id_book = ParamUtils::getFromRequest('id_book');
                $this->borrowed->id_reader = ParamUtils::getFromRequest('id_reader');
                $this->borrowed->status = ParamUtils::getFromRequest('status');
     
            return !App::getMessages()->isError();
        } 
        
        public function getBorrowerFormParams() {
            // Get form HTML
                $this->reader->id_reader = ParamUtils::getFromRequest('id_reader');
                $this->reader->name = ParamUtils::getFromRequest('name');
                $this->reader->surname = ParamUtils::getFromRequest('surname');
     
            return !App::getMessages()->isError();
        }   
        
        public function getFromURL() {
            // Get form URL
                $this->borrowed->id_book = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');
                $this->borrowed->id_reader = ParamUtils::getFromCleanURL(2, false);
                
            return !App::getMessages()->isError();
        }   
        
        public function getBorrowedRecords($param){
            try {
                $this->records = App::getDB()->get("borrowed_books", 
                    ["[><]book_stock" => ["book_stock.id_book" => "id_book"], 
                     "[><]borrower_info" => ["borrower_info.id_borrower" => "id_borrower"]], 
                     $param,
                    ["borrowed_books.id_book" =>  $this->borrowed->id_book]);
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }    
            
            return $this->records;
        }
        
        public function getBorrowerRecords($param){
            try {
                $this->records = App::getDB()->get("borrowed_books",  
                     ["[><]borrower_info" => ["borrower_info.id_borrower" => "id_borrower"]], 
                     $param,
                    ["borrowed_books.id_book" =>  $this->borrowed->id_book]);
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }    
            
            return $this->records;
        }
        
        public function getBorrowBookRecords($param){
            try {
                $this->records = App::getDB()->get("book_stock", 
                    ["[><]book_info" => ["book_stock.book_code" => "book_code"]], 
                     $param,
                    ["book_stock.id_book" =>  $this->borrowed->id_book]);
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }    
            
            return $this->records;
        }
        
        public function action_borrowedList(){ 
            // Get params
                $this->getBorrowedFormParams();
            
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
                try {
                    $this->numRecords = App::getDB()->count("borrowed_books", $where);
                } catch (\PDOException $e) {
                    Utils::addErrorMessage('Wystąpił błąd podczas liczenia rekordów');
                    if (App::getConf()->debug)
                        Utils::addErrorMessage($e->getMessage());
                }
                App::getSmarty()->assign('numRecords', $this->numRecords);
                      
            // Get today date
                App::getSmarty()->assign('dateToday', date("Y-m-d"));
            
            // Get logged user name
                App::getSmarty()->assign('user',unserialize($_SESSION['user']));
           
            // Redirect to page
                App::getSmarty()->assign('pageMode',"borrowedList");
                App::getSmarty()->display('Borrowed.tpl');
        }
        
        public function action_borrowedInfo(){ 
            // Get params
                $this->getFromURL();
 
            // Get borrowed book info
                App::getSmarty()->assign('id_book', $this->getBorrowedRecords("borrowed_books.id_book"));
                App::getSmarty()->assign('title', $this->getBorrowedRecords("book_stock.title"));
                App::getSmarty()->assign('borrow_date', $this->getBorrowedRecords("borrowed_books.borrow_date"));
                App::getSmarty()->assign('return_date', $this->getBorrowedRecords("borrowed_books.return_date"));
                
                App::getSmarty()->assign('id_borrower', $this->getBorrowerRecords("borrowed_books.id_borrower"));    
                App::getSmarty()->assign('name', $this->getBorrowerRecords("borrower_info.name"));
                App::getSmarty()->assign('surname', $this->getBorrowerRecords("borrower_info.surname"));
                App::getSmarty()->assign('phone_number', $this->getBorrowerRecords("borrower_info.phone_number"));
                
            // Get logged user name
                App::getSmarty()->assign('user',unserialize($_SESSION['user']));
                
            // Redirect to page
                App::getSmarty()->assign('pageMode',"borrowedInfo");
                App::getSmarty()->display('Borrowed.tpl');
        }
        
        public function action_borrowedBorrow(){ 
            // Get params
                $this->getFromURL();
            
            // Get today date
                $today = date("Y-m-d");
                
            if(isset($this->borrowed->id_reader)){
                // Insert into db info about borrowed book
                    try{
                        App::getDB()->insert("borrowed_books", 
                            ["id_book" => $this->borrowed->id_book,
                             "id_borrower" => $this->borrowed->id_reader,
                             "id_employee" => 1,
                             "borrow_date" => date("Y-m-d"),
                             "return_date" => date("Y-m-d")
                            ]);

                        App::getDB()->update("book_stock", 
                            ["borrowed" => 1 ], 
                            ["id_book" => $this->borrowed->id_book]);
                    } catch (\PDOException $e) {
                        Utils::addErrorMessage('Wystąpił błąd podczas modyfikacji rekordów');
                        if (App::getConf()->debug)
                            Utils::addErrorMessage($e->getMessage());
                    }

                    App::getSmarty()->assign('pageMode',"bookBorrowed");
            }
            else{
                // Get book info
                    App::getSmarty()->assign('id_book', $this->getBorrowBookRecords("book_stock.id_book"));
                    App::getSmarty()->assign('book_code', $this->getBorrowBookRecords("book_stock.book_code"));
                    App::getSmarty()->assign('title', $this->getBorrowBookRecords("book_stock.title"));

                    $this->getBorrowerFormParams();
                    
                    $filter_params = [];
                    if (isset($this->reader->id_reader) && strlen($this->reader->id_reader) > 0) {
                        $filter_params['id_borrower[~]'] = $this->reader->id_reader.'%';
                    }
                    if (isset($this->reader->name) && strlen($this->reader->name) > 0) {
                        $filter_params['name[~]'] = $this->reader->name.'%';
                    }
                    if (isset($this->reader->surname) && strlen($this->reader->surname) > 0) {
                        $filter_params['surname[~]'] = $this->reader->surname.'%';
                    }
                    
                    if(isset($this->reader->id_reader) || isset($this->reader->name) || isset($this->reader->surname)){
                        $num_params = sizeof($filter_params);
                        if ($num_params > 1) {
                            $where = ["AND" => &$filter_params];
                        } else {
                            $where = &$filter_params;
                        }
                        $where ["ORDER"] = ["surname","name"];
                        
                        try {
                            $this->records = App::getDB()->select("borrower_info",
                            ["id_borrower",
                             "name", 
                             "surname"],
                            $where);
                        } catch (\PDOException $e) {
                            Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                            if (App::getConf()->debug)
                                Utils::addErrorMessage($e->getMessage());
                        }
                        App::getSmarty()->assign('records', $this->records);      
                             
                        App::getSmarty()->assign('formSent', 1); 
                    }
                    
                    App::getSmarty()->assign('searchForm', $this->reader);
                    
                    App::getSmarty()->assign('pageMode',"selectBorrower"); 
            }
                
            // Get logged user name
                App::getSmarty()->assign('user',unserialize($_SESSION['user']));
                
            // Redirect to page
                App::getSmarty()->display('BorrowedBorrow.tpl');
        }
        
        public function action_borrowedReturn(){ 
            // Get params
                $this->getFromURL();
            
                try {
                    App::getDB()->delete("borrowed_books", [ "id_book" => $this->borrowed->id_book]);
                    App::getDB()->update("book_stock", [ "borrowed" => 0 ], [ "id_book" => $this->borrowed->id_book]);
                } catch (\PDOException $e) {
                    Utils::addErrorMessage('Wystąpił błąd podczas modyfikacji rekordów');
                    if (App::getConf()->debug)
                        Utils::addErrorMessage($e->getMessage());
                }    
                
            // Get logged user name
                App::getSmarty()->assign('user',unserialize($_SESSION['user']));
                
            // Redirect to page
                App::getSmarty()->display('BorrowedReturn.tpl');
        }
    }
