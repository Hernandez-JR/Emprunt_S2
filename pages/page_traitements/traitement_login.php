<?php 
    require_once '../../inc/functions.php';
    require_once '../../inc/connexion.php';
    $bdd=connectDB();
?>  


    <?php
    if(isset($_POST['email']) && isset($_POST['mdp'])) {
        $email = $_POST['email'];
        $motdepasse = $_POST['mdp'];
        
        if(authentifier_membres($bdd, $email, $motdepasse)) {
            header("Location: ../page_sites/home.php");
        } else {
            header("Location: ../page_sites/connexion.php?erreur=1");

        }
    } else {
        header('Location: ../page_sites/connexion.php?erreur=1');
    }
?>  