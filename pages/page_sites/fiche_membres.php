<?php
require_once '../../inc/connexion.php';
require_once '../../inc/functions.php';
$bdd = connectDB();

$membres = get_all_membres($bdd);
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
<h2>Liste des membres et leurs emprunts par catégorie</h2>
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
                        <li>Objet : <?php echo $emprunts[$k]['nom_objet']; ?> | Date emprunt : <?php echo $emprunts[$k]['date_emprunt']; ?> | Date retour : <?php echo $emprunts[$k]['date_retour']; ?></li>
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
