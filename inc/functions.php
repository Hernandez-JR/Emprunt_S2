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

// function afficher_Emprunts_Utilisateur($bdd, $id_membre, $id_categorie = null) {
//     echo '<table border="1" cellpadding="6" cellspacing="0">';
//     echo '<tr><th>Nom de la personne</th><th>Catégorie</th><th>Objet</th><th>Date d\'emprunt</th><th>Fin/Statut</th></tr>';

//     $sql = "
//         SELECT m.nom AS nom_personne, c.nom_categorie, o.nom_objet, e.date_emprunt, e.date_retour
//         FROM EMPRUNTS_emprunt e
//         JOIN EMPRUNTS_objet o ON e.id_objet = o.id_objet
//         JOIN EMPRUNTS_categorie_objet c ON o.id_categorie = c.id_categorie
//         JOIN EMPRUNTS_membres m ON e.id_membre = m.id_membre
//         WHERE m.id_membre = " . intval($id_membre);
//     if ($id_categorie) {
//         $sql .= " AND o.id_categorie = " . intval($id_categorie);
//     }
//     $sql .= " ORDER BY e.date_emprunt DESC";
//     $res = mysqli_query($bdd, $sql);
//     $aujourdhui = date('Y-m-d');
//     if ($res && mysqli_num_rows($res) > 0) {
//         while ($row = mysqli_fetch_assoc($res)) {
//             if ($row['date_retour'] >= $aujourdhui) {
//                 $statut = $row['date_retour'];
//             } else {
//                 $statut = 'expiré';
//             }
//             echo '<tr>';
//             echo '<td>' . $row['nom_personne'] . '</td>';
//             echo '<td>' . $row['nom_categorie'] . '</td>';
//             echo '<td>' . $row['nom_objet'] . '</td>';
//             echo '<td>' . $row['date_emprunt'] . '</td>';
//             echo '<td>' . $statut . '</td>';
//             echo '</tr>';
//         }
//     } else {
//         echo '<tr><td colspan="5">Aucun emprunt trouvé.</td></tr>';
//     }
//     echo '</table>';
// }

function afficher_Tous_Emprunts($bdd, $id_categorie = null) {
    echo '<table border="1" cellpadding="6" cellspacing="0">';
    echo '<tr><th>Nom de la personne</th><th>Catégorie</th><th>Objet</th><th>Date d\'emprunt</th><th>Fin/Statut</th></tr>';

    $sql = "
        SELECT m.nom AS nom_personne, c.nom_categorie, o.nom_objet, e.date_emprunt, e.date_retour
        FROM EMPRUNTS_emprunt e
        JOIN EMPRUNTS_objet o ON e.id_objet = o.id_objet
        JOIN EMPRUNTS_categorie_objet c ON o.id_categorie = c.id_categorie
        JOIN EMPRUNTS_membres m ON e.id_membre = m.id_membre
    ";
    if ($id_categorie) {
        $sql .= " WHERE o.id_categorie = '" . $id_categorie . "'";
    }
    $sql .= " ORDER BY e.date_emprunt DESC";
    $res = mysqli_query($bdd, $sql);
    $aujourdhui = date('Y-m-d');
    if ($res && mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            if ($row['date_retour'] >= $aujourdhui) {
                $statut = $row['date_retour'];
            } else {
                $statut = 'expiré';
            }
            echo '<tr>';
            echo '<td>' . $row['nom_personne'] . '</td>';
            echo '<td>' . $row['nom_categorie'] . '</td>';
            echo '<td>' . $row['nom_objet'] . '</td>';
            echo '<td>' . $row['date_emprunt'] . '</td>';
            echo '<td>' . $statut . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5">Aucun emprunt trouvé.</td></tr>';
    }
    echo '</table>';
} 