


<?php
//phpinfo();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
ob_start();
session_start();

define('DB_DRIVER', 'mysql');
define('DB_SERVER', 'localhost'); //host
define('DB_SERVER_USERNAME', 'root'); //username setyours
define('DB_SERVER_PASSWORD', ''); //user password setyours
define('DB_DATABASE', 'application'); //database name

$dboptions = array(
   PDO::ATTR_PERSISTENT => false,
   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
   PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);
try
{
   $DB = new PDO(DB_DRIVER . ':host=' . DB_SERVER . ';dbname=' . DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, $dboptions);
}
catch(Exception $ex)
{
   echo $ex->getMessage();
   die;
}
$DB->exec("set names utf8");

?>
