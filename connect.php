<?php
$host = 'localhost';
$user = 'root';
$db = 'language_exam';
$password = '';

try {
    $connect = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
