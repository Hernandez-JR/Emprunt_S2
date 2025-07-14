<?php 
    require_once '../../inc/functions.php';
    require_once '../../inc/connexion.php';
    $bdd=connectDB();
    session_start();
?>  


    <?php
    session_start();
    if(isset($_POST['email']) && isset($_POST['mdp'])) {
        $email = $_POST['email'];
        $motdepasse = $_POST['mdp'];
        
        
        if(authentifier_membres($bdd, $email, $motdepasse)) {
            $requete = "SELECT nom, email FROM EMPRUNTS_membres WHERE email = '$email'";
            $resultat = mysqli_query($bdd, $requete);
            if($resultat && mysqli_num_rows($resultat) > 0) {
                $membre = mysqli_fetch_assoc($resultat);
                $_SESSION['nom'] = $membre['nom'];
                $_SESSION['email'] = $membre['email'];
            }
            header("Location: ../page_sites/home.php");
        } else {
            header("Location: ../page_sites/connexion.php?erreur=1");
        }
    } else {
        header('Location: ../page_sites/connexion.php?erreur=1');
    }
    ?>  