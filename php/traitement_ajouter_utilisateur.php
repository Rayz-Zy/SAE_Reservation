<?php

require_once "connexion_bdd.php";

$pseudo = $_POST['pseudo'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$naissance = $_POST['naissance'];
$role = $_POST['role'];
$adresse = $_POST['adresse'];
$tel = $_POST['tel']; 
$mot_de_passe = $_POST['mot_de_passe'];

$mot_de_passe = $_POST['mot_de_passe'];
$mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO utilisateur (nom, prenom, pseudo, email, mot_de_passe, adresse, telephone, etat, role) VALUES (:nom, :prenom, :pseudo, :email, :mot_de_passe, :adresse, :telephone, 'en attente', :role)");
$stmt->execute([
    ":nom" => $nom,
    ":prenom" => $prenom,
    ":pseudo" => $pseudo,
    ":email" => $email,
    ":mot_de_passe" => $mot_de_passe_hash,
    ":adresse" => $adresse,
    ":telephone" => $tel,
    ":role" => $role,
]);

$id_utilisateur = $pdo->lastInsertId();

if ($role === 'etudiant') {
    $num_etudiant = $_POST['num_etudiant'];
    $TD = $_POST['TD'];
    $TP = $_POST['TP'];
    $stmt = $pdo->prepare("INSERT INTO etudiant (id_utilisateur, num_etudiant, date_naissance, TD, TP) VALUES (:id_utilisateur, :num_etudiant, :date_naissance, :TD, :TP)");
    $stmt->execute([
        ":id_utilisateur" => $id_utilisateur,
        ":num_etudiant" => $num_etudiant,
        ":date_naissance" => $naissance,
        ":TD" => $TD,
        ":TP" => $TP,
    ]);
} elseif ($role === 'professeur') {
    $diplome = $_POST['diplome'];
    $qualif = $_POST['qualif'];
    $stmt = $pdo->prepare("INSERT INTO professeur (id_utilisateur, diplome, qualification) VALUES (:id_utilisateur, :diplome, :qualification)");
    $stmt->execute([
        ":id_utilisateur" => $id_utilisateur,
        ":diplome" => $diplome,
        ":qualification" => $qualif,
    ]);
} elseif ($role === 'agent') {
    $qualif_agent = $_POST['qualif_agent'];
    $stmt = $pdo->prepare("INSERT INTO agent (id_utilisateur, qualification) VALUES (:id_utilisateur, :qualification)");
    $stmt->execute([
        ":id_utilisateur" => $id_utilisateur,
        ":qualification" => $qualif_agent,
    ]);
} elseif ($role === 'admin') {
    $niveau = $_POST['niveau'];
    $stmt = $pdo->prepare("INSERT INTO admin (id_utilisateur, niveau) VALUES (:id_utilisateur, :niveau)");
    $stmt->execute([
        ":id_utilisateur" => $id_utilisateur,
        ":niveau" => $niveau,
    ]);
}

header('Location: connexion.php?success=1');
exit;