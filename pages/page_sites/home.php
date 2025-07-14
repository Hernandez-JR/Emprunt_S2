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
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%); box-shadow: 0 4px 12px rgba(78,84,200,0.15);">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold fs-3" href="#" style="color: #fff; letter-spacing: 2px;">
                <img src="../../assets/images/logo.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-top me-2" style="border-radius: 50%; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                Kopaka Borrow
            </a>
            <div class="d-flex ms-auto align-items-center">
                <span class="me-3 text-white fw-light" style="font-size: 1.1rem;">
                    <?php if(isset($_SESSION['nom'])) ?> <p>"Bienvenue,</p><strong><?php echo $_SESSION['nom'] ?> </strong>"; ?>
                </span>
                <a href="../../inc/deconnexion.php" class="btn btn-danger px-4 py-2 fw-semibold shadow-sm" style="border-radius: 25px; transition: background 0.2s;">
                    <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                </a>
            </div>
        </div>
    </nav>
    <!-- Ajout d'un séparateur décoratif -->
    <div style="height: 4px; background: linear-gradient(90deg, #8f94fb 0%, #4e54c8 100%); margin-bottom: 30px; border-radius: 2px;"></div>
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