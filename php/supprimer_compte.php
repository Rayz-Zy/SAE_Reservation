<?php
require_once "connexion_bdd.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: gestion_compte.php");
    exit;
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :id");
$stmt->execute(['id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "<div class='alert alert-danger m-5'>Utilisateur introuvable.</div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :id");
    $stmt->execute(['id' => $id]);
    header("Location: gestion_compte.php?suppr=ok");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center" style="min-height:90vh;">
    <div class="card shadow-lg p-4" style="max-width: 400px; width:100%;">
        <div class="card-body text-center">
            <h2 class="mb-4 text-danger">Supprimer le compte</h2>
            <p>Voulez-vous vraiment supprimer le compte de <strong><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></strong> ?</p>
            <form method="post">
                <button type="submit" class="btn btn-danger">Oui, supprimer</button>
                <a href="gestion_compte.php" class="btn btn-secondary ms-2">Annuler</a>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>