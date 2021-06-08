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
        
        private $page;
        private $recordsPerPage = 10;
        
        public function __construct() {
            $this->book = new BorrowedBooksForm(); 
            $this->reader = new ReaderListForm();
        }
        
        public function getForm() {
            $this->book->id_book = ParamUtils::getFromRequest('id_book');
            $this->book->id_reader = ParamUtils::getFromRequest('id_reader');
            $this->book->status = ParamUtils::getFromRequest('status');
        } 
              
        public function getURL() {
            $this->book->id_book = ParamUtils::getFromCleanURL(1, true, "Błąd przesłania parametrów"); 
               
            return !App::getMessages()->isError();
        }
              
        public function action_borrowedList(){ 
            # Get params
            $this->getForm();
            
            # Set filter params
            $filter_params = [];
            if (isset($this->book->id_book) && strlen($this->book->id_book) > 0) {
                $filter_params['id_book[~]'] = $this->book->id_book.'%';
            }
            if (isset($this->book->id_reader) && strlen($this->book->id_reader) > 0) {
                $filter_params['id_borrower[~]'] = $this->book->id_reader.'%';
            }
            if (isset($this->book->status)) {
                if($this->book->status == 0){ $filter_params['id_borrower[>=]'] = date("Y-m-d"); }
                if($this->book->status == 1){ $filter_params['id_borrower[<]'] = date("Y-m-d"); }
            }
            App::getSmarty()->assign('searchForm', $this->book);
                
            # Prepare $where for DB operation
            $order = ["return_date"];
            $where = FunctionsDB::prepareWhere($filter_params, $order);
                
            # Get number of found books 
            $numRecords = FunctionsDB::countRecords("borrowed_books", $where); 
            App::getSmarty()->assign("numRecords", $numRecords);
            
            if($numRecords > 0){
                # Get page
                $this->page = FunctionsDB::getPage($numRecords, $this->recordsPerPage);

                # Get offset of books
                $offset = $this->recordsPerPage*($this->page-1);
                $where["LIMIT"] = [$offset, $this->recordsPerPage];

                # Get borrowed books list
                $column = ["id_book", "id_borrower", "borrow_date", "return_date"];
                App::getSmarty()->assign('records', FunctionsDB::getRecords("select", "borrowed_books", null, $column, $where));

                # Get today date
                App::getSmarty()->assign('dateToday', date("Y-m-d"));
            }
            
            # Redirect to page
            $this->generateView("Borrowed_borrowedList.tpl");
        }
        
        public function action_borrowedReturn(){ 
            if($this -> getURL()){
                # Check if book exists
                if(!App::getDB()->has("borrowed_books", ["id_book" => $this->book->id_book])){
                    App::getRouter()->redirectTo("borrowedList");
                }
                
                # Get borrowed book info
                $where = ["borrowed_books.id_book" => $this->book->id_book];

                $join = ["[><]book_stock" => ["book_stock.id_book" => "id_book"]];       
                $column = ["borrowed_books.id_book", "book_stock.title", "borrowed_books.borrow_date", "borrowed_books.return_date"];
                App::getSmarty()->assign('book', FunctionsDB::getRecords("get", "borrowed_books", $join, $column, $where)); 

                $returnDate = FunctionsDB::getRecords("get", "borrowed_books", $join, "borrowed_books.return_date", $where);
                $today = date("Y-m-d");
                $timeLeft = round((strtotime($returnDate) - strtotime($today))/ (60 * 60 * 24));
                if($timeLeft >= 0){
                    App::getSmarty()->assign('afterDeadline', 'no');
                    if($timeLeft == 1){ App::getSmarty()->assign('timeLeft', $timeLeft." dzień"); }
                    else{ App::getSmarty()->assign('timeLeft', $timeLeft." dni"); }
                } else{
                    if($timeLeft == -1){ App::getSmarty()->assign('timeLeft', ($timeLeft * (-1))." dzień"); }
                    else{ App::getSmarty()->assign('timeLeft', ($timeLeft * (-1))." dni"); }        
                }

                $join = ["[><]borrower_info" => ["borrowed_books.id_borrower" => "id_borrower"]]; 
                $column = ["borrowed_books.id_borrower", "borrower_info.name", "borrower_info.surname", "borrower_info.phone_number"];
                App::getSmarty()->assign('reader', FunctionsDB::getRecords("get", "borrowed_books", $join, $column, $where));


                # Redirect to page
                $this->generateView("Borrowed_borrowedReturn.tpl");
            } else{
                App::getRouter()->redirectTo("borrowedList");
            }
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
                          
            # Redirect to borrowedList
            Utils::addInfoMessage("Zwrócono książkę o kodzie ".$this->book->id_book);
            App::getRouter()->forwardTo("borrowedList");
        }
        
        public function generateView($page) {
            App::getSmarty()->assign('user', SessionUtils::loadObject("user", true));
            
            App::getSmarty()->display($page);
        }
    }