<?php
// $pageCss = 'profile.css';
$pageTitle = 'Profile';
require_once __DIR__ . '/../../components/header.php';

?>
<div class="profile-page">
    <h1>Your Profile</h1>
    <p class="subtitle">Update your personal information</p>

    <div class="profile-container">
        <!-- Left: Profile Picture -->
        <div class="profile-photo">
            <img src="<?= BASE_URL ?>/frontend/assets/image/csi.webp" alt="Profile Picture">
            <button class="btn-upload">Change Photo</button>
        </div>

        <!-- Right: Profile Details -->
        <div class="profile-details">
            <form id="updateProfileForm">
                <input type="hidden" name="id" value="<?= $user["id"] ?>">
                <label>Full Name</label>
                <input type="text" name="full_name" value="<?= $user["full_name"] ?>">

                <label>Email</label>
                <input type="email" name="email_address" value="<?= $user["email_address"] ?>">

                <label>Contact Number</label>
                <input type="text" name="contact_number" value="<?= $user["contact_number"] ?>">

                <label>Address</label>
                <textarea name="address"><?= $user["address"] ?></textarea>

                <button type="submit" class="btn-save">Save Changes</button>
            </form>
        </div>
    </div>
</div>
<script src="/nstp/frontend/pages/Profile/scripts/profile.js"></script>
<?php require_once __DIR__ . '/../../components/footer.php'; ?>