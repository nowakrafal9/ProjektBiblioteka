<?php
    namespace app\controllers;

    use core\App;
    use core\FunctionsDB;
    use core\Utils;
    use core\ParamUtils;
    use core\SessionUtils;
        
    use app\forms\BookInfoForm;
    
    class BookCtrl {
        private $book;
        
        private $page;
        private $recordsPerPage = 5;
        
        public function __construct() { $this->book = new BookInfoForm(); }
        
        public function getForm($source) {
            if($source == "bookList"){
                $this->book->title = ParamUtils::getFromRequest('title');
            }
            
            if($source == "bookStock"){
                $this->book->book_code = ParamUtils::getFromRequest('book_code');
                $this->book->title = ParamUtils::getFromRequest('title');
                $this->book->borrowed = ParamUtils::getFromRequest('borrowed');
            }
        }
        
        public function getURL() {
            $this->book->id_book = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');

            return !App::getMessages()->isError();
        }
           
        public function action_bookList(){   
            # Get params
            $this -> getForm("bookList");
            
            # Set filter params
            $filter_params = [];
            if (isset($this->book->title) && strlen($this->book->title) > 0) {
                $filter_params['title[~]'] = $this->book->title.'%';
            }
            App::getSmarty()->assign('searchForm', $this->book);
                
            # Prepare $where for DB operation
            $order = ["title"];
            $where = FunctionsDB::prepareWhere($filter_params, $order);
            
            # Get number of found books 
            $numRecords = FunctionsDB::countRecords("book_info", $where); 
            App::getSmarty()->assign("numRecords", $numRecords);
            
            # Get page
            $this->page = FunctionsDB::getPage($numRecords, $this->recordsPerPage);
            
            # Get offset of books
            $offset = $this->recordsPerPage*($this->page-1);
            $where["LIMIT"] = [$offset, $this->recordsPerPage];
            
            # Get book titles list from DB
            $column = ["id_book", "title"];
            App::getSmarty()->assign('records', FunctionsDB::getRecords("select", "book_info", null, $column, $where));
                                         
           # Redirect to page
            $this->generateView("Book_bookList.tpl");
        }
        
        public function action_bookInfo(){
            if($this -> getURL()){   
                # Check if title exists
                if(!App::getDB()->has("book_info", ["id_book" => $this->book->id_book])){
                    App::getRouter()->redirectTo("bookList");
                }
                
                # Get book info    
                $join = ["[><]author_info" => ["author" => "id_author"]];
                $colum = ["book_info.book_code", "book_info.title", "book_info.pages", "author_info.name", 
                          "author_info.surname", "book_info.genre", "book_info.publisher"];
                $where = ["id_book" => $this->book->id_book];
                App::getSmarty()->assign('book', FunctionsDB::getRecords("get", "book_info", $join, $colum,$where));

                # Get number of books
                $book_code = FunctionsDB::getRecords("get", "book_info",null ,"book_code",$where);
                $where = ["book_code" => $book_code];  
                App::getSmarty()->assign('allBooks', FunctionsDB::countRecords("book_stock", $where));     

                $where = ["book_code" => $book_code, "borrowed" => 1];
                App::getSmarty()->assign('borrowedBooks', FunctionsDB::countRecords("book_stock", $where)); 

                # Redirect to page
                $this->generateView("Book_bookInfo.tpl");
            }else{
                App::getRouter()->redirectTo("bookList");
            }
        }
        
        public function action_bookStock(){ 
            # Get params
            $this -> getForm("bookStock");
            
            # Set filter params    
            $filter_params = [];
            if (isset($this->book->book_code) && strlen($this->book->book_code) > 0) {
                $filter_params['book_stock.id_book[~]'] = $this->book->book_code.'%';
            }
            if (isset($this->book->title) && strlen($this->book->title) > 0) {
                $filter_params['book_stock.title[~]'] = $this->book->title.'%';
            }
            if (isset($this->book->borrowed) && strlen($this->book->borrowed) > 0) {
                $filter_params['book_stock.borrowed[~]'] = $this->book->borrowed.'%';
            }
            App::getSmarty()->assign('searchForm', $this->book);

            # Prepare $where for DB operation
            $order = ["book_stock.id_book"];
            $where = FunctionsDB::prepareWhere($filter_params, $order);          

            # Get number of found books 
            $numRecords = FunctionsDB::countRecords("book_stock", $where); 
            App::getSmarty()->assign("numRecords", $numRecords);
            
            # Get page
            $this->page = FunctionsDB::getPage($numRecords, $this->recordsPerPage);
            
            # Get offset of books
            $offset = $this->recordsPerPage*($this->page-1);
            $where["LIMIT"] = [$offset, $this->recordsPerPage];
            
            # Get books in library from DB
            $join =["[><]book_info" => ["book_code" => "book_code"]];
            $column = ["book_stock.id_book", "book_info.title", "book_stock.borrowed"];

            App::getSmarty()->assign('records', FunctionsDB::getRecords("select", "book_stock", $join, $column, $where));
            
            # Redirect to page
            $this->generateView("Book_bookStock.tpl");
        }
    
        public function generateView($page) {
            App::getSmarty()->assign('user', SessionUtils::loadObject("user", true));
            
            App::getSmarty()->display($page);
        }
    }
