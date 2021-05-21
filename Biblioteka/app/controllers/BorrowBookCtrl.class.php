<?php
    namespace app\controllers;
    
    use core\App;
    use core\FunctionsDB;
    use core\Utils;
    use core\ParamUtils;
    use core\SessionUtils;
        
    use app\forms\BorrowedBooksForm;
    use app\forms\ReaderListForm;
    
    class BorrowBookCtrl {
        private $book;
        private $reader;
        
        public function __construct() { 
            $this->book = new BorrowedBooksForm(); 
            $this->reader = new ReaderListForm();
        }
        
        public function getForm($source) {
            if($source == "bookForm"){
                $this->book->id_book = ParamUtils::getFromRequest('id_book');
                $this->book->title = ParamUtils::getFromRequest('title');
            }
       
            if($source == "readerForm"){
                $this->reader->id_reader = ParamUtils::getFromRequest('id_reader');
                $this->reader->name = ParamUtils::getFromRequest('name');
                $this->reader->surname = ParamUtils::getFromRequest('surname');
            }
            
            return !App::getMessages()->isError();
        } 
              
        public function getURL() {
            $this->book->id_book = ParamUtils::getFromCleanURL(1, false); 
            $this->reader->id_reader = ParamUtils::getFromCleanURL(2, false);
            
            return !App::getMessages()->isError();
        }
        
        public function action_bookBorrow(){ 
            # Get params
                $this->getURL();
            
            # Set book and reader existance to default value
                $book_exist = false;
                $reader_exist = false;
            
            # Check if book and reader exists
                if(isset($this->book->id_book)){
                    try{
                        $book_exist = App::getDB()->has("book_stock", ["id_book" => $this->book->id_book]);
                    } catch (Exception $ex) {
                        Utils::addErrorMessage('Nie ma takiej książki w bazie');
                        if (App::getConf()->debug){ Utils::addErrorMessage($e->getMessage()); }
                    }
                }
                if(isset($this->reader->id_reader)){
                    try{
                        $reader_exist = App::getDB()->has("borrower_info", ["id_borrower" => $this->reader->id_reader]);
                    } catch (Exception $ex) {
                        Utils::addErrorMessage('Nie ma takiej książki w bazie');
                        if (App::getConf()->debug){ Utils::addErrorMessage($e->getMessage()); }
                    }
                }
                
            # Choose path to go
                if($book_exist && $reader_exist){
                    try{
                        # Insert info about borrowed book
                            App::getDB()->insert("borrowed_books", 
                                ["id_book" => $this->book->id_book,
                                 "id_borrower" => $this->reader->id_reader,
                                 "id_employee" => SessionUtils::load("id_employee", true),
                                 "borrow_date" => date("Y-m-d"),
                                 "return_date" => date("Y-m-d")
                                ]);

                        # Update status if book borrowed
                            App::getDB()->update("book_stock", 
                                ["borrowed" => 1 ], 
                                ["id_book" => $this->book->id_book]);
                    } catch (\PDOException $e) {
                        Utils::addErrorMessage('Wystąpił błąd podczas modyfikacji rekordów');
                        if (App::getConf()->debug){ Utils::addErrorMessage($e->getMessage()); }
                    }
                    
                    # Choose page view mode
                        App::getSmarty()->assign('pageMode',"bookBorrowed");
                } else if($book_exist){
                    # Get book info from DB
                        $join = ["[><]book_info" => ["book_stock.book_code" => "book_code"]];
                        $where = ["book_stock.id_book" =>  $this->book->id_book];
                        App::getSmarty()->assign('id_book', FunctionsDB::getRecords("get", "book_stock", $join, "book_stock.id_book", $where));
                        App::getSmarty()->assign('book_code', FunctionsDB::getRecords("get", "book_stock", $join, "book_stock.book_code", $where));
                        App::getSmarty()->assign('title', FunctionsDB::getRecords("get", "book_stock", $join, "book_stock.title", $where));
                    
                    # Get params
                        $this->getForm("readerForm");
                        
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
                        
                    # Get readers if searched and count them
                        if(isset($this->reader->id_reader) || isset($this->reader->name) || isset($this->reader->surname)){
                            $order = ["surname","name"];
                            $where = FunctionsDB::prepareWhere($filter_params, $order);

                            $column = ["id_borrower", "name", "surname"];
                            App::getSmarty()->assign('records', FunctionsDB::getRecords("select", "borrower_info", null, $column, $where));
                            
                            FunctionsDB::countRecords("borrower_info", $where);
                            
                            App::getSmarty()->assign('formSent', 1);
                        }
                        
                    # Choose page view mode
                        App::getSmarty()->assign('pageMode',"selectBorrower");
                } else{
                    # Get params
                        $this->getForm("bookForm");
                        
                    # Set filter params
                        $filter_params = [];
                        if (isset($this->book->id_book) && strlen($this->book->id_book) > 0) {
                            $filter_params['id_book[~]'] = $this->book->id_book.'%';
                        }
                        if (isset($this->book->title) && strlen($this->book->title) > 0) {
                            $filter_params['title[~]'] = $this->book->title.'%';
                        }
                        $filter_params['borrowed[~]'] = 0;
                        
                        App::getSmarty()->assign('searchForm', $this->book);
                        
                    # Get books if searched
                        if(isset($this->book->id_book) || isset($this->book->title)){
                            $order = ["title","id_book"];
                            $where = FunctionsDB::prepareWhere($filter_params, $order);

                            $column = ["id_book", "title"];
                            App::getSmarty()->assign('records', FunctionsDB::getRecords("select", "book_stock", null, $column, $where));
                            
                            FunctionsDB::countRecords("book_stock", $where);
                            
                            App::getSmarty()->assign('formSent', 1);
                        }
                        
                    # Choose page view mode
                        App::getSmarty()->assign('pageMode',"selectBook");
                }

            # Redirect to page
                $this->generateView();
        }
        
        public function generateView() {
            App::getSmarty()->assign('user', SessionUtils::loadObject("user", true));
            App::getSmarty()->display("BookBorrow.tpl");
        }
    }