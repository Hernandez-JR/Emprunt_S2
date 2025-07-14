<?php 
    require_once '../../inc/functions.php';
    require_once '../../inc/connexion.php';
    $bdd=connectDB();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav></nav>
    <h1>Page de connexion</h1>

    <form action="traitement_login.php" method=post>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="mdp">Mot de passe :</label>
        <input type="password" id="mdp" name="mdp" required><br><br>

        <input type="submit" value="Se connecter">

        <a href="inscription.php">Pas encore de compte? Cliquez-moi</a>
    </form>
</body>
</html>