<?php
	require_once('../logic/initialize.php');

	if (is_post_request())
	{
		$option = [];
		if( isset($_POST['student_id']) && isset($_POST['password']) )
		{
			if ( strlen($_POST['student_id']) != 4 )
			{
				redirect_to(url_for('/student/login.php'));
			}
			if ( strlen($_POST['password']) <= 0 || strlen($_POST['password']) > 30 )
			{
				redirect_to(url_for('/student/login.php'));
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
	}
?>

<?php
	include_once(SHARED_PATH . '/login_header.php');
?>

<div class="page_heading">
	<h1>Student Login</h1>
</div>

<form action="#" method="POST">
	<div class="form-group">
		<label for="student_id">Student ID</label>
		<input name="student_id" type="text" class="form-control" 
			id="student_id" placeholder="Enter Student Id" maxlength="4" size="4" required>
	</div>

	<div class="form-group">
		<label for="password">Password</label>
		<input name="password" type="password" class="form-control" 
			id="password" placeholder="Enter Your Password" maxlength="30" size="30" required>
	</div>
	<button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php
	include_once(SHARED_PATH . '/main_footer.php');
?>