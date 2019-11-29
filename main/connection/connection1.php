<?php
	define('DB_HOST1', 'localhost');
	define('DB_NAME1', 'sor_gov_hr_online_copy');
	define('DB_USER1', 'root');
	define('DB_PASS1', '');
	define('DB_CHAR1', 'utf8');

	class DB1
	{
	    protected static $instance = null;

	    protected function __construct() {}
	    protected function __clone() {}

	    public static function instance()
	    {
	        if (self::$instance === null)
	        {
	            $opt  = array(
	                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	                PDO::ATTR_EMULATE_PREPARES   => FALSE,
	            );
	            $dsn = 'mysql:host='.DB_HOST1.';dbname='.DB_NAME1.';charset='.DB_CHAR1;
	            self::$instance = new PDO($dsn, DB_USER1, DB_PASS1, $opt);
	        }
	        return self::$instance;
	    }

	    public static function __callStatic($method, $args)
	    {
	        return call_user_func_array(array(self::instance(), $method), $args);
	    }

	    public static function run($sql, $args = [])
	    {
	        if (!$args)
	        {
	             return self::instance()->query($sql);
	        }
	        $stmt = self::instance()->prepare($sql);
	        $stmt->execute($args);
	        return $stmt;
	    }

	    public static function getLastInsertedID(){
	    	return self::instance()->lastInsertId();
	    }
	}
?>
