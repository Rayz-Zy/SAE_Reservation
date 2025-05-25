<?php
session_start();
include 'connexion_bdd.php';
include 'panier.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p>Vous devez être connecté pour accéder à cette page.</p>";
    header("Location: connexion.php");
    exit;
}

if (isset($_POST['add_panier'])) {
    $quantite = isset($_POST['quantite']) ? intval($_POST['quantite']) : 1;
    ajouterAuPanier($_POST['item_id'], $_POST['item_type'], $quantite);
}

if (isset($_POST['remove_from_panier'])) {
    supprimerDuPanier($_POST['item_id'], $_POST['item_type']);
}

$parPage = 6;
$page = isset($_GET['page_materiel']) && is_numeric($_GET['page_materiel']) && $_GET['page_materiel'] > 0 ? (int)$_GET['page_materiel'] : 1;
$offset = ($page - 1) * $parPage;

$categories = $pdo->query("SELECT DISTINCT categorie FROM materiel")->fetchAll(PDO::FETCH_COLUMN);
$categorie = isset($_GET['categorie']) && $_GET['categorie'] !== '' ? $_GET['categorie'] : null;

if ($categorie) {
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM materiel WHERE categorie = :cat");
    $countStmt->execute(['cat' => $categorie]);
    $totalMateriel = $countStmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT id_materiel AS id, nom FROM materiel WHERE categorie = :cat LIMIT :offset, :parpage");
    $stmt->bindValue(':cat', $categorie, PDO::PARAM_STR);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':parpage', $parPage, PDO::PARAM_INT);
    $stmt->execute();
} else {
    $totalMateriel = $pdo->query("SELECT COUNT(*) FROM materiel")->fetchColumn();
    $stmt = $pdo->prepare("SELECT id_materiel AS id, nom FROM materiel LIMIT :offset, :parpage");
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':parpage', $parPage, PDO::PARAM_INT);
    $stmt->execute();
}
$nbPages = ceil($totalMateriel / $parPage);

$parPageSalle = 6;
$pageSalle = isset($_GET['page_salle']) && is_numeric($_GET['page_salle']) && $_GET['page_salle'] > 0 ? (int)$_GET['page_salle'] : 1;
$offsetSalle = ($pageSalle - 1) * $parPageSalle;

$equipements = $pdo->query("SELECT DISTINCT equipement FROM (SELECT equipement1 AS equipement FROM salle UNION SELECT equipement2 FROM salle UNION SELECT equipement3 FROM salle) AS all_equipements 
    WHERE equipement IS NOT NULL AND equipement != ''")->fetchAll(PDO::FETCH_COLUMN);

$equipement = isset($_GET['equipement']) && $_GET['equipement'] !== '' ? $_GET['equipement'] : null;
$equipement1 = isset($equipements[0]);
$equipement2 = isset($equipements[1]);
$equipement3 = isset($equipements[2]);


if ($equipement) {
    $countStmtSalle = $pdo->prepare("SELECT COUNT(*) FROM salle WHERE equipement1 = :eq OR equipement2 = :eq OR equipement3 = :eq");
    $countStmtSalle->execute(['eq' => $equipement]);
    $totalSalle = $countStmtSalle->fetchColumn();

    $stmtSalle = $pdo->prepare("SELECT id_salle AS id, nom, equipement1, equipement2, equipement3 FROM salle WHERE equipement1 = :eq OR equipement2 = :eq OR equipement3 = :eq LIMIT :offset, :parpage");
    $stmtSalle->bindValue(':eq', $equipement, PDO::PARAM_STR);
    $stmtSalle->bindValue(':offset', $offsetSalle, PDO::PARAM_INT);
    $stmtSalle->bindValue(':parpage', $parPageSalle, PDO::PARAM_INT);
    $stmtSalle->execute();
} else {
    $totalSalle = $pdo->query("SELECT COUNT(*) FROM salle")->fetchColumn();
    $stmtSalle = $pdo->prepare("SELECT id_salle AS id, nom, equipement1, equipement2, equipement3 FROM salle LIMIT :offset, :parpage");
    $stmtSalle->bindValue(':offset', $offsetSalle, PDO::PARAM_INT);
    $stmtSalle->bindValue(':parpage', $parPageSalle, PDO::PARAM_INT);
    $stmtSalle->execute();
}

$nbPagesSalle = ceil($totalSalle / $parPageSalle);