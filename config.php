<?php
define('PROJECT_NAME', 'Lumintu Event Ticketing');
define('DB_DRIVER', 'mysql');
define('DB_SERVER', 'localhost');
define('DB_SERVER_USERNAME', 'root');
define('DB_SERVER_PASSWORD', '');
define('DB_DATABASE', 'ticketing');

define('SITE_URL', 'http://localhost/intern/ticketing/view/emailOnlyRegistration.php');
define('VERIFY_URL', 'http://localhost/intern/ticketing/view/emailOnly/invitation.php');

$dboptions = array(
    PDO::ATTR_PERSISTENT => FALSE,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try {
    $DB = new PDO(DB_DRIVER . ':host=' . DB_SERVER . ':dbname=' . DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, $dboptions);
} catch (Exception $ex){
    echo $ex->getMessage();
    die;
}
?>