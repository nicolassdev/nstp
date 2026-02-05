<?php
// $pageCss = 'report.css';
$pageTitle = 'NSTP Reports';
require_once __DIR__ . '/../../components/header.php';
?>

<section class="reports-page">
    <h1>Reports Overview</h1>
    <p class="subtitle">Manage and review NSTP reports efficiently</p>

    <!-- Report Stats Cards -->
    <div class="report-cards">
        <div class="card">
            <h3>Total Reports</h3>
            <p>42</p>
        </div>
        <div class="card">
            <h3>Pending</h3>
            <p>7</p>
        </div>
        <div class="card">
            <h3>Approved</h3>
            <p>30</p>
        </div>
        <div class="card">
            <h3>Rejected</h3>
            <p>5</p>
        </div>
    </div>

    <!-- Report Table -->
    <div class="report-table-section">
        <h2>Recent Reports</h2>
        <table class="report-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Activity</th>
                    <th>Status</th>
                    <th>Date Submitted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Juan Dela Cruz</td>
                    <td>Community Service</td>
                    <td><span class="status approved">Approved</span></td>
                    <td>2026-02-05</td>
                    <td><button class="btn-view">View</button></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Maria Santos</td>
                    <td>Health Campaign</td>
                    <td><span class="status pending">Pending</span></td>
                    <td>2026-02-04</td>
                    <td><button class="btn-view">View</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<?php require_once __DIR__ . '/../../components/footer.php'; ?>
