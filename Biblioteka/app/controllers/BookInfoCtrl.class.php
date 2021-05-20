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
        
        public function getFormParam() {
            $this->book->title = ParamUtils::getFromRequest('title');

            return !App::getMessages()->isError();
        }
        
        public function getFromURL() {
            $this->book->id_book = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');

            return !App::getMessages()->isError();
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
         
        public function getRecords($table, $join, $column, $where) {
            try {
                $this->records = App::getDB()->get($table,$join,$column,$where);
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                if (App::getConf()->debug) { Utils::addErrorMessage($e->getMessage()); }
            }        
            
            return $this->records;
        }
             
        public function action_bookList(){   
            # Get params
                $this -> getFormParam();
            
            # Set filter params
                $filter_params = [];
                if (isset($this->book->title) && strlen($this->book->title) > 0) {
                    $filter_params['title[~]'] = $this->book->title.'%';
                }
                App::getSmarty()->assign('searchForm', $this->book);
                
            # Prepare $where for DB operation
                $order = ["title"];
                $where = $this->prepareWhere($filter_params, $order);
            
            # Get book titles list from DB
                try {
                    $this->records = App::getDB()->select("book_info", 
                        ["id_book", "title"], 
                         $where);
                } catch (\PDOException $e) {
                    Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                    if (App::getConf()->debug)
                        Utils::addErrorMessage($e->getMessage());
                }
                App::getSmarty()->assign('records', $this->records);
                
            # Get number of titles in library
                $this -> countRecords("book_stock", $where);  
                       
           # Redirect to page
                App::getSmarty()->assign('pageMode',"bookList");
                $this->generateView();
        }
        
        public function action_bookInfo(){
            # Get params
                $this -> getFromURL();      
            
            # Get book info    
                $join = ["[><]author_info" => ["author" => "id_author"]];
                $where = ["id_book" => $this->book->id_book];
                
                App::getSmarty()->assign('book_code', $this->getRecords("book_info", $join,"book_info.book_code",$where));
                App::getSmarty()->assign('title', $this->getRecords("book_info", $join,"book_info.title",$where)); 
                App::getSmarty()->assign('pages', $this->getRecords("book_info", $join,"book_info.pages",$where)); 
                App::getSmarty()->assign('name', $this->getRecords("book_info", $join,"author_info.name",$where)); 
                App::getSmarty()->assign('surname', $this->getRecords("book_info", $join,"author_info.surname",$where)); 
                App::getSmarty()->assign('genre', $this->getRecords("book_info", $join,"book_info.genre",$where)); 
                App::getSmarty()->assign('publisher', $this->getRecords("book_info", $join,"book_info.publisher",$where)); 
                
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
