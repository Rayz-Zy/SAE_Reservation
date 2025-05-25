<?php
require_once "connexion_bdd.php";

$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :id");
$stmt->execute(['id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "<div class='alert alert-danger m-5'>Utilisateur introuvable.</div>";
    exit;
}

$role = $user['role'] ?? null;
$role_info = null;

if ($role === 'etudiant') {
    $stmt = $pdo->prepare("SELECT * FROM etudiant WHERE id_utilisateur = :id");
    $stmt->execute(['id' => $id]);
    $role_info = $stmt->fetch(PDO::FETCH_ASSOC);
} elseif ($role === 'professeur') {
    $stmt = $pdo->prepare("SELECT * FROM professeur WHERE id_utilisateur = :id");
    $stmt->execute(['id' => $id]);
    $role_info = $stmt->fetch(PDO::FETCH_ASSOC);
} elseif ($role === 'agent') {
    $stmt = $pdo->prepare("SELECT * FROM agent WHERE id_utilisateur = :id");
    $stmt->execute(['id' => $id]);
    $role_info = $stmt->fetch(PDO::FETCH_ASSOC);
} elseif ($role === 'admin') {
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE id_utilisateur = :id");
    $stmt->execute(['id' => $id]);
    $role_info = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/navbar.css">
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

    <div class="container d-flex justify-content-center align-items-center" style="min-height:90vh;">
        <div class="card shadow-lg p-4" style="max-width: 500px; width:100%;">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Modifier le compte</h2>
                <form method="post" action="traitement_modifier_compte.php">
                    <input type="hidden" name="id" value="<?= $user['id_utilisateur'] ?>">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']); ?>" required>
                        </div>
                        <div class="col">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom']); ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="pseudo" class="form-label">Pseudo</label>
                            <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?= htmlspecialchars($user['pseudo']); ?>" required>
                        </div>
                        <div class="col">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="mdp" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="mdp" name="mdp" value="<?= htmlspecialchars($user['mot_de_passe']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" value="<?= htmlspecialchars($user['adresse']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="text" class="form-control" id="telephone" name="telephone" value="<?= htmlspecialchars($user['telephone']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="etat" class="form-label">État</label>
                        <select class="form-select" id="etat" name="etat">
                            <option value="actif" <?= $user['etat'] === 'valider' ? 'selected' : '' ?>>Valider</option>
                            <option value="inactif" <?= $user['etat'] === 'en attente' ? 'selected' : '' ?>>En attente</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Rôle</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="etudiant" <?= $role === 'etudiant' ? 'selected' : '' ?>>Étudiant</option>
                            <option value="professeur" <?= $role === 'professeur' ? 'selected' : '' ?>>Professeur</option>
                            <option value="agent" <?= $role === 'agent' ? 'selected' : '' ?>>Agent</option>
                            <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Administrateur</option>
                        </select>
                    </div>

                    <?php if ($role === 'etudiant' && $role_info): ?>
                        <h5 class="mt-4 mb-2">Informations Étudiant</h5>
                        <div class="mb-3">
                            <label for="num_etudiant" class="form-label">Numéro étudiant</label>
                            <input type="text" class="form-control" id="num_etudiant" name="num_etudiant" value="<?= htmlspecialchars($role_info['num_etudiant']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="date_naissance" class="form-label">Date de naissance</label>
                            <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="<?= htmlspecialchars($role_info['date_naissance']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="TD" class="form-label">TD</label>
                            <input type="text" class="form-control" id="TD" name="TD" value="<?= htmlspecialchars($role_info['TD']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="TP" class="form-label">TP</label>
                            <input type="text" class="form-control" id="TP" name="TP" value="<?= htmlspecialchars($role_info['TP']); ?>">
                        </div>
                    <?php elseif ($role === 'professeur' && $role_info): ?>
                        <h5 class="mt-4 mb-2">Informations Professeur</h5>
                        <div class="mb-3">
                            <label for="diplome" class="form-label">Diplôme</label>
                            <input type="text" class="form-control" id="diplome" name="diplome" value="<?= htmlspecialchars($role_info['diplome']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="qualification" class="form-label">Qualification</label>
                            <input type="text" class="form-control" id="qualification" name="qualification" value="<?= htmlspecialchars($role_info['qualification']); ?>">
                        </div>
                    <?php elseif ($role === 'agent' && $role_info): ?>
                        <h5 class="mt-4 mb-2">Informations Agent</h5>
                        <div class="mb-3">
                            <label for="qualification_agent" class="form-label">Qualification</label>
                            <input type="text" class="form-control" id="qualification_agent" name="qualification_agent" value="<?= htmlspecialchars($role_info['qualification']); ?>">
                        </div>
                    <?php elseif ($role === 'admin' && $role_info): ?>
                        <h5 class="mt-4 mb-2">Informations Administrateur</h5>
                        <div class="mb-3">
                            <label for="niveau" class="form-label">Niveau de droit</label>
                            <input type="text" class="form-control" id="niveau" name="niveau" value="<?= htmlspecialchars($role_info['niveau']); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <a href="gestion_compte.php" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>