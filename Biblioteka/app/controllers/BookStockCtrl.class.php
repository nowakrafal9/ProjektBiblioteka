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

    public function __construct() { $this->book = new BookStockForm(); }
    
    public function validate() {
        $this->book->book_code = ParamUtils::getFromRequest('book_code');
        $this->book->title = ParamUtils::getFromRequest('title');
        $this->book->borrowed = ParamUtils::getFromRequest('borrowed');
                      
        return !App::getMessages()->isError();
    }
        
    public function action_bookStock(){ 
        $this -> validate();
            
        $filter_params = [];
        if (isset($this->book->book_code) && strlen($this->book->book_code) > 0) {
            $filter_params['book_code[~]'] = $this->book->book_code.'%';
        }
        if (isset($this->book->title) && strlen($this->book->title) > 0) {
            $filter_params['title[~]'] = $this->book->title.'%';
        }
        if (isset($this->book->borrowed) && strlen($this->book->borrowed) > 0) {
            $filter_params['borrowed[~]'] = $this->book->borrowed.'%';
        }
        
        $num_params = sizeof($filter_params);
            if ($num_params > 1) {
                $where = ["AND" => &$filter_params];
            } else {
                $where = &$filter_params;
            }
        $where ["ORDER"] = ["book_code"];
          
        try {
            $this->records = App::getDB()->select("book_stock", ["book_code","title","borrowed"], $where);
        } catch (\PDOException $e) {
            Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
            if (App::getConf()->debug)
                Utils::addErrorMessage($e->getMessage());
        }
        
        App::getSmarty()->assign('searchForm', $this->book);
        App::getSmarty()->assign('records', $this->records);
            
        //App::getSmarty()->assign('user', SessionUtils::loadData('user'));
        App::getSmarty()->assign('user',unserialize($_SESSION['user'])); 
        App::getSmarty()->display('BookStock.tpl');
    }
}