<?php
session_start();
require_once "connexion_bdd.php";

if (
    isset($_POST['id_reservation'], $_POST['date_emprunt'], $_POST['heure_acces'], $_POST['heure_rendu'], $_POST['etat']) &&
    $_SESSION['role'] === 'admin'
) {
    $id = intval($_POST['id_reservation']);
    $date = $_POST['date_emprunt'];
    $heure_acces = $_POST['heure_acces'];
    $heure_rendu = $_POST['heure_rendu'];
    $etat = $_POST['etat'];
    $etats_valides = ['en attente', 'valider', 'annuler'];
    if (in_array($etat, $etats_valides)) {
        $stmt = $pdo->prepare("UPDATE reservation SET date_emprunt = ?, heure_acces = ?, heure_rendu = ?, etat = ? WHERE id_reservation = ?");
        $stmt->execute([$date, $heure_acces, $heure_rendu, $etat, $id]);
    }
}
header('Location: afficher_reservation.php');
exit;