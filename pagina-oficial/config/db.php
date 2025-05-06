<?php
/**
 * db.php
 * Conexión con PDO a la base de datos 'fantasy_lec' en PostgreSQL.
 */

$host = 'postgres'; // o el nombre del contenedor si accedes desde otro contenedor
$db = 'fantasy_lec';
$user = 'admin';
$pass = 'secret'; // igual que en tu docker-compose

$dsn = "pgsql:host=$host;port=5432;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
    // Modo de errores: lanzar excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR de conexión: " . $e->getMessage());
}
