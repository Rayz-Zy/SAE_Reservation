<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="fond">
    <form class="form-inscription" action="traitement_ajouter_utilisateur.php" method="POST">
        <h2 class="text-center mb-4">Inscription</h2>
        <div class="mb-3">
            <input type="text" id="pseudo" name="pseudo" class="form-control" placeholder="Pseudo" required>
        </div>
        <div class="mb-3">
            <input type="text" id="nom" name="nom" class="form-control" placeholder="Nom" required>
        </div>
        <div class="mb-3">
            <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Prénom" required>
        </div>
        <div class="mb-3">
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <label for="naissance" class="form-label mt-2">Date de naissance</label>
        <input type="date" id="naissance" name="naissance" class="form-control" required>
        <label for="naissance" class="form-label mt-2">Telephone</label>
        <input type="int" name="tel" id="tel" class="form-control" required>

        <label for="role" class="form-label mt-2">Sélectionner votre rôle</label>
        <select id="role" name="role" class="form-select" required>
            <option value="">- Aucun -</option>
            <option value="etudiant">Étudiant</option>
            <option value="enseignant">Enseignant</option>
            <option value="admin">Administrateur</option>
            <option value="agent">Agent</option>
        </select>

        <div id="student" class="role">
            <div class="row">
                <div class="col">
                    <input type="text" name="num_etudiant" id="num_etudiant" class="form-control" placeholder="Numéro étudiant">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <input type="text" name="TD" id="TD" class="form-control" placeholder="Groupe de TD">
                </div>
                <div class="col">
                    <input type="text" name="TP" id="TP" class="form-control" placeholder="Groupe de TP">
                </div>
            </div>
        </div>

        <div id="professeur" class="role">
            <input type="text" name="diplome" id="diplome" class="form-control" placeholder="Diplome">
            <input type="text" name="qualif" id="qualif" class="form-control" placeholder="Qualification">
        </div>

        <div id="agent" class="role">
            <input type="text" name="qualif_agent" id="qualif_agent" class="form-control" placeholder="Qualifiaction">
        </div>

        <div id="admin" class="role">
            <input type="text" name="niveau" id="niveau" class="form-control" placeholder="Niveau de droit">
        </div>
        <input type="text" id="adresse" name="adresse" class="form-control" placeholder="Adresse" required>
        <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control" placeholder="Mot de passe" required minlength="6">

        <button type="submit" class="btn btn-primary mt-3">S'inscrire</button>
    </form>
    <script src="../js/inscription.js"></script>
    
</body>
</html>