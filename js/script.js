var password = document.getElementById('password').value;
  var confirmpassword = document.getElementById('confirm-password');
  var passwordError = document.getElementById('password-error');
  var submitButton = document.getElementById('submit-button');

  confirmpassword.addEventListener("keyup", (e) => {
    const value = e.currentTarget.value;
    if (value === "") {
      submitButton.disabled = true;
    } else {
      submitButton.disabled = false;
    }
  })
  function validateForm() {

  var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

  if (!passwordRegex.test(password)) {
    passwordError.textContent =
      "Password minimal harus 8 karakter, terdiri dari huruf kecil, huruf besar, angka, dan karakter spesial.";
    isValid = false;
  } else {
    passwordError.textContent = "";
  }
  }