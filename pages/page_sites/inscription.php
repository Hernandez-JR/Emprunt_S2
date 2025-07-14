<?php 
    require_once '../../inc/functions.php';
    require_once '../../inc/connexion.php';
    $bdd=connectDB();
?> 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <nav></nav>
    <h1>Page d'inscription</h1>

    <form action="traitement_inscription.php" method="post" enctype="multipart/form-data">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="date_de_naissance">Date de naissance :</label>
        <input type="date" id="date_de_naissance" name="date_de_naissance" required><br><br>

        <label for="genre">Genre :</label>
        <select id="genre" name="genre" required>
            <option value="">--Sélectionnez--</option>
            <option value="H">Homme</option>
            <option value="F">Femme</option>
            <option value="M">Masculin</option>
        </select><br><br>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="ville">Ville :</label>
        <input type="text" id="ville" name="ville" required><br><br>

        <label for="mdp">Mot de passe :</label>
        <input type="password" id="mdp" name="mdp" required><br><br>
        
        <input type="submit" value="S'inscrire">
    </form>
    <br>
    <a href="login.php">Déjà un compte ? Connectez-vous ici</a>
</body>
</html>