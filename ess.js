const ordonnanceForm = document.querySelector('#ordonnance-form');

ordonnanceForm.addEventListener('submit', (e) => {
  e.preventDefault();
  
  const pharmacieSelect = document.querySelector('#pharmacie-select');
  const ordonnanceFile = document.querySelector('#ordonnance-file');
  
  if (!pharmacieSelect.value) {
    alert('Veuillez sélectionner une pharmacie');
    return;
  }
  
  if (!ordonnanceFile.value) {
    alert('Veuillez joindre une ordonnance');
    return;
  }
  
  // Envoyer l'ordonnance à la pharmacie sélectionnée
  alert(`L'ordonnance a été envoyée à ${pharmacieSelect.value}`);
  
  // Réinitialiser le formulaire
  pharmacieSelect.value = '';
  ordonnanceFile.value = '';
});
