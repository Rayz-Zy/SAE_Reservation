<?php
function afficherTableauReservations($reservations, $avecActions = false, $role = '') {
    if (count($reservations) > 0) {
        echo '<div class="table-responsive mb-5">';
        echo '<table class="table table-bordered align-middle shadow-sm">';
        echo '<thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Utilisateur</th>
                    <th>Date</th>
                    <th>Heure accès</th>
                    <th>Heure rendu</th>
                    <th>Commentaire</th>
                    <th>État</th>';
        if ($avecActions && $role === 'admin') {
            echo '<th>Actions</th>';
        }
        echo '</tr></thead><tbody>';
        foreach ($reservations as $row) {
            echo "<tr>
                    <td>{$row["id_reservation"]}</td>
                    <td>{$row["pseudo"]}</td>
                    <td>{$row["date_emprunt"]}</td>
                    <td>{$row["heure_acces"]}</td>
                    <td>{$row["heure_rendu"]}</td>
                    <td>{$row["commentaire"]}</td>
                    <td><span class='badge ".($row["etat"]=='en attente'?'bg-warning text-dark':'bg-success')."'>".ucfirst($row["etat"])."</span></td>";
            if ($avecActions && $role === 'admin') {
                echo "<td>
                        <form method='POST' action='traitement_etat_reservation.php' style='display:inline;'>
                            <input type='hidden' name='id_reservation' value='{$row["id_reservation"]}'>
                            <button type='submit' name='action' value='valider' class='btn btn-success btn-sm me-1'>Valider</button>
                            <button type='submit' name='action' value='refuser' class='btn btn-danger btn-sm'>Refuser</button>
                        </form>
                      </td>";
            }
            echo "</tr>";
        }
        echo '</tbody></table></div>';
    } else {
        echo "<div class='alert alert-info'>Aucune réservation trouvée.</div>";
    }
}