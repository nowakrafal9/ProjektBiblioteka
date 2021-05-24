<?php
    namespace app\controllers;

    use core\App;
    use core\Utils;
    use core\ParamUtils;
    use core\SessionUtils;
    
    use app\forms\ReaderEditForm;
    
    class ReaderEditCtrl {
        private $reader;
        private $pageMode;
        
        public function __construct() { $this->reader = new ReaderEditForm(); }
        
        public function getFromURL(){
            $this->reader->id_borrower = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');
            
            return !App::getMessages()->isError();
        }
        
        public function validateSave() {         
            $this->reader->id_borrower = ParamUtils::getFromRequest('id_borrower', true, 'Błędne wywołanie aplikacji');
            $this->reader->name = ParamUtils::getFromRequest('name', true, 'Błędne wywołanie aplikacji');
            $this->reader->surname = ParamUtils::getFromRequest('surname', true, 'Błędne wywołanie aplikacji');
            $this->reader->city = ParamUtils::getFromRequest('city', true, 'Błędne wywołanie aplikacji');
            $this->reader->address = ParamUtils::getFromRequest('address', true, 'Błędne wywołanie aplikacji');
            $this->reader->postalCode = ParamUtils::getFromRequest('postalCode', true, 'Błędne wywołanie aplikacji');
            $this->reader->phoneNumber = ParamUtils::getFromRequest('phoneNumber', true, 'Błędne wywołanie aplikacji');
            $this->reader->email = ParamUtils::getFromRequest('email', true, 'Błędne wywołanie aplikacji');
            
            if (App::getMessages()->isError()){ return false; }
            
            if (empty(trim($this->reader->name))) { Utils::addErrorMessage('Wprowadź imie'); }
            if (empty(trim($this->reader->surname))) { Utils::addErrorMessage('Wprowadź nazwisko'); }
            if (empty(trim($this->reader->city))) { Utils::addErrorMessage('Wprowadź miasto'); }
            if (empty(trim($this->reader->address))) { Utils::addErrorMessage('Wprowadź adres zamieszkania'); }
            if (empty(trim($this->reader->postalCode))) { Utils::addErrorMessage('Wprowadź kod pocztowy'); }
            if (empty(trim($this->reader->phoneNumber))) { Utils::addErrorMessage('Wprowadź nr telefonu'); }
            
            if (App::getMessages()->isError()){ return false; }
            
            if(!preg_match('/^[a-zA-ząćęłńóśźżĄĘŁŃÓŚŹŻ\x20]{3,50}$/', $this->reader->name)){ Utils::addErrorMessage("Podano niepoprawne imię"); }
            if(!preg_match('/^[a-zA-ząćęłńóśźżĄĘŁŃÓŚŹŻ\x20]{3,50}$/', $this->reader->surname)){ Utils::addErrorMessage("Podano niepoprawne nazwisko"); }
            if(!preg_match('/^[a-zA-ząćęłńóśźżĄĘŁŃÓŚŹŻ\x20]{3,50}$/', $this->reader->city)){ Utils::addErrorMessage("Podano niepoprawną nazwe miasta"); }
            if(!preg_match('/^[a-zA-ząćęłńóśźżĄĘŁŃÓŚŹŻ0-9\x20]{3,100}$/', $this->reader->address)){ Utils::addErrorMessage("Podano niepoprawny adres"); }
            if(!preg_match('/^\d{2}-\d{3}$/', $this->reader->postalCode)){ Utils::addErrorMessage("Podano niepoprawny kod pocztowy"); }
            if(!preg_match('/^\d{9,11}$/', $this->reader->phoneNumber)){ Utils::addErrorMessage("Podano niepoprawny nr telefonu"); }
//            if(!empty(trim($this->reader->email))){ 
//                if(!preg_match('/^\w{1,50}$/', $this->reader->email) || 
//                   !filter_var($this->reader->email, FILTER_VALIDATE_EMAIL)){ 
//                    Utils::addErrorMessage("Podano niepoprawny email");    
//                }     
//            }
            
            if (App::getMessages()->isError()){ return false; }
             
            return !App::getMessages()->isError();
        }
        
        public function action_readerAdd(){
            $this->pageMode = "readerAdd";
            $this->generateView();
        }
        
        public function action_readerEdit() {
            if ($this->getFromURL()) {
                try {
                   $r = APP::getDB()-> get("borrower_info",'*',["id_borrower" =>$this->reader->id_borrower]);
                   
                   $this->reader->id_borrower = $r["id_borrower"];
                   $this->reader->name = $r["name"];
                   $this->reader->surname = $r["surname"];
                   $this->reader->city = $r["city"];
                   $this->reader->address = $r["address"];
                   $this->reader->postalCode = $r["postal_code"];
                   $this->reader->phoneNumber = $r["phone_number"];
                   $this->reader->email = $r["email"];
                    
                } catch (Exception $e) {
                    Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                    if (App::getConf()->debug){ Utils::addErrorMessage($e->getMessage()); }
                } 
            }
            $this->pageMode = "readerEdit";
            $this->generateView();
        }
        
        public function action_readerSave() {
            if ($this->validateSave()){
                if(empty(trim($this->reader->email))){ $this->reader->email = null; }
                try {
                    if ($this->reader->id_borrower == '') {
                        App::getDB()->insert("borrower_info", [
                            "name" => $this->reader->name,
                            "surname" => $this->reader->surname,
                            "city" => $this->reader->city,
                            "address" => $this->reader->address,
                            "postal_code" => $this->reader->postalCode,
                            "phone_number" => $this->reader->phoneNumber,
                            "email" => $this->reader->email
                        ]);
                    }else{
                        App::getDB()->update("borrower_info", [
                            "name" => $this->reader->name,
                            "surname" => $this->reader->surname,
                            "city" => $this->reader->city,
                            "address" => $this->reader->address,
                            "postal_code" => $this->reader->postalCode,
                            "phone_number" => $this->reader->phoneNumber,
                            "email" => $this->reader->email
                        ], ["id_borrower" => $this->reader->id_borrower]);
                    }
                } catch (Exception $e) {
                    Utils::addErrorMessage('Wystąpił problem podczas modyfikacji rekordów');
                    if (App::getConf()->debug){ Utils::addErrorMessage($e->getMessage()); }
                }
                App::getRouter()->redirectTo('readerList');
            }
            else{
                $this->generateView();              
            }    
        }
        
        public function generateView() {
            App::getSmarty()->assign('pageMode', $this->pageMode);
            App::getSmarty()->assign('form', $this->reader);
            App::getSmarty()->assign('user', SessionUtils::loadObject("user", true));
            App::getSmarty()->display('Reader_edit.tpl');
        }
        
    }