<?php

    // Subjects

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
        $sql .= "WHERE student_id='" . db_escape($db, $id) . "' ";
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
        $postion_int = (int)$subject['position'];
        if ($postion_int <= 0) {
            $errors[] = 'Position must be greater than zero.';
        }
        if ($postion_int > 999) {
            $errors[] = 'Position must be less than 999.';
        }

        // visible
        // Make sure we are working with a string
        $visible_str = (string)$subject['visible'];
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
        $sql .= "'" . db_escape($db, $student['student_id']) . "',";
        $sql .= "'" . db_escape($db, $student['last_name']) . "',";
        $sql .= "'" . db_escape($db, $student['first_name']) . "',";
        $sql .= "'" . db_escape($db, $student['sex']) . "',";
        $sql .= "'" . db_escape($db, $student['dob']) . "',";
        $sql .= "'" . db_escape($db, $student['password']) . "',";
        $sql .= "'" . db_escape($db, $student['fk_program_id']) . "'";
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
        $sql .= "student_id='" . db_escape($db, $student['student_id']) . "', ";
        $sql .= "last_name='" . db_escape($db, $student['last_name']) . "', ";
        $sql .= "first_name='" . db_escape($db, $student['first_name']) . "', ";
        $sql .= "sex='" . db_escape($db, $student['sex']) . "', ";
        $sql .= "dob='" . db_escape($db, $student['dob']) . "', ";
        $sql .= "password='" . db_escape($db, $student['password']) . "', ";
        $sql .= "fk_program_id='" . db_escape($db, $student['fk_program_id']) . "' ";
        $sql .= "WHERE student_id='" . db_escape($db, $student['student_id']) . "' ";
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
        $sql .= "WHERE student_id='" . db_escape($db, $id) . "' ";
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
		$sql .= "WHERE program_id='" . db_escape($db, $id) . "' ";
		
        $result = mysqli_query($db, $sql);
		confirm_result_set($result);
		
        return $result;
    }

    function find_pages_by_subject_id($subject_id, $option = [])
    {
        global $db;

        $visible = $option['visible'] ?? false;

        $sql = 'SELECT * FROM pages ';
        $sql .= "WHERE subject_id='" . db_escape($db, $subject_id) . "' ";
        if ($visible) {
            $sql .= 'AND visible = true ';
        }
        $sql .= 'ORDER BY position ASC';
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result; // returns an assoc. array-
    }

    function count_pages_by_subject_id($subject_id, $option = [])
    {
        global $db;

        $visible = $option['visible'] ?? false;

        $sql = 'SELECT COUNT(id) FROM pages ';
        $sql .= "WHERE subject_id='" . db_escape($db, $subject_id) . "' ";
        if ($visible) {
            $sql .= 'AND visible = true ';
        }
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $row = mysqli_fetch_row($result);
        mysqli_free_result($result);
        $count = $row[0];

        return $count; // returns an assoc. array-
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

    function insert_page($page)
    {
        global $db;

        $errors = validate_page($page);
        if (!empty($errors)) {
            return $errors;
        }

        shift_page_positions(0, $page['position'], $page['subject_id']);

        $sql = 'INSERT INTO pages ';
        $sql .= '(subject_id, menu_name, position, visible, content) ';
        $sql .= 'VALUES (';
        $sql .= "'" . db_escape($db, $page['subject_id']) . "',";
        $sql .= "'" . db_escape($db, $page['menu_name']) . "',";
        $sql .= "'" . db_escape($db, $page['position']) . "',";
        $sql .= "'" . db_escape($db, $page['visible']) . "',";
        $sql .= "'" . db_escape($db, $page['content']) . "'";
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

    function update_page($page)
    {
        global $db;

        $errors = validate_page($page);
        if (!empty($errors)) {
            return $errors;
        }

        $old_page = find_page_by_id($page['id']);
        $start_pos = $old_page['position'];
        shift_page_positions($start_pos, $page['position'], $page['subject_id'], $page['id']);

        $sql = 'UPDATE pages SET ';
        $sql .= "subject_id='" . db_escape($db, $page['subject_id']) . "', ";
        $sql .= "menu_name='" . db_escape($db, $page['menu_name']) . "', ";
        $sql .= "position='" . db_escape($db, $page['position']) . "', ";
        $sql .= "visible='" . db_escape($db, $page['visible']) . "', ";
        $sql .= "content='" . db_escape($db, $page['content']) . "' ";
        $sql .= "WHERE id='" . db_escape($db, $page['id']) . "' ";
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

    function delete_page($id)
    {
        global $db;

        $old_page = find_page_by_id($id);
        $start_pos = $old_page['position'];
        shift_page_positions($start_pos, 0, $old_page['subject_id'], $old_page['id']);

        $sql = 'DELETE FROM pages ';
        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
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

    // Admins

    function find_all_course_by_student_id($id)
    {
        global $db;

        $sql = 'SELECT * FROM course_enrollment ';
        $sql .= "WHERE course_id='" . db_escape($db, $id) . "' ";
        $sql .= 'ORDER BY course_id ';
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function find_admin_by_id($id)
    {
        global $db;

        $sql = 'SELECT * FROM admins ';
        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $admin = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $admin;
    }

    function find_admin_by_username($username)
    {
        global $db;

        $sql = 'SELECT * FROM admins ';
        // $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
        $sql .= "WHERE username='" . $username . "' ";
        $result = mysqli_query($db, $sql);
        // confirm_result_set($result);
        $admin = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $admin;
    }

    function validate_admin($admin, $options = [])
    {
        $errors = [];

        $password_required = $options['password_required'] ?? true;

        // First Name 2-255
        if (is_blank($admin['first_name'])) {
            $errors[] = 'Fist name cannot be blank.';
        } elseif (!has_length($admin['first_name'], ['mix' => 2, 'max' => 255])) {
            $errors[] = 'First name must be between 2 to 255 characters.';
        }

        // Last Name 2-255
        if (is_blank($admin['last_name'])) {
            $errors[] = 'Last name cannot be blank.';
        } elseif (!has_length($admin['last_name'], ['mix' => 2, 'max' => 255])) {
            $errors[] = 'Last name must be between 2 to 255 characters.';
        }

        // Email not blank and format
        if (is_blank($admin['email'])) {
            $errors[] = 'Email cannot be blank.';
        } elseif (!has_valid_email_format($admin['email'])) {
            $errors[] = 'This is not valid email.';
        }

        // Username must be unique and 8-255
        if (is_blank($admin['username'])) {
            $errors[] = 'Username cannot be blank';
        } elseif (!has_length($admin['username'], ['min' => 8, 'max' => 255])) {
            $errors[] = 'Username must be between 8 to 255 characters.';
        }

        $current_id = $admin['id'] ?? 0;
        if (!has_unique_admin_username($admin['username'], $current_id)) {
            $errors[] = 'Username must be unique';
        }

        // Password 12+ char 1 upper, 1 lower, 1number, 1symbol
        if ($password_required) {
            if ($admin['password'] !== $admin['re_password']) {
                $errors[] = 'Passwords do not match.';
            } elseif (!has_length_greater_than($admin['password'], 11)) {
                $errors[] = 'Password must be longer than 12 characters';
            }
            if (!preg_match('/[A-Z]/', $admin['password'])) {
                $errors[] = 'Password must contain at least 1 uppercase letter';
            }
            if (!preg_match('/[a-z]/', $admin['password'])) {
                $errors[] = 'Password must contain at least 1 lowercase letter';
            }
            if (!preg_match('/[0-9]/', $admin['password'])) {
                $errors[] = 'Password must contain at least 1 number';
            }
            if (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])) {
                $errors[] = 'Password must contain at least 1 symbol';
            }
        }

        return $errors;
    }

    function insert_admin($admin)
    {
        global $db;

        $errors = validate_admin($admin);
        if (!empty($errors)) {
            return $errors;
        }

        $hashed_password = password_hash($admin['password'], PASSWORD_DEFAULT);

        $sql = 'INSERT INTO admins ';
        $sql .= '(first_name, last_name, email, username, hashed_password) ';
        $sql .= 'VALUE(';
        $sql .= "'" . db_escape($db, $admin['first_name']) . "',";
        $sql .= "'" . db_escape($db, $admin['last_name']) . "',";
        $sql .= "'" . db_escape($db, $admin['email']) . "',";
        $sql .= "'" . db_escape($db, $admin['username']) . "',";
        $sql .= "'" . db_escape($db, $hashed_password) . "'";
        $sql .= ')';
        $result = mysqli_query($db, $sql);

        if ($result) {
            return true;
        } else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit();
        }
    }

    function update_admin($admin)
    {
        global $db;

        $password_sent = !is_blank($admin['password']);

        $errors = validate_admin($admin, ['password_required' => $password_sent]);
        if (!empty($errors)) {
            return $errors;
        }

        $hashed_password = password_hash($admin['password'], PASSWORD_DEFAULT);

        $sql = 'UPDATE admins SET ';
        $sql .= "first_name='" . db_escape($db, $admin['first_name']) . "', ";
        $sql .= "last_name='" . db_escape($db, $admin['last_name']) . "', ";
        $sql .= "email='" . db_escape($db, $admin['email']) . "', ";
        if ($password_sent) {
            $sql .= "hashed_password='" . db_escape($db, $hashed_password) . "', ";
        }
        $sql .= "username='" . db_escape($db, $admin['username']) . "' ";
        $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
        $sql .= 'LIMIT 1 ';
        $result = mysqli_query($db, $sql);

        if ($result) {
            return true;
        } else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit();
        }
    }

    function delete_admin($id)
    {
        global $db;

        $sql = 'DELETE FROM admins ';
        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
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

    // Utility

    function shift_subject_positions($start_pos, $end_pos, $current_id = 0)
    {
        global $db;

        if ($start_pos == $end_pos) {
            return;
        }

        $sql = 'UPDATE subjects ';

        if ($start_pos == 0) {
            $sql .= 'SET position = position + 1 ';
            $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
        } elseif ($end_pos == 0) {
            $sql .= 'SET position = position - 1 ';
            $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
        } elseif ($start_pos < $end_pos) {
            $sql .= 'SET position = position - 1 ';
            $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
            $sql .= "AND position <='" . db_escape($db, $end_pos) . "' ";
        } elseif ($start_pos > $end_pos) {
            $sql .= 'SET position = position + 1 ';
            $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
            $sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
        }

        $sql .= "AND id !='" . db_escape($db, $current_id) . "'";

        mysqli_query($db, $sql);
    }

    function shift_page_positions($start_pos, $end_pos, $subject_id, $current_id = 0)
    {
        global $db;

        if ($start_pos == $end_pos) {
            return;
        }

        $sql = 'UPDATE pages ';

        if ($start_pos == 0) {
            $sql .= 'SET position = position + 1 ';
            $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
        } elseif ($end_pos == 0) {
            $sql .= 'SET position = position - 1 ';
            $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
        } elseif ($start_pos < $end_pos) {
            $sql .= 'SET position = position - 1 ';
            $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
            $sql .= "AND position <='" . db_escape($db, $end_pos) . "' ";
        } elseif ($start_pos > $end_pos) {
            $sql .= 'SET position = position + 1 ';
            $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
            $sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
        }

        $sql .= "AND subject_id = '" . db_escape($db, $subject_id) . "' ";
        $sql .= "AND id !='" . db_escape($db, $current_id) . "' ";

        $result = mysqli_query($db, $sql);
        if ($result) {
            return true;
        } else {
            // UPDATE failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit();
        }
    }
