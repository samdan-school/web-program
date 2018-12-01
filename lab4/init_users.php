<?php
    require_once('./logic/initialize.php');

    $students = find_all_students();

    while ($student = mysqli_fetch_assoc($students) ) {
        $hashed_password = password_hash("abc123", PASSWORD_DEFAULT);
        insert_users($student['student_id'], $hashed_password);
    }

    $staffs = find_all_staff();

    while ($staff = mysqli_fetch_assoc($staffs) ) {
            $hashed_password = password_hash("abc123", PASSWORD_DEFAULT);
            insert_users($staff['staff_id'], $hashed_password);
        {        
            insert_users($student['student_id'], $student['password']);
        }
    }
?>