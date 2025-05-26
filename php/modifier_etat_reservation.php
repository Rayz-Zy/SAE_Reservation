<?php
session_start();
require_once "connexion_bdd.php";

if (
    isset($_POST['id_reservation'], $_POST['nouvel_etat']) &&
    $_SESSION['role'] === 'admin'
) {
    $id = intval($_POST['id_reservation']);
    $etat = $_POST['nouvel_etat'];
    $etats_valides = ['en attente', 'valider', 'annuler'];
    if (in_array($etat, $etats_valides)) {
        $stmt = $pdo->prepare("UPDATE reservation SET etat = ? WHERE id_reservation = ?");
        $stmt->execute([$etat, $id]);
    }
}
header('Location: afficher_reservation.php');
exit;