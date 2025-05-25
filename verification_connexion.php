<?php
session_start();
require_once "connexion_bdd.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = htmlspecialchars($_POST["pseudo"]);
    $motdepasse = htmlspecialchars($_POST["mot_de_passe"]);

    if (!empty($pseudo) && !empty($motdepasse)) {
        try {
            $sql = "SELECT * FROM utilisateur WHERE pseudo = :pseudo";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([":pseudo" => $pseudo]);
            $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($utilisateur) {
                if (
                    password_verify($motdepasse, $utilisateur["mot_de_passe"]) &&
                    $utilisateur["etat"] === "valider"
                ) {
                    $_SESSION["user_id"] = $utilisateur["id_utilisateur"];
                    $_SESSION["pseudo"] = $utilisateur["pseudo"];
                    $_SESSION["role"] = $utilisateur["role"];

                    header("Location: index.php");
                    exit;
                } elseif ($utilisateur["etat"] === "en attente") {
                    header("Location: connexion.php?etat=attente");
                    exit;
                } else {
                    header("Location: connexion.php?erreur=1");
                    exit;
                }
            } else {
                header("Location: connexion.php?erreur=1");
                exit;
            }
        } catch (PDOException $e) {
            header("Location: connexion.php?erreur=2");
            exit;
        }
    } else {
        header("Location: connexion.php?erreur=3");
        exit;
    }
}