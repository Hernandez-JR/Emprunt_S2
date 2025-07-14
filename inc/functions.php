<?php

function authentifier_membres($bdd, $email, $motdepasse) {
    $email = mysqli_real_escape_string($bdd, $email);
    $motdepasse = mysqli_real_escape_string($bdd, $motdepasse);
    

    $requete = "SELECT * FROM EMPRUNTS_membres WHERE email = '$email'";
    $resultat = mysqli_query($bdd, $requete);
    
    if(mysqli_num_rows($resultat) > 0) {
        $membre = mysqli_fetch_assoc($resultat);
        if($membre['mdp'] === $motdepasse) {
            session_start();
            $_SESSION['idMembre'] = $membre['id_membre'];
            $_SESSION['nom'] = $membre['nom'];
            $_SESSION['email'] = $membre['email'];
            $_SESSION['date_naissance'] = $membre['date_de_naissance'];
            $_SESSION['ville'] = $membre['ville'];
            return true;
        }
    }
    
    return false;
}

function inscrire_membres($bdd, $nom, $dtn ,$genre, $email, $ville, $mdp) { 
    $requete = "INSERT INTO EMPRUNTS_membres (nom, date_de_naissance, genre, email, ville, mdp) 
                VALUES ('$nom', '$dtn', '$genre', '$email', '$ville', '$mdp')";

    return mysqli_query($bdd, $requete);
}