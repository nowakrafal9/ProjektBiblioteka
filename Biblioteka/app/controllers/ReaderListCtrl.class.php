<?php
    namespace app\controllers;
    
    use core\App;
    use core\Utils;
    use core\ParamUtils;
    use core\SessionUtils;
    
    use app\forms\ReaderListForm;
  
    class ReaderListCtrl {
        private $reader;
        private $records;
        private $numRecords;
        
        public function __construct() { $this->reader = new ReaderListForm(); }
        
        public function validateList() {
            // Get from HTML 
                $this->reader->id_reader = ParamUtils::getFromRequest('id_reader');
                $this->reader->name = ParamUtils::getFromRequest('name');
                $this->reader->surname = ParamUtils::getFromRequest('surname');

            return !App::getMessages()->isError();
        }   
        
        public function validateInfo() {
            // Get id from URL
                $this->reader->id_reader = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');

            return !App::getMessages()->isError();
        }   
        
        public function action_readerList(){
            // Get params
                $this->validateList();
            
            // Set filter params
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
            
            // Prepare $where for DB operation
                $num_params = sizeof($filter_params);
                if ($num_params > 1) {
                    $where = ["AND" => &$filter_params];
                } else {
                    $where = &$filter_params;
                }
                $where ["ORDER"] = ["surname","name"];
            
            // Get readers list
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
                
            // Get number of readers registered
                $this->numRecords = 0;
                if(!is_null($this->records)){
                    foreach($this->records as $r){
                        $this->numRecords++;      
                    }
                }
                App::getSmarty()->assign('numRecords', $this->numRecords);
                
            // Send filter params to Smarty
                App::getSmarty()->assign('searchForm', $this->reader);
                 
            // Get logged user name
                App::getSmarty()->assign('user',unserialize($_SESSION['user'])); 
            
            // Redirect to page
                App::getSmarty()->display('ReaderList.tpl');
        }
        
        public function action_readerInfo(){
            // Get params
                $this->validateInfo();
            
            // Get reader personal info
                try {
                    $this->records = App::getDB()->select("borrower_info", 
                            ["id_borrower", 
                             "name", 
                             "surname", 
                             "city", 
                             "postal_code", 
                             "address", 
                             "phone_number",
                             "email"],
                            ["id_borrower" => $this->reader->id_reader]);
                } catch (\PDOException $e) {
                    Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                    if (App::getConf()->debug)
                        Utils::addErrorMessage($e->getMessage());
                }    
                App::getSmarty()->assign('records1', $this->records);
            
            // Get borrowed books by reader
                try {
                    $this->records = App::getDB()->select("borrowed_books", 
                        ["[><]book_stock" => ["id_book" => "id_book"]], 
                        ["borrowed_books.id_book", 
                         "borrowed_books.id_borrower", 
                         "borrowed_books.return_date", 
                         "book_stock.title"], 
                        ["id_borrower" => $this->reader->id_reader]);
                } catch (\PDOException $e) {
                    Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                    if (App::getConf()->debug)
                        Utils::addErrorMessage($e->getMessage());
                }    
                App::getSmarty()->assign('records2', $this->records);   
            
            // Get number of books borrowed by reader
                $this->numRecords = 0;
                if(!is_null($this->records)){
                    foreach($this->records as $r){
                        $this->numRecords++;      
                    }
                }
                App::getSmarty()->assign('numRecords', $this->numRecords);
            
            // Get today date
                App::getSmarty()->assign('dateToday', date("Y-m-d"));
            
            // Get logged user name
                App::getSmarty()->assign('user',unserialize($_SESSION['user'])); 
            
            // Redirect to page
                App::getSmarty()->display('ReaderInfo.tpl');
        }
    }