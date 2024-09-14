const passInput = document.querySelector('input[name="pass"]');
const passConfirmInput = document.querySelector('input[name="pass_confirm"]');

function validatePassword() {
  if (passInput.value !== passConfirmInput.value) {
    passConfirmInput.setCustomValidity("Les mots de passe ne correspondent pas.");
  } else {
    passConfirmInput.setCustomValidity("");
  }
}

passInput.addEventListener('change', validatePassword);
passConfirmInput.addEventListener('keyup', validatePassword);
