
<?php
require_once 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // TODO 1 : Récupérer les données du formulaire
    $personne_id = $_POST['personne_id'] ?? '';
    $poids = $_POST['poids'] ?? '';
    $taille = $_POST['taille'] ?? '';

    // TODO 2 : Vérifier les données
    if (
        !is_numeric($personne_id) ||
        !is_numeric($poids) ||
        !is_numeric($taille) ||
        $personne_id <= 0 ||
        $poids < 20 || $poids > 300 ||
        $taille < 0.5 || $taille > 2.5
    ) {
        header('Location: index.php');
        exit;
    }

    // Vérifier que la personne existe
    $check = $pdo->prepare("SELECT id FROM personnes WHERE id = ?");
    $check->execute([$personne_id]);

    if (!$check->fetch()) {
        header('Location: index.php');
        exit;
    }

    // TODO 3 : Calculer l'IMC et déterminer la catégorie
    $imc = round($poids / ($taille * $taille), 1);

    if ($imc < 18.5) {
        $categorie = 'Sous-poids';
    } elseif ($imc < 25) {
        $categorie = 'Normal';
    } elseif ($imc < 30) {
        $categorie = 'Surpoids';
    } else {
        $categorie = 'Obésité';
    }

    // TODO 4 : Insérer la mesure dans la base de données
    $sql = "INSERT INTO mesures
            (personne_id, poids, taille, imc, categorie)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $personne_id,
        $poids,
        $taille,
        $imc,
        $categorie
    ]);
}

// TODO 5 : Rediriger vers index.php
header('Location: index.php');
exit;
?>
