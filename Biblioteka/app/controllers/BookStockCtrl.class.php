<?php
    namespace app\controllers;
    
    use core\App;
    use core\Utils;
    use core\ParamUtils;
    use core\SessionUtils;
    use app\forms\BookStockForm;
    
class BookStockCtrl {
    private $book;
    private $records;
    private $numRecords;

    public function __construct() { $this->book = new BookStockForm(); }
    
    public function getForm() {
        $this->book->book_code = ParamUtils::getFromRequest('book_code');
        $this->book->title = ParamUtils::getFromRequest('title');
        $this->book->borrowed = ParamUtils::getFromRequest('borrowed');
                      
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
        
    public function action_bookStock(){ 
        # Get params
            $this -> getForm();
            
        # Set filter params    
            $filter_params = [];
            if (isset($this->book->book_code) && strlen($this->book->book_code) > 0) {
                $filter_params['id_book[~]'] = $this->book->book_code.'%';
            }
            if (isset($this->book->title) && strlen($this->book->title) > 0) {
                $filter_params['title[~]'] = $this->book->title.'%';
            }
            if (isset($this->book->borrowed) && strlen($this->book->borrowed) > 0) {
                $filter_params['borrowed[~]'] = $this->book->borrowed.'%';
            }
            App::getSmarty()->assign('searchForm', $this->book);
            
        # Prepare $where for DB operation
            $order = ["id_book"];
            $where = $this->prepareWhere($filter_params, $order);          
        
        # Get books in library from DB
            try {
                $this->records = App::getDB()->select("book_stock",["[><]book_info" => ["book_code" => "book_code"]], 
                    ["book_stock.id_book", "book_info.title", "book_stock.borrowed"], $where);
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
            App::getSmarty()->assign('records', $this->records);
            
        # Get number of books in library
            $this->countRecords("book_stock", $where); 
                  
        # Redirect to page
            $this->generateView();
    }
    
    public function generateView() {
        App::getSmarty()->assign('user',unserialize($_SESSION['user']));
        App::getSmarty()->display('BookStock.tpl');
    }
}