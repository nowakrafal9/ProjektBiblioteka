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
                $this->numRecords = 0;
                if(!is_null($this->records)){
                    foreach($this->records as $r){
                        $this->numRecords++;      
                    }
                }
                App::getSmarty()->assign('numRecords', $this->numRecords);
                
            // Send filter params to Smarty
                App::getSmarty()->assign('searchForm', $this->book);   
            
            // Get logged user name
                App::getSmarty()->assign('user',unserialize($_SESSION['user'])); 
            
            // Redirect to page
                App::getSmarty()->display('BookList.tpl');
        }
        
        public function action_bookInfo(){
            // Get params
                $this -> validateURL();      
            
            // Get book info
                try {
                    $this->records = App::getDB()->select("book_info", 
                        ["[><]author_info" => ["author" => "id_author"]],
                        ["book_info.title", 
                         "book_info.pages", 
                         "author_info.name", 
                         "author_info.surname", 
                         "book_info.genre", 
                         "book_info.publisher"], 
                        ["id_book" => $this->book->id_book]);
                } catch (\PDOException $e) {
                    Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                    if (App::getConf()->debug)
                        Utils::addErrorMessage($e->getMessage());
                }            
                App::getSmarty()->assign('records', $this->records); 
              
             // Get logged user name
                App::getSmarty()->assign('user',unserialize($_SESSION['user'])); 
            
            // Redirect to page
                App::getSmarty()->display('BookInfo.tpl');
        }
    }
