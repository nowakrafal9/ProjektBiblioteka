<?php
    namespace app\controllers;
    
    use core\App;
    use core\Utils;
    use core\ParamUtils;
    use app\forms\ReaderListForm;
  
    class ReaderListCtrl {
        private $reader;
        private $records_1;
        private $records_2;
        private $num_records = 0;
        
        public function __construct() { $this->reader = new ReaderListForm(); }
        
        public function validate() {
            $this->reader->id = ParamUtils::getFromRequest('person_id');
            $this->reader->name = ParamUtils::getFromRequest('name');
            $this->reader->surname = ParamUtils::getFromRequest('surname');

            return !App::getMessages()->isError();
        }   
        
        public function action_readerList(){
            $this->validate();
            
            $filter_params = [];
            if (isset($this->reader->id) && strlen($this->reader->id) > 0) {
                $filter_params['id_borrower[~]'] = $this->reader->id.'%';
            }
            if (isset($this->reader->name) && strlen($this->reader->name) > 0) {
                $filter_params['name[~]'] = $this->reader->name.'%';
            }
            if (isset($this->reader->surname) && strlen($this->reader->surname) > 0) {
                $filter_params['surname[~]'] = $this->reader->surname.'%';
            }
            
            $num_params = sizeof($filter_params);
            if ($num_params > 1) {
                $where = ["AND" => &$filter_params];
            } else {
                $where = &$filter_params;
            }
            $where ["ORDER"] = ["surname","name"];
            
            try {
            $this->records = App::getDB()->select("borrower_info", [ "id_borrower", "name", "surname"], $where);
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
            
            //App::getSmarty()->assign('user', SessionUtils::loadData('user'));
            App::getSmarty()->assign('user',unserialize($_SESSION['user']));
            
            App::getSmarty()->assign('searchForm', $this->reader);
            App::getSmarty()->assign('records', $this->records);
           
            App::getSmarty()->display('ReaderList.tpl');
        }
        
        public function action_readerInfo(){
            $this->reader->id = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');
            
            $where['id_borrower'] = $this->reader->id; 
            try {
                $this->records_1 = App::getDB()->select("borrower_info", ["id_borrower", "name", "surname", "city" ,"address", "phone_number", "email"], $where);
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }    
            
            try {
                $this->records_2 = App::getDB()->select("borrowed_books", ["[><]book_stock" => ["book_code" => "book_code"]], ["borrowed_books.book_code", "borrowed_books.id_borrower", "borrowed_books.return_date", "book_stock.title"], $where);
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }    
            
            foreach($this->records_2 as $r){
                $this->num_records++;      
            }
            
            App::getSmarty()->assign('records_1', $this->records_1); 
            App::getSmarty()->assign('records_2', $this->records_2);
            App::getSmarty()->assign('numRecords', $this->num_records);
            App::getSmarty()->assign('dateToday', date("Y-m-d"));
            
            //App::getSmarty()->assign('user', SessionUtils::loadData('user'));
            App::getSmarty()->assign('user',unserialize($_SESSION['user'])); 
            App::getSmarty()->display('ReaderInfo.tpl');
        }
    }
