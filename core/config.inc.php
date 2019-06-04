<?php

define('HOST', 'us-cdbr-iron-east-02.cleardb.net'); 
define('USER', 'bb5b89bc3630ff');
define('PASSWORD', 'e58905aa'); 
define('DATABASE', 'us-cdbr-iron-east-02.cleardb.net'); 

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