document.addEventListener('DOMContentLoaded', function () {
    
    const form = document.querySelector('form');
    const dateInput = document.getElementById('date_emprunt');
    const heureAccesInput = document.getElementById('heure_acces');
    const heureRenduInput = document.getElementById('heure_rendu');
    const commentaireInput = document.getElementById('commentaire');
    
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const dateEmprunt = dateInput.value;
        const heureAcces = heureAccesInput.value;
        const heureRendu = heureRenduInput.value;
        
        if (!dateEmprunt || !heureAcces || !heureRendu) {
            alert('Veuillez remplir tous les champs requis');
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'verifier_reservation.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        const data = `date_emprunt=${dateEmprunt}&heure_acces=${heureAcces}&heure_rendu=${heureRendu}`;

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = xhr.responseText;
                if (response === 'disponible') {
                    form.submit();
                } else {
                    alert('Le matériel est déjà réservé à cette heure.');
                }
            }
        };

        xhr.send(data);
    });
});

function verifierSalleDispo(idSalle, date, heureDebut, heureFin, callback) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../php/verifier_salle.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            callback(xhr.responseText);
        }
    };
    xhr.send(`id_salle=${idSalle}&date_emprunt=${date}&heure_acces=${heureDebut}&heure_rendu=${heureFin}`);
}

document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('date_emprunt');
    const heureAccesInput = document.getElementById('heure_acces');
    const heureRenduInput = document.getElementById('heure_rendu');

    const salleInputs = document.querySelectorAll('input[name="panier_id[]"]');

    function checkAllSalles() {
        salleInputs.forEach(function(input) {
            const idSalle = input.value;
            verifierSalleDispo(
                idSalle,
                dateInput.value,
                heureAccesInput.value,
                heureRenduInput.value,
                function (etat) {
                    const infoDiv = document.getElementById('info_salle_' + idSalle);
                    if (etat === 'occupee') {
                        infoDiv.textContent = "Salle déjà réservée à ce créneau";
                        infoDiv.style.color = "red";
                    } else {
                        infoDiv.textContent = "Salle disponible";
                        infoDiv.style.color = "green";
                    }
                }
            );
        });
    }

    dateInput.addEventListener('change', checkAllSalles);
    heureAccesInput.addEventListener('change', checkAllSalles);
    heureRenduInput.addEventListener('change', checkAllSalles);
});