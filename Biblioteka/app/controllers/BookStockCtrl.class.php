<?php
    namespace app\controllers;
    
    use core\App;
    use core\FunctionsDB;
    use core\Utils;
    use core\ParamUtils;
    
    use app\forms\BookStockForm;
    
class BookStockCtrl {
    private $book;

    public function __construct() { $this->book = new BookStockForm(); }
    
    public function getForm() {
        $this->book->book_code = ParamUtils::getFromRequest('book_code');
        $this->book->title = ParamUtils::getFromRequest('title');
        $this->book->borrowed = ParamUtils::getFromRequest('borrowed');
                      
        return !App::getMessages()->isError();
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
            $where = FunctionsDB::prepareWhere($filter_params, $order);          
        
        # Get books in library from DB
            $join =["[><]book_info" => ["book_code" => "book_code"]];
            $column = ["book_stock.id_book", "book_info.title", "book_stock.borrowed"];
            
            App::getSmarty()->assign('records', FunctionsDB::getRecords("select", "book_stock", $join, $column, $where));
                        
        # Get number of books in library
            FunctionsDB::countRecords("book_stock", $where); 
                  
        # Redirect to page
            $this->generateView();
    }
    
    public function generateView() {
        App::getSmarty()->assign('user',unserialize($_SESSION['user']));
        App::getSmarty()->display('BookStock.tpl');
    }
}