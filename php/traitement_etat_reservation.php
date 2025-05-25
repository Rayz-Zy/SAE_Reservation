<?php
require_once "connexion_bdd.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idReservation = intval($_POST["id_reservation"]);
    $action = $_POST["action"];

    if ($action === "valider") {
        $nouvelEtat = "valider";
    } elseif ($action === "refuser") {
        $nouvelEtat = "refuser";
    }

    try {
        $sql = "UPDATE reservation SET etat = :etat WHERE id_reservation = :id_reservation";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":etat" => $nouvelEtat,
            ":id_reservation" => $idReservation
        ]);

        echo "<p style='color: green;'>L'état de la reservation a été mis à jour avec succès.</p>";
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour de l'état : " . $e->getMessage());
    }
}
header("Location: afficher_reservation.php");
exit;
?>