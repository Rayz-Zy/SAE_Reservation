<?php
require_once "connexion_bdd.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    $etat = $_POST['etat'];
    $role = $_POST['role'];

    $stmt = $pdo->prepare("UPDATE utilisateur SET nom = :nom, prenom = :prenom, pseudo = :pseudo, email = :email, mot_de_passe = :mdp, adresse = :adresse, telephone = :telephone, etat = :etat, role = :role WHERE id_utilisateur = :id");
    $stmt->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'pseudo' => $pseudo,
        'email' => $email,
        'mdp' => $mdp,
        'adresse' => $adresse,
        'telephone' => $telephone,
        'etat' => $etat,
        'role' => $role,
        'id' => $id
    ]);
    
    if ($role === 'etudiant') {
        $num_etudiant = $_POST['num_etudiant'];
        $date_naissance = $_POST['date_naissance'];
        $TD = $_POST['TD'];
        $TP = $_POST['TP'];
        $stmt = $pdo->prepare("UPDATE etudiant SET num_etudiant = :num_etudiant, date_naissance = :date_naissance, TD = :TD, TP = :TP WHERE id_utilisateur = :id");
        $stmt->execute([
            'num_etudiant' => $num_etudiant,
            'date_naissance' => $date_naissance,
            'TD' => $TD,
            'TP' => $TP,
            'id' => $id
        ]);
    } elseif ($role === 'professeur') {
        $diplome = $_POST['diplome'];
        $qualification = $_POST['qualification'];
        $stmt = $pdo->prepare("UPDATE professeur SET diplome = :diplome, qualification = :qualification WHERE id_utilisateur = :id");
        $stmt->execute([
            'diplome' => $diplome,
            'qualification' => $qualification,
            'id' => $id
        ]);
    } elseif ($role === 'agent') {
        $qualification = $_POST['qualification_agent'];
        $stmt = $pdo->prepare("UPDATE agent SET qualification = :qualification WHERE id_utilisateur = :id");
        $stmt->execute([
            'qualification' => $qualification,
            'id' => $id
        ]);
    } elseif ($role === 'admin') {
        $niveau = $_POST['niveau'];
        $stmt = $pdo->prepare("UPDATE admin SET niveau = :niveau WHERE id_utilisateur = :id");
        $stmt->execute([
            'niveau' => $niveau,
            'id' => $id
        ]);
    }
    if($role ==='admin'){
        header("Location: gestion_compte.php?success=1");
        exit;
    } else {
        header("Location: profil.php?success=1");
        exit;
    }
} else {
    echo "<div class='alert alert-danger m-5'>Méthode non autorisée.</div>";
}
?>