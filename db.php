<?php
$host = "localhost";
$user = "kullanici";
$pass = "sifre";
$db   = "kullaniciadi";

try {
    $db = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("Hata: " . $e->getMessage());
}
?>