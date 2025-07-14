<?php
require_once '../../inc/connexion.php';
$bdd = connectDB();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des emprunts</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Liste des emprunts</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nom de l'objet</th>
                    <th>Emprunteur</th>
                    <th>Date d'emprunt</th>
                    <th>Date de retour</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT e.id_emprunt, o.nom_objet, m.nom AS nom_membre, e.date_emprunt, e.date_retour
                        FROM EMPRUNTS_emprunt e
                        JOIN EMPRUNTS_objet o ON e.id_objet = o.id_objet
                        JOIN EMPRUNTS_membres m ON e.id_membre = m.id_membre
                        ORDER BY e.date_emprunt DESC";
                $result = mysqli_query($bdd, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $i++ . "</td>";
                        echo "<td>" . $row['nom_objet'] . "</td>";
                        echo "<td>" . $row['nom_membre'] . "</td>";
                        echo "<td>" . $row['date_emprunt'] . "</td>";
                        echo "<td>" . $row['date_retour'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo '<tr><td colspan="5" class="text-center">Aucun emprunt trouvé.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <a href="home.php" class="btn btn-secondary">Retour à l'accueil</a>
    </div>
</body>
</html>
