<?php
// Database connection variables
    $host = 'localhost';
$user = 'root';
$pass = '';
$db = 'taskproject';

// Create a PDO object
$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);