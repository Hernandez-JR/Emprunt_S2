<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%); box-shadow: 0 4px 12px rgba(78,84,200,0.15);">
    <div class="container-fluid">
        
        <a class="navbar-brand fw-bold fs-3" href="#" style="color: #fff; letter-spacing: 2px;">
            <img src="../../assets/images/logo.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-top me-2" style="border-radius: 50%; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            Kopaka Borrow
        </a>

        <div class="d-flex ms-auto align-items-center">
        <a href="../../pages/page_sites/home.php" class="btn btn-light me-3 fw-semibold shadow-sm" style="border-radius: 25px; transition: background 0.2s;">
            <i class="bi bi-house-door-fill me-2"></i>Accueil
        </a>
            <span class="me-3 text-white fw-light" style="font-size: 1.1rem;">
                <?php if(isset($_SESSION['nom'])) { ?> <p>Bienvenue,<strong><?php echo $_SESSION['nom'] ?> </strong></p> <?php } ?>
            </span>
            <a href="../../pages/page_sites/fiche_membres.php" class="btn btn-outline-light px-4 py-2 fw-semibold shadow-sm me-3" style="border-radius: 25px; transition: background 0.2s;">
                <i class="bi bi-person-lines-fill me-2"></i>Fiche membres
            </a>
            <a href="../../inc/deconnexion.php" class="btn btn-danger px-4 py-2 fw-semibold shadow-sm" style="border-radius: 25px; transition: background 0.2s;">
                <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
            </a>
        </div>
    </div>
</nav>
