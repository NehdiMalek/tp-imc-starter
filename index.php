
<?php
require_once 'connexion.php';

// TODO 1 : Récupérer toutes les personnes
$sql = "SELECT * FROM personnes";
$stmt = $pdo->query($sql);
$personnes = $stmt->fetchAll();

// TODO 2 : Récupérer l'historique avec le nom de la personne
$sql = "SELECT mesures.*, personnes.nom, personnes.prenom
        FROM mesures
        INNER JOIN personnes
        ON mesures.personne_id = personnes.id
        ORDER BY mesures.date_mesure DESC";

$stmt = $pdo->query($sql);
$mesures = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculateur d'IMC</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
</head>
<body>
    <header>
        <h1>Calculateur d'IMC</h1>
    </header>

    <main>
        <section>
            <h2>Saisie</h2>

            <form class="imc" action="ajouter.php" method="POST">
                <label>
                    Personne
                    <select name="personne_id" required>
                        <option value="">-- Choisir --</option>

                        <?php foreach ($personnes as $personne): ?>
                            <option value="<?= htmlspecialchars($personne['id']) ?>">
                                <?= htmlspecialchars($personne['nom'] . ' ' . $personne['prenom']) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </label>

                <label>
                    Poids (kg)
                    <input id="imc-poids" name="poids" type="number" step="0.1" min="20" max="300" required />
                </label>

                <label>
                    Taille (m)
                    <input id="imc-taille" name="taille" type="number" step="0.01" min="0.5" max="2.5" required />
                </label>

                <div>
                    <button id="imc-calculer" type="button">Calculer</button>
                    <button type="submit">Enregistrer la mesure</button>
                </div>
            </form>
        </section>

        <section>
            <h2>Résultat</h2>
            <p>Votre IMC : <strong id="imc-valeur">-</strong></p>
            <p>Catégorie : <strong id="imc-categorie">-</strong></p>
        </section>

        <section>
            <h2>Historique des mesures</h2>
            <table>
                <thead>
                    <tr>
                        <th>Personne</th>
                        <th>Poids (kg)</th>
                        <th>Taille (m)</th>
                        <th>IMC</th>
                        <th>Catégorie</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($mesures as $mesure): ?>
                        <tr>
                            <td><?= htmlspecialchars($mesure['nom'] . ' ' . $mesure['prenom']) ?></td>
                            <td><?= htmlspecialchars($mesure['poids']) ?></td>
                            <td><?= htmlspecialchars($mesure['taille']) ?></td>
                            <td><?= htmlspecialchars($mesure['imc']) ?></td>
                            <td><?= htmlspecialchars($mesure['categorie']) ?></td>
                            <td><?= htmlspecialchars($mesure['date_mesure']) ?></td>
                            <td>
                                <a href="supprimer.php?id=<?= htmlspecialchars($mesure['id']) ?>"
                                   onclick="return confirm('Voulez-vous vraiment supprimer cette mesure ?')">
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($mesures)): ?>
                        <tr>
                            <td colspan="7">Aucune mesure enregistrée.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>Centre de nutrition — ISTMT</p>
    </footer>
</body>
</html>
