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
            echo '<th>Action</th>';
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
                    <td><span class='badge "
                        .($row["etat"]=='en attente'?'bg-warning text-dark':
                          ($row["etat"]=='valider'?'bg-success':'bg-danger'))
                        ."'>".ucfirst($row["etat"])."</span></td>";
            if ($avecActions && $role === 'admin') {
    echo "<td>
            <a href='modifier_reservation.php?id_reservation={$row["id_reservation"]}' class='btn btn-warning btn-sm'>
                Modifier
            </a>
          </td>";
}
            echo "</tr>";
        }
        echo '</tbody></table></div>';
    } else {
        echo "<div class='alert alert-info'>Aucune réservation trouvée.</div>";
    }
}