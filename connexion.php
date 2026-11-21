<?php
// ==========================================================
// EXERCICE 7.1 : CONNEXION À LA BASE DE DONNÉES VIA PDO
// ==========================================================
 
$host = 'localhost';
$port = '3307';
$dbname = 'imc_db';
$username = 'root';
$password = ''; // Vide par défaut sur XAMPP

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
 
try {
    // TODO 1 : Instancier l'objet $pdo avec le DSN mysql, charset=utf8mb4
    $pdo = new PDO($dsn, $username, $password);
    // TODO 2 : Configurer le mode d'erreur sur PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
