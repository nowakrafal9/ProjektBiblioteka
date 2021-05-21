<?php
    namespace app\controllers;
    
    use core\App;
    use core\FunctionsDB;
    use core\Utils;
    use core\ParamUtils;
    
    use app\forms\ReaderListForm;
  
    class ReaderListCtrl {
        private $reader;
        
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
                $where = FunctionsDB::prepareWhere($filter_params, $order);
            
            # Get readers list from DB
                $column = ["id_borrower", "name", "surname"];
                App::getSmarty()->assign('records', FunctionsDB::getRecords("select", "borrower_info", null, $column, $where));
                       
            # Get number of readers registered
                FunctionsDB::countRecords("borrower_info", $where); 
                
            # Redirect to page
                App::getSmarty()->assign('pageMode',"readerList"); 
                $this->generateView();
        }
        
        public function action_readerInfo(){
            # Get params
                $this->getUrl();
            
            # Get reader personal info
                $where = ["id_borrower" => $this->reader->id_reader];
                
                App::getSmarty()->assign('name', FunctionsDB::getRecords("get", "borrower_info", null, "name", $where));
                App::getSmarty()->assign('surname', FunctionsDB::getRecords("get", "borrower_info", null, "surname", $where));
                App::getSmarty()->assign('city', FunctionsDB::getRecords("get", "borrower_info", null, "city", $where));
                App::getSmarty()->assign('address', FunctionsDB::getRecords("get", "borrower_info", null, "address", $where));
                App::getSmarty()->assign('postal_code', FunctionsDB::getRecords("get", "borrower_info", null, "postal_code", $where));
                App::getSmarty()->assign('phone_number', FunctionsDB::getRecords("get", "borrower_info", null, "phone_number", $where));
                App::getSmarty()->assign('email', FunctionsDB::getRecords("get", "borrower_info", null, "email", $where));
                    
            # Get borrowed books by reader
                $join =["[><]book_stock" => ["id_book" => "id_book"]];
                $column = ["borrowed_books.id_book", "borrowed_books.id_borrower", "borrowed_books.return_date", "book_stock.title"];
                App::getSmarty()->assign('records', FunctionsDB::getRecords("select", "borrowed_books", $join, $column, $where));
                       
            # Get number of books borrowed by reader
                $where["id_borrower~"] = $this->reader->id_reader;
                FunctionsDB::countRecords("borrowed_books", $where); 
            
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