<?php

    // STUDENT
    function find_all_students($option = [])
    {
        global $db;

        $sql = 'SELECT * FROM student ';
        $sql .= 'ORDER BY first_name ASC';
        //echo $sql;
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);

        return $result;
    }

    function find_student_by_id($id, $option = [])
    {
        global $db;

        $sql = 'SELECT * FROM student ';
        $sql .= "WHERE student_id='".db_escape($db, $id)."' ";
        // echo $sql;
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $student = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        return $student; // returns an assoc. array
    }

    function validate_subject($subject)
    {
        $errors = [];

        // menu_name
        if (is_blank($subject['menu_name'])) {
            $errors[] = 'Name cannot be blank.';
        } elseif (!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])) {
            $errors[] = 'Name must be between 2 and 255 characters.';
        }

        // position
        // Make sure we are working with an integer
        $postion_int = (int) $subject['position'];
        if ($postion_int <= 0) {
            $errors[] = 'Position must be greater than zero.';
        }
        if ($postion_int > 999) {
            $errors[] = 'Position must be less than 999.';
        }

        // visible
        // Make sure we are working with a string
        $visible_str = (string) $subject['visible'];
        if (!has_inclusion_of($visible_str, ['0', '1'])) {
            $errors[] = 'Visible must be true or false.';
        }

        return $errors;
    }

    function insert_student($student)
    {
        global $db;

        // $errors = validate_subject($subject);
        if (!empty($errors)) {
            return $errors;
        }

        $sql = 'INSERT INTO student ';
        $sql .= '(student_id, last_name, first_name, sex, dob, password, fk_program_id) ';
        $sql .= 'VALUES (';
        $sql .= "'".db_escape($db, $student['student_id'])."',";
        $sql .= "'".db_escape($db, $student['last_name'])."',";
        $sql .= "'".db_escape($db, $student['first_name'])."',";
        $sql .= "'".db_escape($db, $student['sex'])."',";
        $sql .= "'".db_escape($db, $student['dob'])."',";
        $sql .= "'".db_escape($db, $student['password'])."',";
        $sql .= "'".db_escape($db, $student['fk_program_id'])."'";
        $sql .= ')';
        $result = mysqli_query($db, $sql);
        // For INSERT statements, $result is true/false
        if ($result) {
            return true;
        } else {
            // INSERT failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function update_student($student)
    {
        global $db;

        if (!empty($errors)) {
            return $errors;
        }

        $sql = 'UPDATE student SET ';
        $sql .= "student_id='".db_escape($db, $student['student_id'])."', ";
        $sql .= "last_name='".db_escape($db, $student['last_name'])."', ";
        $sql .= "first_name='".db_escape($db, $student['first_name'])."', ";
        $sql .= "sex='".db_escape($db, $student['sex'])."', ";
        $sql .= "dob='".db_escape($db, $student['dob'])."', ";
        $sql .= "password='".db_escape($db, $student['password'])."', ";
        $sql .= "fk_program_id='".db_escape($db, $student['fk_program_id'])."' ";
        $sql .= "WHERE student_id='".db_escape($db, $student['student_id'])."' ";
        $sql .= 'LIMIT 1';

        $result = mysqli_query($db, $sql);
        // For UPDATE statements, $result is true/false
        if ($result) {
            return true;
        } else {
            // UPDATE failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function delete_student($id)
    {
        global $db;

        $sql = 'DELETE FROM student ';
        $sql .= "WHERE student_id='".db_escape($db, $id)."' ";
        $sql .= 'LIMIT 1';
        $result = mysqli_query($db, $sql);

        // For DELETE statements, $result is true/false
        if ($result) {
            return true;
        } else {
            // DELETE failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    // Pragram

    function find_all_pragram()
    {
        global $db;

        $sql = 'SELECT * FROM program ';
        $sql .= 'ORDER BY program_id ASC';
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);

        return $result;
    }

    function find_pragram_by_id($id, $option = [])
    {
        global $db;

        $sql = 'SELECT * FROM program ';
        $sql .= "WHERE program_id='".db_escape($db, $id)."' ";

        $result = mysqli_query($db, $sql);
        confirm_result_set($result);

        return $result;
    }

    function find_all_course()
    {
        global $db;

        $sql = 'SELECT * FROM course ';
        $sql .= 'ORDER BY course_id ASC';
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);

        return $result;
    }

    function find_all_course_enrollment_by_student_id($id)
    {
        global $db;

        $sql = 'SELECT * FROM course_enrollment ';
        $sql .= "WHERE student_id='".db_escape($db, $id)."' ";
        $sql .= 'ORDER BY course_id ';
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);

        return $result;
    }

    function find_all_course_program_id($id)
    {
        global $db;

        $sql = 'SELECT * FROM course ';
        $sql .= "WHERE program_id='".db_escape($db, $id)."' ";
        $sql .= 'ORDER BY course_id ';
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);

        return $result;
    }

    // Users
    function insert_users($u_id, $password)
    {
        global $db;

        // $errors = validate_subject($subject);
        if (!empty($errors)) {
            return $errors;
        }

        $sql = 'INSERT INTO users ';
        $sql .= '(user_id, password) ';
        $sql .= 'VALUES (';
        $sql .= "'".db_escape($db, $u_id)."',";
        $sql .= "'".db_escape($db, $password)."'";
        $sql .= ')';
        $result = mysqli_query($db, $sql);
        // For INSERT statements, $result is true/false
        if ($result) {
            return true;
        } else {
            // INSERT failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function find_users_by_id($id, $option = [])
    {
        global $db;

        $sql = 'SELECT * FROM users ';
        $sql .= "WHERE user_id='".db_escape($db, $id)."' ";
        // echo $sql;
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $student = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        return $student; // returns an assoc. array
    }

    // STAFF
    function find_all_staff($option = [])
    {
        global $db;

        $sql = 'SELECT * FROM staff ';
        $sql .= 'ORDER BY first_name ASC';
        //echo $sql;
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);

        return $result;
    }
