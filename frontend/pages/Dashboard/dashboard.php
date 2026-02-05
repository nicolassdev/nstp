<?php
$cssFile = $pageCss ?? 'global.css';
$pageTitle = 'NSTP Dashboard';
require_once __DIR__ . '/../../components/header.php';

?>

<section class="dashboard">
    <h1>Welcome back 👋</h1>
    <p class="subtitle">Here’s an overview of your NSTP activities</p>

    <div class="dashboard-cards">
        <div class="card">
            <h3>Students</h3>
            <p>1,245</p>
        </div>

        <div class="card">
            <h3>Activities</h3>
            <p>12</p>
        </div>

        <div class="card">
            <h3>Reports</h3>
            <p>5 Pending</p>
        </div>
        
        <div class="card">
            <h3>Erolled</h3>
            <p>5 Eronll</p>
        </div>
    </div>

    <div class="dashboard-section">
        <h2>Recent Activity</h2>
        <ul class="activity-list">
            <li>✔ Student attendance updated</li>
            <li>✔ New NSTP report submitted</li>
            <li>✔ Profile information updated</li>
        </ul>
    </div>
</section>

<?php
require_once __DIR__ . '/../../components/footer.php';
?>