<?php
session_start();
?>

<?php

$pdo = new PDO(
    "mysql:host=eupconunico.mysql.db;dbname=eupconunico",
    "eupconunico",
    "1sW7YsITT406",
    array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8')
);

// Success and error variables
$error = "";
$success = "";

define('URL2','http://localhost/php/');


require_once('function.php');

define('URL','http://localhost/PHP/gallerie_photo/');
?>