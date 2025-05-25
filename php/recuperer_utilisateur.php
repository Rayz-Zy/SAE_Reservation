<?php
function recuperer_donnees($pdo, $user_id) {
    try {
 
        $sql = "SELECT * FROM utilisateur WHERE id_utilisateur = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $user_id]);
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$utilisateur) {
            return null; 
        }

        $sql_etudiant = "SELECT * FROM etudiant WHERE id_utilisateur = :id";
        $stmt_etudiant = $pdo->prepare($sql_etudiant);
        $stmt_etudiant->execute([':id' => $user_id]);
        $etudiant = $stmt_etudiant->fetch(PDO::FETCH_ASSOC);

        $sql_professeur = "SELECT * FROM professeur WHERE id_utilisateur = :id";
        $stmt_professeur = $pdo->prepare($sql_professeur);
        $stmt_professeur->execute([':id' => $user_id]);
        $professeur = $stmt_professeur->fetch(PDO::FETCH_ASSOC);

        if ($etudiant) {
            $utilisateur = array_merge($utilisateur, $etudiant);
        } elseif ($professeur) {
            $utilisateur = array_merge($utilisateur, $professeur);
        }

        return $utilisateur;
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>