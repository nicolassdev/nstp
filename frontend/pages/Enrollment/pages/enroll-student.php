<?php
$pageTitle = 'Enroll Student';
require_once __DIR__ . '/../../../components/header.php';
?>

<div class="enroll-page">

    <div class="enroll-card">
        <div class="enroll-header">
            <h2>Enroll Student</h2>
            <p>Fill in the student details to enroll in NSTP</p>
        </div>

        <form id="enrollStudentForm" class="enroll-form">

            <!-- STUDENT INFO -->
            <div class="form-section">
                <h3>Student Information</h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Student ID</label>
                        <input type="text" name="student_id" placeholder="e.g. 2024-00123" required>
                    </div>

                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" placeholder="Juan Dela Cruz" required>
                    </div>

                    <div class="form-group">
                        <label>Course</label>
                        <select name="course" required>
                            <option value="">Select course</option>
                            <option value="0">BSIS</option>
                            <option value="1">BSCS</option>
                            <option value="2">ACT</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Year Level</label>
                        <select name="year_level" required>
                            <option value="">Select year</option>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- NSTP DETAILS -->
            <div class="form-section">
                <h3>NSTP Details</h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label>NSTP Program</label>
                        <select name="nstp_program" required>
                            <option value="">Select program</option>
                            <option value="CWTS">CWTS</option>
                            <option value="ROTC">ROTC</option>
                            <option value="LTS">LTS</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Semester</label>
                        <select name="semester" required>
                            <option value="">Select semester</option>
                            <option value="1st">1st Semester</option>
                            <option value="2nd">2nd Semester</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>School Year</label>
                        <input type="text" name="school_year" placeholder="2024 - 2025" required>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="pending">Pending</option>
                            <option value="enrolled">Enrolled</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    Enroll Student
                </button>

                <a href="<?= BASE_URL ?>index.php?page=enrollment" class="btn-secondary">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../../components/footer.php'; ?>