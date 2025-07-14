<?php 
require_once '../../inc/functions.php';
require_once '../../inc/connexion.php';
$bdd = connectDB();
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_objet = mysqli_real_escape_string($bdd, $_POST['nom_objet']);
    $id_categorie = $_POST['categorie_objet'];
    if (isset($_SESSION['idMembre'])) {
        $id_membre = $_SESSION['idMembre'];
    } else {
        $id_membre = null;
    }

    // Insertion de l'objet
    $id_objet = ajouter_objet($bdd, $nom_objet, $id_categorie, $id_membre);
    if ($id_objet) {
    
        if (!empty($_FILES['images_objet']['name'][0])) {
            $dossier = '../../assets/images/img_objet/';
            foreach ($_FILES['images_objet']['tmp_name'] as $key => $tmp_name) {
                $nom_image = basename($_FILES['images_objet']['name'][$key]);
                $chemin = $dossier . $nom_image;
                if (move_uploaded_file($tmp_name, $chemin)) {
                    $nom_image_db = 'assets/images/img_objet/' . $nom_image;
                    ajouter_image_objet($bdd, $id_objet, $nom_image_db);
                }
            }
        }
        header('Location: ../page_sites/home.php');
        exit();
    } else {
        echo "<p>Erreur lors de l'ajout de l'objet.</p>";
    }
} else {
    echo "<p>Méthode non autorisée.</p>";
}
?>  

