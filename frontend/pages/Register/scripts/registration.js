import { register } from '../../../assets/js/services/registration.service';

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('registerForm');
  const errorBox = document.getElementById('errorBox');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    errorBox.textContent = '';

    try {
      const result = await register(form);

      alert('Registration successful!');
      window.location.href = '/nstp/index.php?page=login';

    } catch (error) {
      errorBox.textContent = error.message;
    }
  });
});
