<?php
session_start();
require_once 'connexion_bdd.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un matériel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg" style="background-color: #1B263B;">
    <div class="container-fluid">
      <a class="navbar-brand text-light d-flex align-items-center gap-2" href="index.php" style="font-weight:bold;">
        <i class="bi bi-house-door-fill me-2"></i>
        SAE <span style="color:#ffe082;">Réservation</span>
      </a>
      <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav mb-2 mb-lg-0 gap-lg-2" style="margin-left: 30px;">
          <li class="nav-item">
            <a class="nav-link" href="index.php" style="color:#fff;">
              <i class="bi bi-house-door"></i> Accueil
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="reservation.php" style="color:#fff;">
              <i class="bi bi-calendar2-plus"></i> Réservation
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="catalogue_materiel.php" style="color:#fff;">
              <i class="bi bi-box-seam"></i> Catalogue matériel
            </a>
          </li>
        </ul>
        <div class="ms-auto d-flex align-items-center">
          <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="img/profil.png" alt="Profil" width="40" height="40" class="rounded-circle border border-light me-2">
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="profil.php"><i class="bi bi-person"></i> Profil</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="traitement_deconnexion.php"><i class="bi bi-box-arrow-right"></i> Déconnexion</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow">
          <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Ajouter un matériel</h4>
          </div>
          <div class="card-body">
            <form action="traitement_ajouter_materiel.php" method="POST" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="id_materiel" class="form-label">Id</label>
                <input type="number" class="form-control" id="id_materiel" name="id_materiel" required>
              </div>
              <div class="mb-3">
                <label for="ref_materiel" class="form-label">Référence</label>
                <input type="text" class="form-control" id="ref_materiel" name="ref_materiel" required>
              </div>
              <div class="mb-3">
                <label for="nom" class="form-label">Désignation</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
              </div>
              <div class="mb-3">
                <label for="image_url" class="form-label">Photo</label>
                <input type="file" class="form-control" id="image_url" name="image_url" accept="images/*" required>
              </div>
              <div class="mb-3">
                <label for="categorie" class="form-label">Type</label>
                <select id="categorie" name="categorie" class="form-select" required>
                  <option value="camera">Caméra</option>
                  <option value="trepied">Trépied</option>
                  <option value="micro">Micro</option>
                  <option value="ecran">Écran</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="date_achat" class="form-label">Date d'achat</label>
                <input type="date" class="form-control" id="date_achat" name="date_achat" required>
              </div>
              <div class="mb-3">
                <label for="etat" class="form-label">État</label>
                <select id="etat" name="etat" class="form-select" required>
                  <option value="neuf">Neuf</option>
                  <option value="bon">Bon état</option>
                  <option value="moyen">Moyen état</option>
                  <option value="mauvais">Mauvais état</option>
                  <option value="HS">Hors service</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="quantité" class="form-label">Quantité</label>
                <div class="input-group" style="max-width: 200px;">
                  <button type="button" class="btn btn-outline-secondary" onclick="Moins()">-</button>
                  <input type="number" class="form-control text-center" id="quantité" name="quantité" value="1" min="1" required>
                  <button type="button" class="btn btn-outline-secondary" onclick="Plus()">+</button>
                </div>
              </div>
              <div class="mb-3">
                <label for="descriptif" class="form-label">Descriptif</label>
                <textarea id="descriptif" name="descriptif" class="form-control" rows="3" required></textarea>
              </div>
              <div class="text-end">
                <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Envoyer</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function Plus() {
      const quantityInput = document.getElementById('quantité');
      quantityInput.value = parseInt(quantityInput.value) + 1;
    }
    function Moins() {
      const quantityInput = document.getElementById('quantité');
      if (parseInt(quantityInput.value) > 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
      }
    }
  </script>
    
</body>
</html>