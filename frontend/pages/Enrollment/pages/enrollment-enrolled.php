<?php
$pageTitle = 'Enroll Student';
require_once __DIR__ . '/../../../components/header.php';
?>

<section class="content-wrapper">
    <div class="page-header">
        <h2>Enrolled NSTP Students</h2>
        <p>List of students officially enrolled in NSTP</p>
    </div>

    <div class="card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Full Name</th>
                    <th>Program</th>
                    <th>Email</th>
                    <th>Date Enrolled</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>2024-00101</td>
                    <td>Juan Dela Cruz</td>
                    <td>CWTS</td>
                    <td>juan@email.com</td>
                    <td>Feb 05, 2026</td>
                    <td>
                        <span class="badge badge-enrolled">Enrolled</span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-view">View</button>
                    </td>
                </tr>

                <tr>
                    <td>2024-00102</td>
                    <td>Maria Santos</td>
                    <td>ROTC</td>
                    <td>maria@email.com</td>
                    <td>Feb 04, 2026</td>
                    <td>
                        <span class="badge badge-enrolled">Enrolled</span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-view">View</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section>


<?php require_once __DIR__ . '/../../../components/footer.php'; ?>