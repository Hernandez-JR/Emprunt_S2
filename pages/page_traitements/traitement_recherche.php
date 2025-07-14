<?php
session_start();
require_once '../../inc/connexion.php';
$bdd = connectDB();

if (isset($_POST['supprimer_image']) && isset($_POST['id_objet']) && isset($_POST['img_name'])) {
    $id_objet = intval($_POST['id_objet']);
    $img_name = $_POST['img_name'];

    $img_path = '../../' . $img_name;
    if (file_exists($img_path)) {
        unlink($img_path);
    }

    $sql = "DELETE FROM EMPRUNTS_images_objet WHERE id_objet = $id_objet AND nom_image = '" . mysqli_real_escape_string($bdd, $img_name) . "' LIMIT 1";
    mysqli_query($bdd, $sql);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

header('Location: ../page_sites/home.php');
exit(); 