<?php
/**
 * Conexión a la base de datos (MySQL).
 * Ajusta los valores de host, usuario, contraseña y nombre de base de datos.
 */

$host = 'localhost';
$db   = 'tiendas_telegram';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>