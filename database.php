<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=livreor;charset=utf8mb4', 'ennys', 'Ennys1502@');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}