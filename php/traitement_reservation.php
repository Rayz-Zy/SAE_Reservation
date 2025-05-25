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
                    $query = "INSERT INTO salle_emprunt (id_reservation, id_salle) VALUES (:id_reservation, :id_salle)";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([
                        'id_reservation' => $id_reservation,
                        'id_salle' => $item_id
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
?>