<?php
	require_once('../../logic/initialize.php');

	// Checking there is id
	if (!isset($_GET['s_id'])) {
		redirect_to(url_for('/admin/index.php'));
	}
	$id = $_GET['s_id'];
?>

<?php
	// Checking request and deal with it
	$student = [];

	if (is_post_request())
	{
		$student['student_id'] = $_POST['student_id'] ?? '';
		$student['last_name'] = $_POST['last_name'] ?? '';
		$student['first_name'] = $_POST['first_name'] ?? '';
		$student['sex'] = $_POST['sex'] ?? '';
		$student['dob'] = $_POST['dob'] ?? '';
		$student['password'] = $_POST['password'] ?? ''; 
		$student['fk_program_id'] = $_POST['program_id'] ?? '';

		$result = update_student($student);
		if ($result === true) {
			redirect_to(url_for('/admin/index.php'));
		} else {
			$errors = $result;
		}
	}
	else 
	{
		$student = find_student_by_id($id);
	}
?>

<?php
	include_once(SHARED_PATH . '/main_header.php');
	
	$programs = find_all_pragram();
?>

<div class="page_heading">
	<a href="<?php echo url_for('/admin/index.php'); ?>" class="btn btn-primary float-left btn-left">Back</a>
	<h1>Edit Student</h1>
</div>

<form action="#" method="POST">
	<div class="form-group">
		<label for="student_id">Student ID</label>
		<input value="<?php echo $student['student_id']; ?>" name="student_id" type="text" class="form-control" id="student_id" placeholder="Enter Student Id" maxlength="4" size="4" required>
	</div>

	<div class="form-group">
		<label for="last_name">Last Name</label>
		<input value="<?php echo $student['last_name']; ?>" name="last_name" type="text" class="form-control" id="last_name" placeholder="Enter Last Name" maxlength="20" size="20" required>
	</div>

	<div class="form-group">
		<label for="first_name">First Name</label>
		<input value="<?php echo $student['first_name']; ?>" name="first_name" type="text" class="form-control" id="first_name" placeholder="Enter First Name" maxlength="20" size="20" required>
	</div>

	<div class="form-group">
		<label for="sex">Sex</label>
		<input value="<?php echo $student['sex']; ?>" name="sex" type="text" class="form-control" id="sex" placeholder="Enter Sex" maxlength="1" size="1" required>
	</div>

	<div class="form-group">
		<label for="dob">Data of Birth</label>
		<input value="<?php echo $student['dob']; ?>" name="dob" type="date" class="form-control" id="dob" placeholder="Enter Data of Birth" required>
	</div>

	<div class="form-group">
		<label for="program">Progarm</label>
		<select name="program_id" class="form-control" id="program" required>
			<?php
			$html = '';
				while ( $program_row = mysqli_fetch_assoc($programs) )
				{
					if ($student['fk_program_id'] == $program_row['program_id'])
					{
						$html .= '<option selected value="'. $program_row['program_id'] .'">' . $program_row['program_id'] . '</option>';
					} 
					else
					{
						$html .= '<option value="'. $program_row['program_id'] .'">' . $program_row['program_id'] . '</option>';
					} 
				}
			echo $html;
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="password">Password</label>
		<input value="<?php echo $student['password']; ?>" name="password" type="text" class="form-control" id="password" placeholder="Password" maxlength="30" size="30"  required>
	</div>

	<button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php
	include_once(SHARED_PATH . '/main_footer.php');
?>