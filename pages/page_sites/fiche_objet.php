<?php
session_start();
require_once '../../inc/connexion.php';
require_once '../../inc/functions.php';
$bdd = connectDB();

if (isset($_GET['id'])) {
    $id_objet = $_GET['id'];
    $objet = get_objet_by_id($bdd, $id_objet);
    $images = get_images_objet($bdd, $id_objet);
    $historique = get_historique_emprunts_objet($bdd, $id_objet);
} else {
    $objet = false;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche objet</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css_perso/style_fiche.css">

</head>
<body>
<?php include '../../inc/header.php'; ?>
<div class="container mt-5 mb-5">
    <?php if ($objet) { ?>
        <div class="fiche-objet-box p-4 bg-white rounded shadow-sm">
            <h2 class="mb-3 text-center"><?php echo $objet['nom_objet']; ?></h2>
            <p class="text-center mb-4"><strong>Catégorie :</strong> <?php echo $objet['nom_categorie']; ?></p>
            <div class="row justify-content-center mb-4">
                <?php if (count($images) > 0) {
                    foreach ($images as $img) { ?>
                        <div class="col-auto mb-2">
                            <img src="../../<?php echo $img; ?>" alt="image objet" class="img-fiche-objet">
                        </div>
                <?php } } else { ?>
                    <div class="col-auto mb-2">
                        <img src="../../assets/images/img_objet/tournevis.webp" alt="image objet" class="img-fiche-objet">
                    </div>
                <?php } ?>
            </div>
            <h4 class="mb-3">Historique des emprunts</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nom de l'emprunteur</th>
                            <th>Date d'emprunt</th>
                            <th>Date de retour</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($historique) > 0) {
                            foreach ($historique as $emp) { ?>
                                <tr>
                                    <td><?php echo $emp['nom']; ?></td>
                                    <td><?php echo $emp['date_emprunt']; ?></td>
                                    <td><?php echo $emp['date_retour']; ?></td>
                                </tr>
                        <?php } } else { ?>
                            <tr><td colspan="3">Aucun emprunt pour cet objet.</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } else { ?>
        <div class="alert alert-danger mt-5">Objet introuvable.</div>
    <?php } ?>
</div>
<?php include '../../inc/footer.php'; ?>
</body>
</html>
