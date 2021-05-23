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
            
            return !App::getMessages()->isError();
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
            
            # Get book titles list from DB
                $column = ["id_book", "title"];
                App::getSmarty()->assign('records', FunctionsDB::getRecords("select", "book_info", null, $column, $where));
                          
            # Get number of titles in library
                FunctionsDB::countRecords("book_stock", $where);  
                       
           # Redirect to page
                App::getSmarty()->assign('pageMode',"bookList");
                $this->generateView();
        }
        
        public function action_bookInfo(){
            # Get params
                $this -> getURL();      
            
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
                App::getSmarty()->assign('pageMode',"bookInfo"); 
                $this->generateView();
        }
        
        public function action_bookStock(){ 
            # Get params
                $this -> getForm("bookStock");

            # Set filter params    
                $filter_params = [];
                if (isset($this->book->book_code) && strlen($this->book->book_code) > 0) {
                    $filter_params['id_book[~]'] = $this->book->book_code.'%';
                }
                if (isset($this->book->title) && strlen($this->book->title) > 0) {
                    $filter_params['title[~]'] = $this->book->title.'%';
                }
                if (isset($this->book->borrowed) && strlen($this->book->borrowed) > 0) {
                    $filter_params['borrowed[~]'] = $this->book->borrowed.'%';
                }
                App::getSmarty()->assign('searchForm', $this->book);

            # Prepare $where for DB operation
                $order = ["id_book"];
                $where = FunctionsDB::prepareWhere($filter_params, $order);          

            # Get books in library from DB
                $join =["[><]book_info" => ["book_code" => "book_code"]];
                $column = ["book_stock.id_book", "book_info.title", "book_stock.borrowed"];

                App::getSmarty()->assign('records', FunctionsDB::getRecords("select", "book_stock", $join, $column, $where));

            # Get number of books in library
                FunctionsDB::countRecords("book_stock", $where); 

            # Redirect to page
                App::getSmarty()->assign('pageMode',"bookStock"); 
                $this->generateView();
        }
    
        public function generateView() {
            App::getSmarty()->assign('user', SessionUtils::loadObject("user", true));
            App::getSmarty()->display('Book.tpl');
        }
    }
