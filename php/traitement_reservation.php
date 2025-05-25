<?php
session_start();
include 'connexion_bdd.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p>Vous devez être connecté pour accéder à cette page.</p>";
    header("Location: connexion.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['user_id'];
    $date_emprunt = $_POST['date_emprunt'];
    $heure_acces = $_POST['heure_acces'];
    $heure_rendu = $_POST['heure_rendu'];
    $commentaire = $_POST['commentaire'];
    $etat = 'en attente';

    if ($date_emprunt && $heure_acces && $heure_rendu && $commentaire) {

        $salleOccupee = false;
        $salleNom = '';
        if (!empty($_POST['panier_type'])) {
            foreach ($_POST['panier_type'] as $i => $type) {
                if ($type == 'salle') {
                    $item_id = $_POST['panier_id'][$i];
                    $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM reservation r JOIN salle_emprunt se ON r.id_reservation = se.id_reservation WHERE se.id_salle = :id_salle
                          AND r.date_emprunt = :date_emprunt AND ((r.heure_acces < :heure_rendu AND r.heure_rendu > :heure_acces)) AND r.etat != 'annulée'");
                    $stmtCheck->execute([
                        'id_salle' => $item_id,
                        'date_emprunt' => $date_emprunt,
                        'heure_acces' => $heure_acces,
                        'heure_rendu' => $heure_rendu
                    ]);
                    $alreadyReserved = $stmtCheck->fetchColumn();
                    if ($alreadyReserved > 0) {
                        $stmtNom = $pdo->prepare("SELECT nom FROM salle WHERE id_salle = :id_salle");
                        $stmtNom->execute(['id_salle' => $item_id]);
                        $salleNom = $stmtNom->fetchColumn();
                        $salleOccupee = true;
                        break;
                    }
                }
            }
        }

        if ($salleOccupee) {
            echo "<p>La salle <b>" . htmlspecialchars($salleNom) . "</b> est déjà réservée pour cette période.</p>";
            echo '<a href="reservation.php">Retour</a>';
            exit;
        }

        $query = "INSERT INTO reservation (id_user, date_emprunt, heure_acces, heure_rendu, commentaire, etat) VALUES (:id_user, :date_emprunt, :heure_acces, :heure_rendu, :commentaire, :etat)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'id_user' => $id_user,
            'date_emprunt' => $date_emprunt,
            'heure_acces' => $heure_acces,
            'heure_rendu' => $heure_rendu,
            'commentaire' => $commentaire,
            'etat' => 'en attente'
        ]);
        $id_reservation = $pdo->lastInsertId();

        if (!empty($_POST['panier_type'])) {
            foreach ($_POST['panier_type'] as $i => $type) {
                $item_id = $_POST['panier_id'][$i];
                $quantite = isset($_POST['panier_quantite'][$i]) ? intval($_POST['panier_quantite'][$i]) : 1;

                if ($type == 'salle') {
                    $stmtEquip = $pdo->prepare("SELECT equipement1, equipement2, equipement3 FROM salle WHERE id_salle = :id_salle");
                    $stmtEquip->execute(['id_salle' => $item_id]);
                    $equip = $stmtEquip->fetch(PDO::FETCH_ASSOC);

                    $query = "INSERT INTO salle_emprunt (id_reservation, id_salle, equipement1, equipement2, equipement3) VALUES (:id_reservation, :id_salle, :equipement1, :equipement2, :equipement3)";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([
                        'id_reservation' => $id_reservation,
                        'id_salle' => $item_id,
                        'equipement1' => $equip['equipement1'],
                        'equipement2' => $equip['equipement2'],
                        'equipement3' => $equip['equipement3']
                    ]);
                } else if ($type == 'materiel') {
                    $query = "INSERT INTO materiel_emprunt (id_reservation, id_materiel, quantite) VALUES (:id_reservation, :id_materiel, :quantite)";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([
                        'id_reservation' => $id_reservation,
                        'id_materiel' => $item_id,
                        'quantite' => $quantite
                    ]);
                }
            }
        }

        $_SESSION['panier'] = [];

        echo "<p>Réservation enregistrée avec succès !</p>";
        echo '<a href="reservation.php">Retour</a>';
    } else {
        echo "<p>Veuillez remplir tous les champs.</p>";
    }
} else {
    echo "<p>Méthode non autorisée.</p>";
}