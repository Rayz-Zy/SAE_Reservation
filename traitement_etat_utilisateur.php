<?php
require_once "connexion_bdd.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idUtilisateur = intval($_POST["id_utilisateur"]);
    $action = $_POST["action"];

    if ($action === "valider") {
        $nouvelEtat = "valider";
    } elseif ($action === "refuser") {
        $nouvelEtat = "refuser";
    }

    try {
        $sql = "UPDATE utilisateur SET etat = :etat WHERE id_utilisateur = :id_utilisateur";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":etat" => $nouvelEtat,
            ":id_utilisateur" => $idUtilisateur
        ]);

        echo "<p style='color: green;'>L'état de l'utilisateur a été mis à jour avec succès.</p>";
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour de l'état : " . $e->getMessage());
    }
}
header("Location: demande_connexion.php");
exit;
?>