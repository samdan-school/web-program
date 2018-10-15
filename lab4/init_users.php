<?php
    require_once('./logic/initialize.php');

    $students = find_all_students();

    while ($student = mysqli_fetch_assoc($students) )
    {
        
        insert_users($student['student_id'], $student['password']);
    }
?>