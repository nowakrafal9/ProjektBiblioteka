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
        
        public function __construct() { $this->book = new BookInfoForm(); }
        
        public function validate() {
            $this->book->title = ParamUtils::getFromRequest('title');
                      
            return !App::getMessages()->isError();
        }
     
        public function action_bookInfo(){       
            $this -> validate();
            
            $filter_params = [];
            if (isset($this->book->title) && strlen($this->book->title) > 0) {
                $filter_params['title[~]'] = $this->book->title.'%';
            }
            
            $num_params = sizeof($filter_params);
            if ($num_params > 1) {
                $where = ["AND" => &$filter_params];
            } else {
                $where = &$filter_params;
            }
            $where ["ORDER"] = ["title"];
            
            try {
            $this->records = App::getDB()->select("book_info", ["id_book","title"], $where);
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
            
            //App::getSmarty()->assign('user', SessionUtils::loadData('user'));
            App::getSmarty()->assign('user',unserialize($_SESSION['user']));
            
            App::getSmarty()->assign('searchForm', $this->book);
            App::getSmarty()->assign('records', $this->records);
            
            App::getSmarty()->display('BookInfo.tpl');
        }
        
        public function action_bookInfoDetails(){
            // Do zmodyfikowania dać JOIN)      
            $this->book->id_book = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');
            
            $where['id_book'] = $this->book->id_book; 
            try {
                $this->records = App::getDB()->select("book_info", ["[><]author_info" => ["author" => "id_author"]],["book_info.title", "book_info.pages", "author_info.name", "author_info.surname", "book_info.genre", "book_info.publisher"], $where);
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }    
            
            App::getSmarty()->assign('records', $this->records); 
            
            //App::getSmarty()->assign('user', SessionUtils::loadData('user'));
            App::getSmarty()->assign('user',unserialize($_SESSION['user'])); 
            App::getSmarty()->display('BookInfoDetails.tpl');
        }
    }
