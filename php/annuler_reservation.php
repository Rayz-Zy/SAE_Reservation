<?php
session_start();
require_once "connexion_bdd.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

if (isset($_POST['id_reservation'])) {
    $id_reservation = intval($_POST['id_reservation']);
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT * FROM reservation WHERE id_reservation = ? AND id_user = ?");
    $stmt->execute([$id_reservation, $user_id]);
    $reservation = $stmt->fetch();

    if ($reservation && ($reservation['etat'] == 'en attente' || $reservation['etat'] == 'valide')) {
        $update = $pdo->prepare("UPDATE reservation SET etat = 'annulée' WHERE id_reservation = ?");
        $update->execute([$id_reservation]);
        header("Location: vos_reservation.php?msg=annulee");
        exit;
    } else {
        header("Location: vos_reservation.php?msg=erreur");
        exit;
    }
} else {
    header("Location: vos_reservation.php");
    exit;
}