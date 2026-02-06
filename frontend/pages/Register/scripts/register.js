document.getElementById('registerForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const registerFormData = new FormData(this);
  console.log("registerFormData", registerFormData);
  fetch('/nstp/backend/Controllers/RegistrationController.php', {
    method: 'POST',
    body: registerFormData,
    credentials: 'include'
  })
  .then(res => res.json())
  .then(result => {
      console.log("result",result);
    if (result.status === 'success') {
      alert(result.message || 'Successfully Registered');
      window.location.href = '/nstp/index.php?page=login';
    } else {
      alert(result.message || 'Registration failed');
    }
  });
});
