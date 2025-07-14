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
$nom_objet = isset($_GET['nom_objet']) ? $_GET['nom_objet'] : '';
$disponible = isset($_GET['disponible']) ? true : false;

$categories = array();
$sql_cat = "SELECT id_categorie, nom_categorie FROM EMPRUNTS_categorie_objet";
$res_cat = mysqli_query($bdd, $sql_cat);
if ($res_cat) {
    while ($row = mysqli_fetch_assoc($res_cat)) {
        $categories[] = $row;
    }
}

$liste_objets = array();
$sql = "SELECT o.id_objet, o.nom_objet, c.nom_categorie, e.date_emprunt, e.date_retour
        FROM EMPRUNTS_objet o
        JOIN EMPRUNTS_categorie_objet c ON o.id_categorie = c.id_categorie
        LEFT JOIN EMPRUNTS_emprunt e ON o.id_objet = e.id_objet";
$conditions = array();
if ($id_categorie) {
    $conditions[] = "o.id_categorie = '" . mysqli_real_escape_string($bdd, $id_categorie) . "'";
}
if ($nom_objet != '') {
    $conditions[] = "o.nom_objet LIKE '%" . mysqli_real_escape_string($bdd, $nom_objet) . "%'";
}
if ($disponible) {
    $conditions[] = "(e.date_retour IS NULL OR e.date_retour < CURDATE())";
}
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}
$sql .= " ORDER BY o.nom_objet ASC";
$res = mysqli_query($bdd, $sql);
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $id_objet = $row['id_objet'];
        $img_sql = "SELECT nom_image FROM EMPRUNTS_images_objet WHERE id_objet = $id_objet LIMIT 1";
        $img_res = mysqli_query($bdd, $img_sql);
        if ($img_res && mysqli_num_rows($img_res) > 0) {
            $img_row = mysqli_fetch_assoc($img_res);
            $img_src = '../../' . $img_row['nom_image'];
            $img_name = $img_row['nom_image'];
            $delete_btn = '<form method="post" action="../page_traitements/traitement_recherche.php" style="display:inline;">
                <input type="hidden" name="id_objet" value="' . $id_objet . '">
                <input type="hidden" name="img_name" value="' . $img_name . '">
                <button type="submit" name="supprimer_image" class="btn btn-sm btn-danger ms-2" onclick="return confirm(\'Supprimer cette image ?\')">🗑️</button>
            </form>';
        } else {
            $img_src = '../../assets/images/img_objet/tournevis.webp';
            $delete_btn = '';
        }
        $date_emprunt = $row['date_emprunt'] ? $row['date_emprunt'] : '-';
        $date_retour = $row['date_retour'] ? $row['date_retour'] : 'disponible';
        $liste_objets[] = array(
            'id_objet' => $id_objet,
            'img_src' => $img_src,
            'delete_btn' => $delete_btn,
            'nom_objet' => $row['nom_objet'],
            'nom_categorie' => $row['nom_categorie'],
            'date_emprunt' => $date_emprunt,
            'date_retour' => $date_retour
        );
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
        <div class="row">
            <div class="col-md-7">
                <div class="table-container">
                    <h2 class="mb-4 text-center">Liste des objets empruntés</h2>
                    <form method="get" action="" class="row g-3 align-items-center mb-4 justify-content-center">
                        <div class="col-auto">
                            <label for="categorie" class="col-form-label">Catégorie :</label>
                        </div>
                        <div class="col-auto">
                            <select name="categorie" id="categorie" class="form-select">
                                <option value="">Toutes</option>
                                <?php foreach ($categories as $cat) { ?>
                                    <option value="<?php echo $cat['id_categorie']; ?>"<?php if ($id_categorie == $cat['id_categorie']) { ?> selected<?php } ?>>
                                        <?php echo $cat['nom_categorie']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-auto">
                            <label for="nom_objet" class="col-form-label">Nom de l'objet :</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" name="nom_objet" id="nom_objet" class="form-control" value="<?php echo htmlspecialchars($nom_objet); ?>">
                        </div>
                        <div class="col-auto">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="disponible" id="disponible" <?php if ($disponible) echo 'checked'; ?>>
                                <label class="form-check-label" for="disponible">Disponible</label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-warning">Rechercher</button>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Objet</th>
                                    <th>Catégorie</th>
                                    <th>Date d'emprunt</th>
                                    <th>Date de retour</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($liste_objets) > 0) {
                                    foreach ($liste_objets as $row) {
                                        echo '<tr>';
                                        echo '<td style="white-space:nowrap;"><img src="' . $row['img_src'] . '" alt="image objet" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">' . $row['delete_btn'] . '</td>';
                                        echo '<td><a href="fiche_objet.php?id=' . $row['id_objet'] . '" style="color:#2563eb;text-decoration:underline;">' . $row['nom_objet'] . '</a></td>';
                                        echo '<td>' . $row['nom_categorie'] . '</td>';
                                        echo '<td>' . $row['date_emprunt'] . '</td>';
                                        echo '<td>' . $row['date_retour'] . '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="5">Aucun objet trouvé.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
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
                        <button type="submit" class="btn px-4" style="background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%); color: #fff; border: none;">Ajouter l'objet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../../inc/footer.php'; ?>
</body>
</html>