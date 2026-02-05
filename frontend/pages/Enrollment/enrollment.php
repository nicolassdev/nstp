<?php
// $pageCss = 'enrollment.css';
$pageTitle = 'Enrollment';
require_once __DIR__ . '/../../components/header.php';
?>

<section class="enrollment-page">
    <h1>Enrollment</h1>
    <p class="subtitle">Manage student enrollment for NSTP activities</p>

    <div class="enrollment-actions">
        <input type="text" placeholder="Search student..." class="search-input">
        <button class="btn-add">Enroll Student</button>
    </div>

    <div class="enrollment-table-section">
        <table class="enrollment-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Year</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Juan Dela Cruz</td>
                    <td>BSIT</td>
                    <td>3</td>
                    <td><span class="status enrolled">Enrolled</span></td>
                    <td><button class="btn-edit">Edit</button> <button class="btn-remove">Remove</button></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Maria Santos</td>
                    <td>BSBA</td>
                    <td>2</td>
                    <td><span class="status pending">Pending</span></td>
                    <td><button class="btn-edit">Edit</button> <button class="btn-remove">Remove</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<?php require_once __DIR__ . '/../../components/footer.php'; ?>