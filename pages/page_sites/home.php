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
</head>
<body>
    <nav class="navbar navbar-light bg-light mb-4">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Kopaka Borrow</span>
        </div>
    </nav>
    <div class="container">
        <h2 class="mb-4">Liste des objets empruntés</h2>

        <form method="get" action="" class="row g-3 align-items-center mb-4">
            <div class="col-auto">
                <label for="categorie" class="col-form-label">Filtrer par catégorie :</label>
            </div>
            <div class="col-auto">
                <select name="categorie" id="categorie" class="form-select">
                    <option value="">Toutes</option>
                    <?php
                    for ($i = 0; $i < count($categories); $i++) {
                        echo '<option value="' . $categories[$i]['id_categorie'] . '"';
                        if ($id_categorie == $categories[$i]['id_categorie']) {
                            echo ' selected';
                        }
                        echo '>' . $categories[$i]['nom_categorie'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                <?php
                afficher_Tous_Emprunts($bdd, $id_categorie);
                ?>
                </thead>
                <tbody>
                
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>