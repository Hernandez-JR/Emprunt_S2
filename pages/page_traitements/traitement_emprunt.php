<?php
session_start();
require_once '../../inc/connexion.php';
require_once '../../inc/functions.php';
$bdd = connectDB();

if (isset($_POST['id_objet']) && isset($_POST['date_emprunt']) && isset($_POST['date_retour']) && isset($_SESSION['idMembre'])) {
    $id_objet = $_POST['id_objet'];
    $date_emprunt = $_POST['date_emprunt'];
    $date_retour = $_POST['date_retour'];
    $id_membre = $_SESSION['idMembre'];

    if (enregistrer_emprunt($bdd, $id_objet, $id_membre, $date_emprunt, $date_retour)) {
        header('Location: ../page_sites/home.php');
        exit();
    } else {
        echo "<p>Erreur lors de l'enregistrement de l'emprunt.</p>";
    }
} else {
    echo "<p>Données manquantes ou utilisateur non connecté.</p>";
} 