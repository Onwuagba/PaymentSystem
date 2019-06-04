<?php

define('HOST', 'localhost'); 
define('USER', 'root');
define('PASSWORD', ''); 
define('DATABASE', 'db_paymentsystem'); 

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