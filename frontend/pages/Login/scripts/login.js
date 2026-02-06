 

document.getElementById('loginForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch('/nstp/backend/Controllers/LoginController.php', {
    method: 'POST',
    body: formData,
    credentials: 'include'
  })
  .then(res => res.json())
  .then(result => {
      console.log("result",result);
    if (result.status === 'success') {
      window.location.href = '/nstp/index.php?page=dashboard';
    } else {
      alert(result.message || 'Login failed');
    }
  });
});

