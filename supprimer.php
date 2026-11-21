
<?php
require_once 'connexion.php';

// TODO 1 : Vérifier que l'ID existe et qu'il est valide
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false && $_GET['id'] > 0) {

    $id = $_GET['id'];

    // TODO 2 : Préparer et exécuter la requête DELETE
    $sql = "DELETE FROM mesures WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute(['id' => $id]);
}

// TODO 3 : Rediriger vers index.php
header('Location: index.php');
exit;
?>
