<?php
    namespace core;

    class FunctionsDB {
        public static function getRecords($mode, $table, $join, $column, $where) {
            try {
                if($mode == "get" && !is_null($join)){ $records = App::getDB()->get($table,$join,$column,$where); }
                else if($mode == "get" && is_null($join)){ $records = App::getDB()->get($table,$column,$where); }
                else if($mode == "select" && !is_null($join)){ $records = App::getDB()->select($table,$join,$column,$where); }
                else if($mode == "select" && is_null($join)){ $records = App::getDB()->select($table,$column,$where); }
                else{ Utils::addErrorMessage('Niepoprawny tryb pobrania rekordów'); }
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
                if (App::getConf()->debug) { Utils::addErrorMessage($e->getMessage()); }
            }        
            
            return $records;
        }
        
        public static function countRecords($table, $where){
            try {
                $numRecords = App::getDB()->count($table, $where);
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas liczenia rekordów');
                if (App::getConf()->debug){ Utils::addErrorMessage($e->getMessage()); }
            }
                        
            return $numRecords;
        }
        
        public static function prepareWhere($filter_params, $order) {
            $num_params = sizeof($filter_params);
                
            if ($num_params > 1) {
                $where = ["AND" => &$filter_params];
            } else {
                $where = &$filter_params;
            }
            $where ["ORDER"] = $order;
            
            return $where;
        }
        
        public static function getPage($recordsNum, $recordsPerPage) {
            $page = ParamUtils::getFromCleanURL(1);
            
            $lastPage = self::getLastPage($recordsNum, $recordsPerPage);
            
            if(!isset($page) || $page < 1){ 
                $page = 1;      
            }
            if($page > $lastPage-1){ 
                $page = $lastPage-1; 
            }

            App::getSmarty()->assign("page", $page);
            return $page;
        } 
        
        public static function getLastPage($recordsNum, $recordsPerPage) {
            $lastPage = 1;
            
            while($recordsNum > 0){
                $recordsNum = $recordsNum - $recordsPerPage;
                $lastPage++;
            }
            
            App::getSmarty()->assign("lastPage", $lastPage);
            return $lastPage;
        }
    }
