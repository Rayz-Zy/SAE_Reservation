<?php
session_start();
include 'connexion_bdd.php';

if (
    isset($_POST['id_salle'], $_POST['date_emprunt'], $_POST['heure_acces'], $_POST['heure_rendu'])
) {
    $id_salle = $_POST['id_salle'];
    $date_emprunt = $_POST['date_emprunt'];
    $heure_acces = $_POST['heure_acces'];
    $heure_rendu = $_POST['heure_rendu'];

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM reservation r JOIN salle_emprunt se ON r.id_reservation = se.id_reservation WHERE se.id_salle = :id_salle
          AND r.date_emprunt = :date_emprunt AND ((r.heure_acces < :heure_rendu AND r.heure_rendu > :heure_acces))AND r.etat != 'annulée'");
    $stmt->execute([
        'id_salle' => $id_salle,
        'date_emprunt' => $date_emprunt,
        'heure_acces' => $heure_acces,
        'heure_rendu' => $heure_rendu
    ]);
    $alreadyReserved = $stmt->fetchColumn();
    echo $alreadyReserved > 0 ? 'occupee' : 'disponible';
}