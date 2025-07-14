<?php
function connectDB() { 
    $host = '172.60.0.15';
    $user = 'ETU004027';
    $password = 'upaWMyBG';
    $database = 'db_s2_ETU004027';

    $bdd = mysqli_connect($host, $user, $password, $database);

    if (!$bdd) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }
    return $bdd;
}

// function connectDB() { 
//     $host = 'localhost';
//     $user = 'root';
//     $password = '';
//     $database = 'emprunts';

//     $bdd = mysqli_connect($host, $user, $password, $database);

//     if (!$bdd) {
//         die("Erreur de connexion : " . mysqli_connect_error());
//     }
//     return $bdd;
// }


