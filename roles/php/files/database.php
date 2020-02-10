<?php
class Database
{
    private static $dbName = 'miketestdb';
    {% if groups[inv_group_name][0] is defined -%}
    {% set group_host = groups[inv_group_name][0] -%}
    {% set db_host = hostvars[group_host]['ansible_host'] -%}
    {% else -%}
    {% set db_host = 'none' -%}
    {% endif -%}
    private static $dbHost = '{{ db_host }}';
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