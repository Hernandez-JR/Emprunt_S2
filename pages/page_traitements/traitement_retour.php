<?php
session_start();
require_once '../../inc/connexion.php';
$bdd = connectDB();

if (isset($_POST['id_membre']) && isset($_POST['nom_objet']) && isset($_POST['date_emprunt'])) {
    $id_membre = $_POST['id_membre'];
    $nom_objet = $_POST['nom_objet'];
    $date_emprunt = $_POST['date_emprunt'];

    $etat_retour = (rand(0, 1) == 0) ? 'ok' : 'abime';

    $sql_obj = "SELECT id_objet FROM EMPRUNTS_objet WHERE nom_objet = '$nom_objet'";
    $res_obj = mysqli_query($bdd, $sql_obj);
    if ($res_obj && mysqli_num_rows($res_obj) > 0) {
        $row_obj = mysqli_fetch_assoc($res_obj);
        $id_objet = $row_obj['id_objet'];

        $sql_update = "UPDATE EMPRUNTS_emprunt SET etat_retour = '$etat_retour' WHERE id_objet = $id_objet AND id_membre = $id_membre AND date_emprunt = '$date_emprunt' LIMIT 1";
        if (mysqli_query($bdd, $sql_update)) {
            if ($etat_retour == 'ok') {
                echo "<div style='color:green;font-weight:bold;margin:30px;'>Retour enregistré : l'objet est en bon état.</div>";
            } else {
                echo "<div style='color:red;font-weight:bold;margin:30px;'>Retour enregistré : l'objet est abimé.</div>";
            }
            echo "<a href='../page_sites/fiche_membres.php'>Retour à la fiche membres</a>";
        } else {
            echo "<div style='color:red;'>Erreur lors de la mise à jour du retour.</div>";
        }
    } else {
        echo "<div style='color:red;'>Objet non trouvé.</div>";
    }
} else {
    echo "<div style='color:red;'>Données manquantes.</div>";
}
