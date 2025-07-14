<?php
require_once '../../inc/connexion.php';
require_once '../../inc/functions.php';
$bdd = connectDB();

$membres = get_all_membres($bdd);


$retour_message = '';
if (isset($_GET['etat_retour'])) {
    if ($_GET['etat_retour'] === 'ok') {
        $retour_message = '<div class="alert alert-success">Retour effectué : OK</div>';
    } elseif ($_GET['etat_retour'] === 'abime') {
        $retour_message = '<div class="alert alert-warning">Retour effectué : Objet abîmé</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Membres et emprunts</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css_perso/style_fiche_membres.css">
    <link rel="stylesheet" href="../../assets/css_perso/style_home.css">
</head>
<?php include '../../inc/header.php'; ?>
<body>

<div class="container mt-3 mb-3">
    <a href="liste_emprunts.php" class="btn btn-info">Voir la liste des emprunts</a>
</div>
<h2>Liste des membres et leurs emprunts par catégorie</h2>
<?php

if (!empty($retour_message)) {
    echo $retour_message;
}
?>
<?php if (count($membres) > 0) { for ($i = 0; $i < count($membres); $i++) { ?>
    <div class="membre-block">
        <h3><?php echo $membres[$i]['nom']; ?></h3>
        <?php $categories = get_categories_empruntees_by_membre($bdd, $membres[$i]['id_membre']);
        if (count($categories) > 0) { for ($j = 0; $j < count($categories); $j++) { ?>
            <div class="categorie-block">
                <b><?php echo $categories[$j]['nom_categorie']; ?></b><br>
                <?php $emprunts = get_emprunts_by_membre_and_categorie($bdd, $membres[$i]['id_membre'], $categories[$j]['id_categorie']);
                if (count($emprunts) > 0) { ?>
                    <ul>
                    <?php for ($k = 0; $k < count($emprunts); $k++) { ?>
                        <li>Objet : <?php echo $emprunts[$k]['nom_objet']; ?> | Date emprunt : <?php echo $emprunts[$k]['date_emprunt']; ?> | Date retour : <?php echo $emprunts[$k]['date_retour']; ?>
                            <form method="post" action="../page_traitements/traitement_retour.php" style="display:inline; margin-left:10px;">
                                <input type="hidden" name="id_membre" value="<?php echo $membres[$i]['id_membre']; ?>">
                                <input type="hidden" name="nom_objet" value="<?php echo $emprunts[$k]['nom_objet']; ?>">
                                <input type="hidden" name="date_emprunt" value="<?php echo $emprunts[$k]['date_emprunt']; ?>">
                                <button type="submit" class="btn btn-sm btn-primary" name="retour">Retour</button>
                            </form>
                            <?php
                            
                            if (
                                isset($_GET['etat_retour'], $_GET['id_membre'], $_GET['nom_objet'], $_GET['date_emprunt']) &&
                                $_GET['id_membre'] == $membres[$i]['id_membre'] &&
                                $_GET['nom_objet'] == $emprunts[$k]['nom_objet'] &&
                                $_GET['date_emprunt'] == $emprunts[$k]['date_emprunt']
                            ) {
                                if ($_GET['etat_retour'] === 'ok') {
                                    echo '<span class="badge bg-success ms-2">OK</span>';
                                } elseif ($_GET['etat_retour'] === 'abime') {
                                    echo '<span class="badge bg-warning text-dark ms-2">Abîmé</span>';
                                }
                            }
                            ?>
                        </li>
                    <?php } ?>
                    </ul>
                <?php } else { ?>
                    Aucun emprunt dans cette catégorie.<br>
                <?php } ?>
            </div>
        <?php } } else { ?>
            Aucun emprunt pour ce membre.<br>
        <?php } ?>
    </div>
    <hr>
<?php } } else { ?>
    Aucun membre trouvé.
<?php } ?>
<?php include '../../inc/footer.php'; ?>
</body>
</html>
