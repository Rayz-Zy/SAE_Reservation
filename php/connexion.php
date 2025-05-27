<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="fond">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
            <?php if (isset($_GET['erreur']) && $_GET['erreur'] == 1): ?>
    <div class="alert alert-danger text-center">
        Pseudo ou mot de passe incorrect.
    </div>
<?php elseif (isset($_GET['erreur']) && $_GET['erreur'] == 2): ?>
    <div class="alert alert-danger text-center">
        Erreur de connexion à la base de données.
    </div>
<?php elseif (isset($_GET['erreur']) && $_GET['erreur'] == 3): ?>
    <div class="alert alert-warning text-center">
        Veuillez remplir tous les champs.
    </div>
<?php endif; ?>

<?php if (isset($_GET['etat']) && $_GET['etat'] === 'attente'): ?>
    <div class="alert alert-warning text-center">
        Votre compte est en attente de validation par un administrateur.
    </div>
<?php endif; ?>
            <h2 class="mb-4 text-center">Connexion</h2>
            <form action="verification_connexion.php" method="POST">
                <div class="mb-3">
                    <label for="pseudo" class="form-label">Pseudo :</label>
                    <input type="text" id="pseudo" name="pseudo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="mot_de_passe" class="form-label">Mot de passe :</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>
            <div class="text-center mt-3">
                <span>Pas de compte ?</span>
                <a href="inscription.php" class="link-primary">Créer un compte</a>
            </div>
        </div>
    </div>
</body>
</html>