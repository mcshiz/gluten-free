<?php
Config::write('db.host', 'localhost');
Config::write('db.port', '3306');
Config::write('db.basename', 'gluten');
Config::write('db.user', 'root');
Config::write('db.password', '');

class Config {
    static $confArray;

    public static function read($name) {
        return self::$confArray[$name];
    }
    public static function write($name, $value) {
        self::$confArray[$name] = $value;
    }

}


    class Core {
        public $dbh;
        private static $instance;

        private function __construct() {
            $dsn = 'mysql:host=' . Config::read('db.host') . ';dbname=' . Config::read('db.basename') . ';port=' . Config::read('db.port') .';connect_timeout=15;charset=utf8';

            $user = Config::read('db.user');
            $password = Config::read('db.password');
            $this->dbh = new PDO($dsn, $user, $password);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public static function getInstance() {
            if (!isset(self::$instance)) {
                $object = __CLASS__;
                self::$instance = new $object;
            }
            return self::$instance;
        }
    }