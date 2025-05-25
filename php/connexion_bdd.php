<?php
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$bdd = "sae_siteweb";

try {
    $pdo = new PDO("mysql:host=$serveur; dbname=$bdd; charset=utf8", $utilisateur, $motdepasse);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die ("Erreur de connexion". $e->getMessage());
}
?>