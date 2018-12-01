<?php
	// Performs all actions necessary to log in an admin
	function log_in($user) {
		// Reentering the ID protects the student from session fixation.
		session_regenerate_id();

		$type = '';
		
		if ( $user['user_id'][0] == 's' ) {
			$type = 'student';
		}		
		if ( $user['user_id'][0] == 'a' ) {
			$type = 'staff';
		}

		if ( $type === '' ) {
			return false;
		}

		$_SESSION[$type . '_id'] = $user['user_id'];
		$_SESSION['last_login'] = time();
		return true;
	}

	function is_logged_in_student() {
		// Having a admin_id in the session server a dual-purpose:
		// - Its presence indicates the admin is logged in.
		// - Its value tells which admin for looking up their record.
		return isset($_SESSION['student_id']);
	}

	function is_logged_in_staff() {
		return isset($_SESSION['staff_id']);
	}

	// Call require_login() at the top of any page which needs to
	// require a valid login before granting accesses to the page.
	function require_login_student() {
		if (!is_logged_in_student()) {
			redirect_to(url_for('/login.php'));
		} else {
			// Do nothing, let the rest of page process.
		}
	}
	function require_login_staff() {
		if (!is_logged_in_staff()) {
			redirect_to(url_for('/login.php'));
		} else {
			// Do nothing, let the rest of page process.
		}
	}

	function log_out() {
		unset($_SESSION['student_id']);
		unset($_SESSION['last_login']);
		// session_destroy(); // optional: destroy the whole session
		return true;
	}