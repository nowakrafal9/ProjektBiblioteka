<?php
    namespace app\controllers;
    
    use core\App;
    use core\SessionUtils;
    
    class MainCtrl {
         public function action_main() {
            // Get logged user name
                App::getSmarty()->assign('user',unserialize($_SESSION['user'])); 
            
            // Redirect to page
                App::getSmarty()->display('Main.tpl');
        }
    }
