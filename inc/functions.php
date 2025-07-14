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
    $sql = "
        SELECT o.id_objet, o.nom_objet, c.nom_categorie, e.date_emprunt, e.date_retour
        FROM EMPRUNTS_objet o
        JOIN EMPRUNTS_categorie_objet c ON o.id_categorie = c.id_categorie
        LEFT JOIN EMPRUNTS_emprunt e ON o.id_objet = e.id_objet
    ";
    if ($id_categorie) {
        $sql .= " WHERE o.id_categorie = '" . $id_categorie . "'";
    }
    $sql .= " ORDER BY o.nom_objet ASC";
    $res = mysqli_query($bdd, $sql);
    if ($res && mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $id_objet = $row['id_objet'];
            $img_sql = "SELECT nom_image FROM EMPRUNTS_images_objet WHERE id_objet = $id_objet LIMIT 1";
            $img_res = mysqli_query($bdd, $img_sql);
            if ($img_res && mysqli_num_rows($img_res) > 0) {
                $img_row = mysqli_fetch_assoc($img_res);
                $img_src = '../../' . $img_row['nom_image'];
            } else {
                $img_src = '../../assets/images/img_objet/tournevis.webp';
            }
            $date_emprunt = $row['date_emprunt'] ? $row['date_emprunt'] : '-';
            $date_retour = $row['date_retour'] ? $row['date_retour'] : 'disponible';
            echo '<tr>';
            echo '<td><img src="' . $img_src . '" alt="image objet" style="width:60px;height:60px;object-fit:cover;border-radius:8px;"></td>';
            echo '<td><a href="fiche_objet.php?id=' . $row['id_objet'] . '" style="color:#2563eb;text-decoration:underline;">' . $row['nom_objet'] . '</a></td>';
            echo '<td>' . $row['nom_categorie'] . '</td>';
            echo '<td>' . $date_emprunt . '</td>';
            echo '<td>' . $date_retour . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5">Aucun objet trouvé.</td></tr>';
    }
} 

function ajouter_objet($bdd, $nom_objet, $id_categorie, $id_membre) {
    $sql = "INSERT INTO EMPRUNTS_objet (nom_objet, id_categorie, id_membre) VALUES ('$nom_objet', $id_categorie, $id_membre)";
    if (mysqli_query($bdd, $sql)) {
        return mysqli_insert_id($bdd);
    } else {
        return false;
    }
}

function ajouter_image_objet($bdd, $id_objet, $nom_image) {
    $sql = "INSERT INTO EMPRUNTS_images_objet (id_objet, nom_image) VALUES ($id_objet, '$nom_image')";
    return mysqli_query($bdd, $sql);
} 

function get_objet_by_id($bdd, $id_objet) {
    $sql = "SELECT o.nom_objet, c.nom_categorie FROM EMPRUNTS_objet o JOIN EMPRUNTS_categorie_objet c ON o.id_categorie = c.id_categorie WHERE o.id_objet = $id_objet";
    $res = mysqli_query($bdd, $sql);
    if ($res && mysqli_num_rows($res) > 0) {
        return mysqli_fetch_assoc($res);
    } else {
        return false;
    }
}

function get_images_objet($bdd, $id_objet) {
    $sql = "SELECT nom_image FROM EMPRUNTS_images_objet WHERE id_objet = $id_objet";
    $res = mysqli_query($bdd, $sql);
    $images = array();
    if ($res && mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $images[] = $row['nom_image'];
        }
    }
    return $images;
}

function get_historique_emprunts_objet($bdd, $id_objet) {
    $sql = "SELECT e.date_emprunt, e.date_retour, m.nom FROM EMPRUNTS_emprunt e JOIN EMPRUNTS_membres m ON e.id_membre = m.id_membre WHERE e.id_objet = $id_objet ORDER BY e.date_emprunt DESC";
    $res = mysqli_query($bdd, $sql);
    $hist = array();
    if ($res && mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $hist[] = $row;
        }
    }
    return $hist;
} 