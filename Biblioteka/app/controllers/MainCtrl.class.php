<?php
    namespace app\controllers;
    
    use core\App;
    use core\SessionUtils;
    
    class MainCtrl {
         public function action_main() {
            # Redirect to page
               $this->generateView();
        }
        
        public function generateView() { 
            App::getSmarty()->assign('user', SessionUtils::loadObject("user", true));
            
            App::getSmarty()->display('Main.tpl');
        }
    }
