<?php
	require_once('./logic/initialize.php');

	$page_title = 'New User';

	if (is_logged_in_student()) {
		redirect_to(url_for('/index.php'));
	}
	
    $errors = [];
    $username = '';
    $password = '';

	if (is_post_request()) {
		$user_id = $_POST['user_id'] ?? '';
		$password = $_POST['password'] ?? '';
		$re_password = $_POST['re_password'] ?? '';

		if ( $user = find_users_by_id($_POST['user_id']) ) {
			if ( password_verify($password, $user['password']) ) {

				if ( $user['user_id'][0] == 's' && log_in($user)) {
					redirect_to(url_for('/index.php'));
				}

				if ( $user['user_id'][0] == 'a' && log_in($user)) {
					redirect_to(url_for('/admin/index.php'));
				}
			if ( $student = find_student_by_id( sanitizeString($_POST['student_id'])) ) {	
				if ( $student['password'] == sanitizeString($_POST['password'])  ) {
					redirect_to(url_for('/index.php?s_id=' . $_POST['student_id']));
				}
			} else {
				redirect_to(url_for('/login.php'));
			}
		} else {
			redirect_to(url_for('/login.php'));
		}			
	}
}
?>

<?php
	include_once(SHARED_PATH . '/login_header.php');
?>

<div class="page_heading">
	<h1>Login</h1>
</div>

<form action="#" method="POST">
	<div class="form-group">
		<label for="user_id">USER ID</label>
		<input name="user_id" type="text" class="form-control" value=""
			id="user_id" placeholder="Enter User Id" maxlength="4" size="4" required>
	</div>

    <div class="form-group">
        <label for="password">Password</label>
        <input name="password" type="password" class="form-control" 
            id="password" placeholder="Enter Your Password" maxlength="30" size="30" required>
    </div>

    <div class="form-group">
        <label for="re_password">Re Password</label>
        <input name="re_password" type="password" class="form-control" 
            id="re_password" placeholder="Enter Your Re Password" maxlength="30" size="30" required>
    </div>
	<button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php
	include_once(SHARED_PATH . '/main_footer.php');
?>