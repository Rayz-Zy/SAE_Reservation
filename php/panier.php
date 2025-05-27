<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function ajouterAuPanier($item_id, $item_type, $quantite = 1) {
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    $_SESSION['panier'][] = [
        'id' => $item_id,
        'type' => $item_type,
        'quantite' => $quantite 
    ];
}
function supprimerDuPanier($item_id, $item_type) {
    foreach ($_SESSION['panier'] as $key => $item) {
        if ($item['id'] == $item_id && $item['type'] == $item_type) {
            unset($_SESSION['panier'][$key]);
            break;
        }
    }

    $_SESSION['panier'] = array_values($_SESSION['panier']);
}

function afficherPanier($pdo) {
    if (empty($_SESSION['panier'])) {
        echo '<div class="alert alert-info mb-0"><i class="bi bi-info-circle"></i> Votre panier est vide.</div>';
        return;
    }

    echo '<div class="table-responsive">';
    echo '<table class="table align-middle table-hover">';
    echo '<thead class="table-light"><tr>
            <th>Type</th>
            <th>Nom</th>
            <th>Quantité</th>
            <th>Action</th>
          </tr></thead><tbody>';
    foreach ($_SESSION['panier'] as $item) {
        $id = $item['id'];
        $type = $item['type'];
        $quantite = isset($item['quantite']) ? intval($item['quantite']) : 1;

        if ($type == 'salle') {
            $query = "SELECT nom FROM salle WHERE id_salle = :id";
        } else {
            $query = "SELECT nom FROM materiel WHERE id_materiel = :id";
        }

        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        echo '<tr>';
        echo '<td>' . ($type === 'salle' ? '<i class="bi bi-door-open"></i> Salle' : '<i class="bi bi-box-seam"></i> Matériel') . '</td>';
        echo '<td>' . htmlspecialchars($data['nom']) . '</td>';
        echo '<td>' . $quantite . '</td>';
        echo '<td>
                <form method="post" class="d-inline">
                    <input type="hidden" name="item_id" value="' . $id . '">
                    <input type="hidden" name="item_type" value="' . $type . '">
                    <button type="submit" name="remove_from_panier" class="btn btn-outline-danger btn-sm" title="Retirer">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
              </td>';
        echo '</tr>';
    }
    echo '</tbody></table></div>';
}