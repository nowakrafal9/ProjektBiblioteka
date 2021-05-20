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
            App::getSmarty()->assign('user',unserialize($_SESSION['user'])); 
            App::getSmarty()->display('Main.tpl');
        }
    }
