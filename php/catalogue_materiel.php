<?php
session_start();
require_once "connexion_bdd.php";
if (!isset($_SESSION['user_id'])) {
    echo "<p>Vous devez être connecté pour accéder à cette page.</p>";
    header("Location: connexion.php");
    exit;
}

$parPage = 12;
$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $parPage;

$categories = $pdo->query("SELECT DISTINCT categorie FROM materiel")->fetchAll(PDO::FETCH_COLUMN);

$categorie = isset($_GET['categorie']) && $_GET['categorie'] !== '' ? $_GET['categorie'] : null;

if ($categorie) {
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM materiel WHERE categorie = :cat");
    $countStmt->execute(['cat' => $categorie]);
    $total = $countStmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM materiel WHERE categorie = :cat LIMIT :offset, :parpage");
    $stmt->bindValue(':cat', $categorie, PDO::PARAM_STR);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':parpage', $parPage, PDO::PARAM_INT);
    $stmt->execute();
    $materiels = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $total = $pdo->query("SELECT COUNT(*) FROM materiel")->fetchColumn();
    $stmt = $pdo->prepare("SELECT * FROM materiel LIMIT :offset, :parpage");
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':parpage', $parPage, PDO::PARAM_INT);
    $stmt->execute();
    $materiels = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$nbPages = ceil($total / $parPage);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Catalogue du matériel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/navbar.css">
  <link rel="stylesheet" href="../css/catalogue.css">
</head>
<body class="bg-light">
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

  <div class="container py-4">
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <div class="mb-4 text-center">
        <a href="ajout_materiel.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Ajouter du matériel</a>
    </div>
    <?php endif; ?>

    <h1 class="mb-4 text-center">Catalogue du matériel</h1>
    <form method="get" class="catalogue-filter">
      <div class="input-group">
        <label class="input-group-text" for="categorie">Catégorie</label>
        <select name="categorie" id="categorie" class="form-select" onchange="this.form.submit()">
          <option value="">Toutes</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>" <?= $cat == $categorie ? 'selected' : '' ?>>
              <?= htmlspecialchars(ucfirst($cat)) ?>
            </option>
          <?php endforeach; ?>
        </select>
        <!-- On ne garde le champ page que si on ne change pas de catégorie -->
        <?php if ($page > 1 && isset($_GET['categorie']) && $_GET['categorie'] === $categorie): ?>
          <input type="hidden" name="page" value="<?= $page ?>">
        <?php endif; ?>
      </div>
    </form>
    <div class="catalogue">
      <?php foreach ($materiels as $row): 
        $img = !empty($row['image_url']) ? $row['image_url'] : '../img/default_materiel.png';
      ?>
      <div class="card materiel-card"
           data-nom="<?= htmlspecialchars($row['nom']) ?>"
           data-categorie="<?= htmlspecialchars($row['categorie']) ?>"
           data-description="<?= htmlspecialchars($row['descriptif'] ?? 'Aucune description') ?>"
           data-quantite="<?= htmlspecialchars($row['quantite']) ?>"
           data-img="<?= htmlspecialchars($img) ?>"
           data-date="<?= htmlspecialchars($row['date_achat']) ?>"
           data-ref="<?= htmlspecialchars($row['ref_materiel']) ?>"
           style="cursor:pointer;">
        <div class="img-container">
          <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($row['nom']) ?>">
        </div>
        <div class="nom"><?= htmlspecialchars($row['nom']) ?></div>
      </div>
      <?php endforeach; ?>
      <?php if (empty($materiels)): ?>
        <div class="text-muted mt-4">Aucun matériel trouvé pour cette catégorie.</div>
      <?php endif; ?>
    </div>
    <?php if ($nbPages > 1): ?>
    <nav class="pagination">
        <?php
        $params = $_GET;
        for ($i = 1; $i <= $nbPages; $i++):
            $params['page'] = $i;
            $link = '?' . http_build_query($params);
        ?>
            <a class="btn btn-outline-primary<?= $i == $page ? ' active' : '' ?>" href="<?= $link ?>"><?= $i ?></a>
        <?php endfor; ?>
    </nav>
    <?php endif; ?>
  </div>

  <div class="modal fade" id="materiel_element" tabindex="-1" aria-labelledby="materiel_nom" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="materiel_nom"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <img id="materiel_img" src="" alt="" class="img-fluid mb-3" style="max-height:200px;">
          <p><strong>Référence :</strong> <span id="materiel_ref"></span></p>
          <p><strong>Catégorie :</strong> <span id="materiel_categorie"></span></p>
          <p><strong>Date d'achat :</strong> <span id="materiel_date"></span></p>
          <p><strong>Description :</strong> <span id="materiel_description"></span></p>
          <p><strong>Quantité disponible :</strong> <span id="materiel_quantite"></span></p>
        </div>
      </div>
    </div>
  </div>
  <script src="../js/catalogue.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>