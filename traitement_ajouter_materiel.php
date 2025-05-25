<?php
require_once 'connexion_bdd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_materiel = $_POST['id_materiel'];
    $ref_materiel = $_POST['ref_materiel'];
    $nom = $_POST['nom'];
    $categorie = $_POST['categorie'];
    $date_achat = $_POST['date_achat'];
    $etat = $_POST['etat'];
    $quantite = $_POST['quantité'];
    $descriptif = $_POST['descriptif'];

    if (isset($_FILES['image_url'])) {
        if ($_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../images/';
            $uploadFile = $uploadDir . basename($_FILES['image_url']['name']);

            if (move_uploaded_file($_FILES['image_url']['tmp_name'], $uploadFile)) {
                $image_urlPath = $uploadFile;

                $sql = "INSERT INTO materiel (id_materiel, ref_materiel, nom, image_url, categorie, date_achat, etat, quantite, descriptif)
                        VALUES (:id_materiel, :ref_materiel, :nom, :image_url, :categorie, :date_achat, :etat, :quantite, :descriptif)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':id_materiel' => $id_materiel,
                    ':ref_materiel' => $ref_materiel,
                    ':nom' => $nom,
                    ':image_url' => $image_urlPath,
                    ':categorie' => $categorie,
                    ':date_achat' => $date_achat,
                    ':etat' => $etat,
                    ':quantite' => $quantite,
                    ':descriptif' => $descriptif,
                ]);

                header("Location: catalogue_materiel.php");
                exit;
            } else {
                echo "Erreur lors de l'upload de l'image. Code erreur : " . $_FILES['image_url']['error'];
            }
        } else {
            echo "Erreur lors de l'upload de l'image. Code erreur : " . $_FILES['image_url']['error'];
        }
    } else {
        echo "Aucune image n'a été uploadée.";
    }
}
?>