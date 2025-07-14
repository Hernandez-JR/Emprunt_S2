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
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css_perso/style_inscription.css">
</head>
<body>
    <div class="inscription-wrapper">
        <div class="card-custom">
            <h2 class="titre-form">Inscription</h2>
            <form action="../page_traitements/traitement_inscription.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom et Prénoms</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="mb-3">
                    <label for="date_de_naissance" class="form-label">Date de naissance</label>
                    <input type="date" class="form-control" id="date_de_naissance" name="date_de_naissance" required>
                </div>
                <div class="mb-3">
                    <label for="genre" class="form-label">Genre</label>
                    <select class="form-select" id="genre" name="genre" required>
                        <option value="H">H</option>
                        <option value="F">F</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="ville" class="form-label">Ville</label>
                    <input type="text" class="form-control" id="ville" name="ville" required>
                </div>
                <div class="mb-3">
                    <label for="mdp" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
            </form>
            <div class="text-center mt-3">
                <a href="login.php" class="btn btn-outline-primary w-100">Déjà un compte ? Connectez-vous ici</a>
            </div>
        </div>
    </div>
</body>
</html>