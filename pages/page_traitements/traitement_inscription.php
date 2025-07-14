<?php 
    require_once '../../inc/functions.php';
    require_once '../../inc/connexion.php';
    $bdd=connectDB();
?>  


    <?php
    if(isset($_POST['nom']) && isset($_POST['date_de_naissance'])&& isset($_POST['genre'])&&
    isset($_POST['email']) && isset($_POST['ville']) && isset($_POST['mdp'])
    
    ) {
        $nom = $_POST['nom'];
        $date_naissance-= $_POST['date_de_naissance'];
        $genre = $_POST['genre']; 
        $email = $_POST['email'];
        $ville = $_POST['ville'];   
        $motdepasse = $_POST['mdp'];

        if(inscrire_membres($bdd, $nom, $date_naissance ,$genre, $email, $ville, $motdepasse)) {
            header('Location: ../page_sites/home.php');
        } else {
            header('Location: ../page_sites/inscription.php?erreur=1');
        }
    } else {
        header('Location: ../page_sites/inscription.php?erreur=1');
    }
?>  