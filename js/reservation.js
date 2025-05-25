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
