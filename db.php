<?php  
/**
 * @Singleton to create database connection
 */
class db {

        /**
         * Holds an insance of self
         * @var $instance
         */
        private static $instance = NULL;

        /**
        * the constructor is set to private so
        * so nobody can create a new instance using new
        */
        private function __construct(){
        }

        /**
        * Return DB instance or create initial connection
        * @return object
        * @access public
        */
        public static function getInstance() {
                if (!self::$instance) {
                        $db_type = 'mysql';
                        $hostname = 'localhost';
                        $dbname = 'carspy';
                        $db_password = 'aiYai8U';
                        $db_username = 'root';
                        $db_port = 3306;
                                                
                        self::$instance = new PDO("$db_type:host=$hostname;port=$db_port;dbname=$dbname", $db_username, $db_password);
                        self::$instance-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        self::$instance->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
                }
                return self::$instance;
        }


        /**
        *
        * Like the constructor, we make __clone private
        * so nobody can clone the instance
        *
        */
        private function __clone() {
        }

} // end of class

?>

