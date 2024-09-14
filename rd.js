const formPatient = document.getElementById('form-patient');
const btnSuivant = document.getElementById('btn-suivant');
const formRendezvous = document.getElementById('form-rendezvous');
const btnSubmit = document.getElementById('btn-submit');

btnSuivant.addEventListener('click', () => {
  // Vérifie que le formulaire du patient est valide
  if (formPatient.checkValidity()) {
    // Masque le formulaire du patient et affiche celui du rendez-vous
    formPatient.style.display = 'none';
    formRendezvous.style.display = 'block';
  } else {
    // Affiche un message d'erreur si le formulaire est invalide
    alert('Veuillez remplir tous les champs.');
  }
});

btnSubmit.addEventListener('click', (event) => {
  event.preventDefault(); // empêche l'envoi du formulaire
  const nom = document.getElementById('nom').value;
  const prenom = document.getElementById('prenom').value;
  const email = document.getElementById('email').value;
  const date = document.getElementById('date').value;
  const heure = document.getElementById('heure').value;
  const medecin = document.getElementById('medecin').value;
  if (medecin === "") {
    alert("Veuillez sélectionner un médecin.");
  } else {
    const message = `Demande de rendez-vous pour ${nom} ${prenom} (${email}) le ${date} à ${heure} avec ${medecin}.`;
    alert(message);
    formPatient.reset(); // réinitialise le formulaire du patient
    formRendezvous.reset(); // réinitialise le formulaire du rendez-vous
    formPatient.style.display = 'block'; // affiche le formulaire du patient
    formRendezvous.style.display = 'none'; // masque le formulaire du rendez-vous
  }
  });
  
  function suivant() {
    var form1 = document.getElementById("form1");
    var form2 = document.getElementById("form2");
    form1.style.display = "none";
    form2.style.display = "block";
  }
  
  function envoyer() {
    var nom = document.getElementById("nom").value;
    var prenom = document.getElementById("prenom").value;
    var email = document.getElementById("email").value;
    var medecin = document.getElementById("medecin").value;
    alert("Demande de rendez-vous envoyée avec succès pour " + nom + " " + prenom + " avec le Dr. " + medecin + ".\nUn email de confirmation sera envoyé à " + email + ".");
  }

  document.getElementById('btn-retour').addEventListener('click', function() {
    document.getElementById('form-rendezvous').style.display = 'none';
    document.getElementById('form-patient').style.display = 'block';
  });