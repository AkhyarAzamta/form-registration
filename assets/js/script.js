const confirmpassword = document.getElementById('confirm-password');
const submitButton = document.getElementById('submit-button');

confirmpassword.addEventListener("keyup", (e) => {
  const value = e.currentTarget.value;
  submitButton.disabled = value === "";

  if (!submitButton.disabled) {
    submitButton.style.backgroundColor = '#14A7A0';
    submitButton.style.color = 'white';
  } else {
    submitButton.style.backgroundColor = ''; // Kosongkan untuk kembali ke warna default
    submitButton.style.color = '';
  }
});

