document.getElementById('updateProfileForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch('/nstp/backend/Controllers/ProfileController.php', {
    method: 'POST', // or 'PUT' if you update controller to accept PUT
    body: formData,
    credentials: 'include'
  })
  .then(res => res.json())
  .then(result => {
      console.log("result", result);
      if (result.status === 'success') {
        alert(result.message || 'Profile updated successfully');
        // Optionally reload page or update session UI without redirect
        window.location.reload();
      } else {
        alert(result.message || 'Failed to update profile');
      }
  });
});
