<?php
session_start();

$pageTitle = 'NSTP Login';

// include header (2 levels up → nstp/)
require_once __DIR__ . '/../../components/header.php';
?>


  <div class="register-container">
    <div class="form-container">
      <h1>NSTP Student Registration</h1>
      <form action="<?= BASE_URL ?>/backend/Modules/Register/API.php" method="POST">
        <label for="lastname">Last name</label>
        <input type="text" id="lastname" name="lastname" placeholder="Enter your lastname" required>
        
        <label for="firstname">First name</label>
        <input type="text" id="firstname" name="firstname" placeholder="Enter your firstname" required>

        <label for="middlename">Middle name</label>
        <input type="text" id="middlename" name="middlename" placeholder="Enter your middlename">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>

        <label for="address">Address</label>
        <input type="address" id="address" name="address" placeholder="Enter your address" required>

        <label for="age">Age</label>
        <input type="age" id="age" name="age" placeholder="Confirm your age" required>



        <button type="submit">Register</button>
      </form>
      <p class="login-link">Already have an account? <a href="index.php?page=login">Login here</a></p>
    </div>
  </div>


<?php
require_once __DIR__ . '/../../components/footer.php';
?>