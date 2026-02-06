<?php
$pageTitle = 'Enroll Student';
require_once __DIR__ . '/../../../components/header.php';
?>
<div class="content-wrapper">
    <div class="page-header">
        <h2>Pending NSTP Enrollment</h2>
        <p>Review and approve student enrollment requests</p>
    </div>

    <div class="card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Full Name</th>
                    <th>Program</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>2024-00123</td>
                    <td>Juan Dela Cruz</td>
                    <td>CWTS</td>
                    <td>juan@email.com</td>
                    <td>
                        <span class="badge badge-pending">Pending</span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-approve">Approve</button>
                        <button class="btn btn-reject">Reject</button>
                    </td>
                </tr>

                <tr>
                    <td>2024-00124</td>
                    <td>Maria Santos</td>
                    <td>ROTC</td>
                    <td>maria@email.com</td>
                    <td>
                        <span class="badge badge-pending">Pending</span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-approve">Approve</button>
                        <button class="btn btn-reject">Reject</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../../../components/footer.php'; ?>