<?php

$pageTitle = 'NSTP Registration';

// include header (2 levels up → nstp/)
require_once __DIR__ . '/../../components/header.php';
?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="register-container">
  <div class="form-container">
    <h1>Student Registration</h1>
    <form action="<?= BASE_URL ?>/backend/Controllers/RegistrationController.php" method="POST">
      <label for="last_name">Last name</label>
      <input type="text" id="last_name" name="last_name" placeholder="Enter your lastname" required>

      <label for="first_name">First name</label>
      <input type="text" id="first_name" name="first_name" placeholder="Enter your firstname" required>

      <label for="middle_name">Middle name</label>
      <input type="text" id="middle_name" name="middle_name" placeholder="Enter your middlename">

      <label for="email_address">Email</label>
      <input type="email" id="email_address" name="email_address" placeholder="Enter your email" required>

      <label for="address">Address</label>
      <input type="address" id="address" name="address" placeholder="Enter your address" required>

      <label for="birthdate">Date of Birth</label>
      <input type="date" id="birthdate" name="birthdate" required>

      <label for="contact_number">Contact</label>
      <input type="number" id="contact_number" name="contact_number" placeholder="Enter your contact number" required>

      <label for="sex">Gender</label>
      <select id="sex" name="sex" required>
        <option value="" disabled selected>Select gender</option>
        <option value="1">Male</option>
        <option value="0">Female</option>
      </select>


      <button type="submit">Register</button>
    </form>
    <p class="help-text">Already have an account? <a href="index.php?page=login">Login here</a></p>
  </div>
</div>


<?php
require_once __DIR__ . '/../../components/footer.php';
?>