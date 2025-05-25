document.getElementById('categorie').addEventListener('change', function() {
    let pageInput = document.querySelector('input[name="page"]');
    if (pageInput) pageInput.value = 1;
  });

  document.querySelectorAll('.materiel-card').forEach(function(card) {
    card.addEventListener('click', function() {
      document.getElementById('materiel_nom').textContent = card.dataset.nom;
      document.getElementById('materiel_img').src = card.dataset.img;
      document.getElementById('materiel_img').alt = card.dataset.nom;
      document.getElementById('materiel_categorie').textContent = card.dataset.categorie;
      document.getElementById('materiel_ref').textContent = card.dataset.ref;
      document.getElementById('materiel_date').textContent = card.dataset.date;
      document.getElementById('materiel_description').textContent = card.dataset.description;
      document.getElementById('materiel_quantite').textContent = card.dataset.quantite;
      var modal = new bootstrap.Modal(document.getElementById('materiel_element'));
      modal.show();
    });
  });