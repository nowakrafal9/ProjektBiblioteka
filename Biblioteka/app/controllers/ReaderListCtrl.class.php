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
        
        public function getForm() {
            $this->reader->id_reader = ParamUtils::getFromRequest('id_reader');
            $this->reader->name = ParamUtils::getFromRequest('name');
            $this->reader->surname = ParamUtils::getFromRequest('surname');

            return !App::getMessages()->isError();
        }   
        
        public function getUrl() {
            $this->reader->id_reader = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');

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
        
        public function getRecords($mode, $table, $join, $column, $where) {
            try {
                if($mode == "readerInfo"){ $this->records = App::getDB()->get($table,$column,$where); }
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                if (App::getConf()->debug) { Utils::addErrorMessage($e->getMessage()); }
            }        
            
            return $this->records;
        }
        
        public function action_readerList(){
            # Get params
                $this->getForm();
            
            # Set filter params
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
                App::getSmarty()->assign('searchForm', $this->reader);
                
            # Prepare $where for DB operation
                $order = ["surname","name"];
                $where = $this->prepareWhere($filter_params, $order);
            
            # Get readers list from DB
                try {
                    $this->records = App::getDB()->select("borrower_info",
                        ["id_borrower", "name", "surname"],
                        $where);
                } catch (\PDOException $e) {
                    Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                    if (App::getConf()->debug){ Utils::addErrorMessage($e->getMessage());}
                }
                App::getSmarty()->assign('records', $this->records);
                
            # Get number of readers registered
                $this->countRecords("borrower_info", $where); 
                
            # Redirect to page
                App::getSmarty()->assign('pageMode',"readerList"); 
                $this->generateView();
        }
        
        public function action_readerInfo(){
            # Get params
                $this->getUrl();
            
            # Get reader personal info
                $where = ["id_borrower" => $this->reader->id_reader];
                
                App::getSmarty()->assign('name', $this->getRecords("readerInfo", "borrower_info", null, "name", $where));
                App::getSmarty()->assign('surname', $this->getRecords("readerInfo", "borrower_info", null, "surname", $where));
                App::getSmarty()->assign('city', $this->getRecords("readerInfo", "borrower_info", null, "city", $where));
                App::getSmarty()->assign('address', $this->getRecords("readerInfo", "borrower_info", null, "address", $where));
                App::getSmarty()->assign('postal_code', $this->getRecords("readerInfo", "borrower_info", null, "postal_code", $where));
                App::getSmarty()->assign('phone_number', $this->getRecords("readerInfo", "borrower_info", null, "phone_number", $where));
                App::getSmarty()->assign('email', $this->getRecords("readerInfo", "borrower_info", null, "email", $where));
                    
            # Get borrowed books by reader
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
                    if (App::getConf()->debug){ Utils::addErrorMessage($e->getMessage()); }
                }    
                App::getSmarty()->assign('records', $this->records);   
            
            # Get number of books borrowed by reader
                $where["id_borrower~"] = $this->reader->id_reader;
                $this->countRecords("borrowed_books", $where); 
            
            # Redirect to page
                App::getSmarty()->assign('dateToday', date("Y-m-d"));
                App::getSmarty()->assign('pageMode',"readerInfo"); 
                
                $this->generateView();
        }
        
        public function generateView(){
            App::getSmarty()->assign('user',unserialize($_SESSION['user'])); 
            App::getSmarty()->display('Reader.tpl');
        }
    }