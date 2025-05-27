<?php
require_once 'connexion_bdd.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $dateEmprunt = $_POST['date_emprunt'];
    $heureAcces = $_POST['heure_acces'];
    $heureRendu = $_POST['heure_rendu'];

    $query = "SELECT * FROM reservations WHERE date_emprunt = :date_emprunt AND ((heure_acces <= :heure_rendu AND heure_rendu >= :heure_acces))";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':date_emprunt', $dateEmprunt);
    $stmt->bindParam(':heure_acces', $heureAcces);
    $stmt->bindParam(':heure_rendu', $heureRendu);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo 'indisponible';
    } else {
        echo 'disponible';
    }

} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
}
?>
