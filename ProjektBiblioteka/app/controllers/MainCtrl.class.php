<?php
    namespace app\controllers;
    
    use core\App;
    use core\Message;
    use core\Utils;
    use core\SessionUtils;
    
    class MainCtrl {
         public function action_main() {
            //App::getSmarty()->assign('user', SessionUtils::loadData('user'));
            App::getSmarty()->assign('user',unserialize($_SESSION['user']));

            App::getSmarty()->display("Main.tpl");      
        }
    }
