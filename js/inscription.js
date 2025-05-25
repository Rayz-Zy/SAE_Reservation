document.addEventListener('DOMContentLoaded', function() {
    
    const selectRole = document.getElementById('role');
    const roleMap = {
        'etudiant': 'student',
        'enseignant': 'professeur',
        'agent': 'agent',
        'admin': 'admin'
    };
    const allRoleDivs = Object.values(roleMap).map(id => document.getElementById(id));

    function updateRoleFields() {
        const value = selectRole.value;
        allRoleDivs.forEach(div => {
            if (div) div.style.display = 'none';
        });
        if (roleMap[value]) {
            const divToShow = document.getElementById(roleMap[value]);
            if (divToShow) divToShow.style.display = 'block';
        }
    }

    selectRole.addEventListener('change', updateRoleFields);
    updateRoleFields();

    const form = document.querySelector('.form-inscription');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        let valid = true;
        let messages = [];

        const pseudo = form.pseudo.value.trim();
        const nom = form.nom.value.trim();
        const prenom = form.prenom.value.trim();
        const email = form.email.value.trim();
        const naissance = form.naissance.value;
        const tel = form.tel.value.trim();
        const adresse = form.adresse.value.trim();
        const mdp = form.mot_de_passe.value;

        if (pseudo.length < 3) {
            valid = false;
            messages.push("Le pseudo doit contenir au moins 3 caractères.");
        }
        if (!/^[a-zA-ZÀ-ÿ\s\-]+$/.test(nom)) {
            valid = false;
            messages.push("Le nom n'est pas valide.");
        }
        if (!/^[a-zA-ZÀ-ÿ\s\-]+$/.test(prenom)) {
            valid = false;
            messages.push("Le prénom n'est pas valide.");
        }
        if (!/^[\w\.-]+@[\w\.-]+\.\w{2,}$/.test(email)) {
            valid = false;
            messages.push("L'email n'est pas valide.");
        }
        if (!naissance) {
            valid = false;
            messages.push("La date de naissance est obligatoire.");
        }
        if (!/^\d{10}$/.test(tel)) {
            valid = false;
            messages.push("Le téléphone doit contenir 10 chiffres.");
        }
        if (adresse.length < 5) {
            valid = false;
            messages.push("L'adresse doit contenir au moins 5 caractères.");
        }
        if (mdp.length < 6) {
            valid = false;
            messages.push("Le mot de passe doit contenir au moins 6 caractères.");
        }

        const role = form.role.value;
        if (role === "etudiant") {
            if (!form.num_etudiant.value.trim()) {
                valid = false;
                messages.push("Le numéro étudiant est obligatoire.");
            }
            if (!form.TD.value.trim()) {
                valid = false;
                messages.push("Le groupe de TD est obligatoire.");
            }
            if (!form.TP.value.trim()) {
                valid = false;
                messages.push("Le groupe de TP est obligatoire.");
            }
        }
        if (role === "enseignant") {
            if (!form.diplome.value.trim()) {
                valid = false;
                messages.push("Le diplôme est obligatoire.");
            }
            if (!form.qualif.value.trim()) {
                valid = false;
                messages.push("La qualification est obligatoire.");
            }
        }
        if (role === "agent") {
            if (!form.qualif_agent.value.trim()) {
                valid = false;
                messages.push("La qualification agent est obligatoire.");
            }
        }
        if (role === "admin") {
            if (!form.niveau.value.trim()) {
                valid = false;
                messages.push("Le niveau de droit est obligatoire.");
            }
        }

        let errorDiv = document.getElementById('form-errors');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.id = 'form-errors';
            errorDiv.className = 'alert alert-danger';
            form.prepend(errorDiv);
        }
        if (!valid) {
            e.preventDefault();
            errorDiv.innerHTML = messages.join('<br>');
            window.scrollTo({top: 0, behavior: 'smooth'});
        } else {
            errorDiv.innerHTML = '';
        }
    });
});