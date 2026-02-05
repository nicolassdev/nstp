<?php
// $pageCss = 'profile.css';
$pageTitle = 'Profile';
require_once __DIR__ . '/../../components/header.php';
?>

<section class="profile-page">
    <h1>Your Profile</h1>
    <p class="subtitle">Update your personal information</p>

    <div class="profile-container">
        <!-- Left: Profile Picture -->
        <div class="profile-photo">
            <img src="<?= BASE_URL ?>/frontend/assets/image/default-user.webp" alt="Profile Picture">
            <button class="btn-upload">Change Photo</button>
        </div>

        <!-- Right: Profile Details -->
        <div class="profile-details">
            <form action="" method="POST">
                <label>Full Name</label>
                <input type="text" value="<?= $_SESSION['user_data']['user']['full_name'] ?? '' ?>">

                <label>Email</label>
                <input type="email" value="<?= $_SESSION['user_data']['user']['email'] ?? '' ?>">

                <label>Contact Number</label>
                <input type="text" value="<?= $_SESSION['user_data']['user']['contact_number'] ?? '' ?>">

                <label>Address</label>
                <textarea><?= $_SESSION['user_data']['user']['address'] ?? '' ?></textarea>

                <button type="submit" class="btn-save">Save Changes</button>
            </form>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../components/footer.php'; ?>
