<?php
class Database
{
    private static $dbName = 'miketestdb';
    {% set db_host = groups[inv_group_name][0] -%}
    private static $dbHost = {{ hostvars[db_host]['ansible_host'] }};
    private static $dbUsername = 'michael';
    private static $dbUserPassword = 'hajjar';
     
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont )
       {     
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
        }
        catch(PDOException $e)
        {
          die($e->getMessage()); 
        }
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>