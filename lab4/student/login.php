<?php
	require_once('../logic/initialize.php');

	$page_title = 'Log in';

	if (is_logged_in_student()) {
		redirect_to(url_for('/student/index.php'));
	}
	
	if (is_logged_in_staff()) {
		redirect_to(url_for('/admin/index.php'));
	}
    $errors = [];
    $username = '';
    $password = '';

	if (is_post_request())
	{
		$user_id = $_POST['user_id'] ?? '';
		$password = $_POST['password'] ?? '';
		$remember_me = $_POST['remember_me'] ?? '';

		if ( $user = find_users_by_id($_POST['user_id']) )
		{
			if ( password_verify($password, $user['password']) ) {

				if ($remember_me) {
					setcookie('user_id', $user_id, time() + 86400, "/"); // 86400 = 1 day and global path usage cookie
				}

				if ( $user['user_id'][0] == 's' && log_in($user)) {
					redirect_to(url_for('/student/index.php'));
				}

				if ( $user['user_id'][0] == 'a' && log_in($user)) {
					redirect_to(url_for('/admin/index.php'));
				}
			if ( $student = find_student_by_id( sanitizeString($_POST['student_id'])) )
			{	
				if ( $student['password'] == sanitizeString($_POST['password'])  )
				{
					redirect_to(url_for('/student/index.php?s_id=' . $_POST['student_id']));
				}
			} 
			else
			{
				redirect_to(url_for('/student/login.php'));
			}
		}
		else
		{
			redirect_to(url_for('/student/login.php'));
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
		<input name="user_id" type="text" class="form-control" value="<?php echo isset($_COOKIE['remember_me']) ? $_COOKIE['remember_me'] : ''; ?>"
			id="user_id" placeholder="Enter User Id" maxlength="4" size="4" required>
	</div>

	<div class="form-group">
		<label for="password">Password</label>
		<input name="password" type="password" class="form-control" 
			id="password" placeholder="Enter Your Password" maxlength="30" size="30" required>
	</div>
	
	<div class="form-group form-check">
		<input name="remember_me" type="checkbox" class="form-check-input" id="remember_me">
		<label class="form-check-label" for="remember_me">Remember Me</label>
  </div>
	<button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php
	include_once(SHARED_PATH . '/main_footer.php');
?>