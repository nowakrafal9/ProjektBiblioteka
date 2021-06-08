<?php
    namespace app\controllers;
    
    use core\App;
    use core\FunctionsDB;
    use core\Utils;
    use core\ParamUtils;
    use core\SessionUtils;
        
    use app\forms\ReaderListForm;
  
    class ReaderCtrl {
        private $reader;
        
        private $page;
        private $recordsPerPage = 10;
        
        public function __construct() { $this->reader = new ReaderListForm(); }
        
        public function getForm() {
            $this->reader->id_reader = ParamUtils::getFromRequest('id_reader');
            $this->reader->name = ParamUtils::getFromRequest('name');
            $this->reader->surname = ParamUtils::getFromRequest('surname');
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
                
            # Get number of found readers 
            $numRecords = FunctionsDB::countRecords("borrower_info", $where); 
            App::getSmarty()->assign("numRecords", $numRecords);
            
            if($numRecords > 0){
                # Get page
                $this->page = FunctionsDB::getPage($numRecords, $this->recordsPerPage);

                # Get offset of readers
                $offset = $this->recordsPerPage*($this->page-1);
                $where["LIMIT"] = [$offset, $this->recordsPerPage];

                # Get readers list from DB
                $column = ["id_borrower", "name", "surname"];
                App::getSmarty()->assign('records', FunctionsDB::getRecords("select", "borrower_info", null, $column, $where));
            }    
            
            # Redirect to page
            $this->generateView("Reader_readerList.tpl");
        }
        
        public function action_readerInfo(){
            if($this->getUrl()){    
                # Check if reader exists
                if(!App::getDB()->has("borrower_info", ["id_borrower" => $this->reader->id_reader])){
                    App::getRouter()->redirectTo("readerList");
                }
                
                # Get reader personal info
                $where = ["id_borrower" => $this->reader->id_reader];
                App::getSmarty()->assign('r', FunctionsDB::getRecords("get", "borrower_info", null, "*", $where));

                # Get borrowed books by reader
                $join =["[><]book_stock" => ["id_book" => "id_book"]];
                $column = ["borrowed_books.id_book", "borrowed_books.id_borrower", "borrowed_books.return_date", "book_stock.title"];
                App::getSmarty()->assign('records', FunctionsDB::getRecords("select", "borrowed_books", $join, $column, $where));

                # Get number of books borrowed by reader
                $where["id_borrower~"] = $this->reader->id_reader;
                App::getSmarty()->assign('numRecords', FunctionsDB::countRecords("borrowed_books", $where)); 

                # Redirect to page
                App::getSmarty()->assign('dateToday', date("Y-m-d")); 
                $this->generateView("Reader_readerInfo.tpl");
            }else{
                App::getRouter()->redirectTo("readerList");
            }
        }
        
        public function generateView($page){
            App::getSmarty()->assign('user', SessionUtils::loadObject("user", true));
            
            App::getSmarty()->display($page);
        }
    }