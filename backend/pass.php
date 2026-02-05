<?php 

$newPassword = '123';
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Then update the database
$sql = "UPDATE tbl_student
        SET password = :password
        WHERE id = 1";

// Bind :password to $hashedPassword
