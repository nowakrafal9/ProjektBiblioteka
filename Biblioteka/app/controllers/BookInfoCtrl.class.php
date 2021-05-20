<?php
    namespace app\controllers;

    use core\App;
    use core\Utils;
    use core\ParamUtils;
    use core\SessionUtils;
    
    use app\forms\BookInfoForm;
    
    class BookInfoCtrl {
        private $book;
        private $records;
        private $numRecords;
        
        public function __construct() { $this->book = new BookInfoForm(); }
        
        public function validateHTML() {
            // Get from HTML 
                $this->book->title = ParamUtils::getFromRequest('title');

            return !App::getMessages()->isError();
        }
        
        public function validateURL() {
            // Get from URL 
                $this->book->id_book = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');

            return !App::getMessages()->isError();
        }
        
        public function action_bookList(){   
            // Get params
                $this -> validateHTML();
            
            // Set filter params
                $filter_params = [];
                if (isset($this->book->title) && strlen($this->book->title) > 0) {
                    $filter_params['title[~]'] = $this->book->title.'%';
                }
            
            // Prepare $where for DB operation
                $num_params = sizeof($filter_params);
                if ($num_params > 1) {
                    $where = ["AND" => &$filter_params];
                } else {
                    $where = &$filter_params;
                }
                $where ["ORDER"] = ["title"];
            
            // Get book titles list
                try {
                    $this->records = App::getDB()->select("book_info", 
                        ["id_book",
                         "title"], 
                         $where);
                } catch (\PDOException $e) {
                    Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                    if (App::getConf()->debug)
                        Utils::addErrorMessage($e->getMessage());
                }
                App::getSmarty()->assign('records', $this->records);
                
            // Get number of titles in library
                try {
                    $this->numRecords = App::getDB()->count("book_stock", $where);
                } catch (\PDOException $e) {
                    Utils::addErrorMessage('Wystąpił błąd podczas liczenia rekordów');
                    if (App::getConf()->debug)
                        Utils::addErrorMessage($e->getMessage());
                }
                App::getSmarty()->assign('numRecords', $this->numRecords);
                
            // Send filter params to Smarty
                App::getSmarty()->assign('searchForm', $this->book);   
            
            // Get logged user name
                App::getSmarty()->assign('user',unserialize($_SESSION['user'])); 
            
            // Redirect to page
                App::getSmarty()->assign('pageMode',"bookList");
                App::getSmarty()->display('Book.tpl');
        }
        
        public function bookInfoRecords($param) {
            try {
                $this->records = App::getDB()->get("book_info", 
                    ["[><]author_info" => ["author" => "id_author"]], 
                     $param, 
                    ["id_book" => $this->book->id_book]);
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }        
       
            return $this->records;
        }
        
        public function action_bookInfo(){
            // Get params
                $this -> validateURL();      
            
            // Get book info                 
                App::getSmarty()->assign('book_code', $this->bookInfoRecords("book_info.book_code"));
                App::getSmarty()->assign('title', $this->bookInfoRecords("book_info.title")); 
                App::getSmarty()->assign('pages', $this->bookInfoRecords("book_info.pages")); 
                App::getSmarty()->assign('name', $this->bookInfoRecords("author_info.name")); 
                App::getSmarty()->assign('surname', $this->bookInfoRecords("author_info.surname")); 
                App::getSmarty()->assign('genre', $this->bookInfoRecords("book_info.genre")); 
                App::getSmarty()->assign('publisher', $this->bookInfoRecords("book_info.publisher")); 
            
            // Get number of books
                try {
                    $this->records[0] = App::getDB()->count("book_stock", ["book_code" => $this->bookInfoRecords("book_info.book_code")]);
                    $this->records[1] = App::getDB()->count("book_stock", ["book_code" => $this->bookInfoRecords("book_info.book_code"), "borrowed" => 0]);
                    $this->records[2] = App::getDB()->count("book_stock", ["book_code" => $this->bookInfoRecords("book_info.book_code"), "borrowed" => 1]);
                    
                } catch (\PDOException $e) {
                    Utils::addErrorMessage('Wystąpił błąd podczas liczenia rekordów');
                    if (App::getConf()->debug)
                        Utils::addErrorMessage($e->getMessage());
                }      
                App::getSmarty()->assign('allCount', $this->records[0]); 
                App::getSmarty()->assign('inLibraryCount', $this->records[1]);
                App::getSmarty()->assign('borrowedCount', $this->records[2]);       
                
            // Get logged user name
                App::getSmarty()->assign('user',unserialize($_SESSION['user'])); 
            
            // Redirect to page
                App::getSmarty()->assign('pageMode',"bookInfo");
                App::getSmarty()->display('Book.tpl');
        }
    }
