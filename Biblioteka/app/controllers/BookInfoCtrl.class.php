<?php
    namespace app\controllers;

    use core\App;
    use core\FunctionsDB;
    use core\Utils;
    use core\ParamUtils;
    
    use app\forms\BookInfoForm;
    
    class BookInfoCtrl {
        private $book;
        
        public function __construct() { $this->book = new BookInfoForm(); }
        
        public function getForm() {
            $this->book->title = ParamUtils::getFromRequest('title');

            return !App::getMessages()->isError();
        }
        
        public function getURL() {
            $this->book->id_book = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');

            return !App::getMessages()->isError();
        }
               
        public function action_bookList(){   
            # Get params
                $this -> getForm();
            
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
                $where = ["id_book" => $this->book->id_book];
                
                App::getSmarty()->assign('book_code', FunctionsDB::getRecords("get", "book_info", $join,"book_info.book_code",$where));
                App::getSmarty()->assign('title', FunctionsDB::getRecords("get", "book_info", $join,"book_info.title",$where)); 
                App::getSmarty()->assign('pages', FunctionsDB::getRecords("get", "book_info", $join,"book_info.pages",$where)); 
                App::getSmarty()->assign('name', FunctionsDB::getRecords("get", "book_info", $join,"author_info.name",$where)); 
                App::getSmarty()->assign('surname', FunctionsDB::getRecords("get", "book_info", $join,"author_info.surname",$where)); 
                App::getSmarty()->assign('genre', FunctionsDB::getRecords("get", "book_info", $join,"book_info.genre",$where)); 
                App::getSmarty()->assign('publisher', FunctionsDB::getRecords("get", "book_info", $join,"book_info.publisher",$where)); 
                
            # Get number of books
                #TODO     
                  
            # Redirect to page
                App::getSmarty()->assign('pageMode',"bookInfo"); 
                $this->generateView();
        }
        
        public function generateView() {
            App::getSmarty()->assign('user',unserialize($_SESSION['user'])); 
            App::getSmarty()->display('Book.tpl');
        }
    }
