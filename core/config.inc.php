<?php

define('HOST', 'us-cdbr-iron-east-02.cleardb.net'); 
define('USER', 'bc63e290c906b7');
define('PASSWORD', '4e3430d9'); 
define('DATABASE', 'heroku_b091b782e479271'); 

function DB()
{
    try {
        $db = new PDO('mysql:host='.HOST.';dbname='.DATABASE.'', USER, PASSWORD);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        return "Error!: " . $e->getMessage();
        file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND); 
        die();
    }
}

$db = null;
?>