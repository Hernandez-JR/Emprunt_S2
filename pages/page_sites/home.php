<?php
session_start();
require_once '../../inc/connexion.php';
require_once '../../inc/functions.php';
$bdd = connectDB();

if (isset($_GET['categorie']) && $_GET['categorie'] != "") {
    $id_categorie = $_GET['categorie'];
} else {
    $id_categorie = null;
}

$categories = array();
$sql_cat = "SELECT id_categorie, nom_categorie FROM EMPRUNTS_categorie_objet";
$res_cat = mysqli_query($bdd, $sql_cat);
if ($res_cat) {
    while ($row = mysqli_fetch_assoc($res_cat)) {
        $categories[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des objets</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css_perso/style_home.css">
</head>
<body>
<?php include '../../inc/header.php'; ?>
<div class="main-content">
    <div style="height: 4px; background: linear-gradient(90deg, #8f94fb 0%, #4e54c8 100%); margin-bottom: 30px; border-radius: 2px;"></div>

    <div class="container mt-5">
        <div class="table-container">
            <h2 class="mb-4 text-center">Liste des objets empruntés</h2>
            <form method="get" action="" class="row g-3 align-items-center mb-4 justify-content-center">
                <div class="col-auto">
                    <label for="categorie" class="col-form-label">Filtrer par catégorie :</label>
                </div>
                <div class="col-auto">
                    <select name="categorie" id="categorie" class="form-select">
                        <option value="">Toutes</option>
                        <?php for ($i = 0; $i < count($categories); $i++) { ?>
                            <option value="<?php echo $categories[$i]['id_categorie']; ?>"<?php if ($id_categorie == $categories[$i]['id_categorie']) { ?> selected<?php } ?>>
                                <?php echo $categories[$i]['nom_categorie']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-warning">Filtrer</button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Objet</th>
                            <th>Catégorie</th>
                            <th>Date d'emprunt</th>
                            <th>Date de retour</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php afficher_Tous_Emprunts($bdd, $id_categorie); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <form action="../page_traitements/traitement_ajouter_nouvel_objet.php" method="post" enctype="multipart/form-data" class="mt-5 mb-4 p-4 bg-white rounded shadow-sm" style="max-width: 600px; margin: 0 auto;">
    <h4 class="mb-3 text-center">Ajouter un nouvel objet</h4>
    <div class="mb-3">
        <label for="nom_objet" class="form-label">Nom de l'objet</label>
        <input type="text" class="form-control" id="nom_objet" name="nom_objet" required>
    </div>
    <div class="mb-3">
        <label for="categorie_objet" class="form-label">Categorie</label>
        <select name="categorie_objet" id="categorie_objet" class="form-select" required>
            <?php foreach ($categories as $cat) { ?>
                <option value="<?php echo $cat['id_categorie']; ?>"><?php echo $cat['nom_categorie']; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="images_objet" class="form-label">Images de l'objet</label>
        <input type="file" class="form-control" id="images_objet" name="images_objet[]" accept="image/*" multiple required>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary px-4">Ajouter l'objet</button>
    </div>
</form>
    </div>
</div>
<?php include '../../inc/footer.php'; ?>
</body>
</html>