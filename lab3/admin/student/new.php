<?php
	require_once('../../logic/initialize.php');
?>

<?php
	include_once(SHARED_PATH . '/main_header.php');

	$programs = find_all_pragram();
?>

<div class="page_heading">
	<a href="<?php echo url_for('/admin/index.php'); ?>" class="btn btn-primary float-left btn-left">Back</a>
	<h1>New Student</h1>
</div>

<form>
	<div class="form-group">
		<label for="student_id">Student ID</label>
		<input name="student_id" type="text" class="form-control" id="student_id" placeholder="Enter Student Id" maxlength="4" size="4" required>
	</div>

	<div class="form-group">
		<label for="last_name">Last Name</label>
		<input name="last_name" type="text" class="form-control" id="last_name" placeholder="Enter Last Name" maxlength="20" size="20" required>
	</div>

	<div class="form-group">
		<label for="first_name">First Name</label>
		<input name="first_name" type="text" class="form-control" id="first_name" placeholder="Enter First Name" maxlength="20" size="20" required>
	</div>

	<div class="form-group">
		<label for="sex">Sex</label>
		<input name="sex" type="text" class="form-control" id="sex" placeholder="Enter Sex" maxlength="1" size="1" required>
	</div>

	<div class="form-group">
		<label for="dob">Data of Birth</label>
		<input name="dob" type="date" class="form-control" id="dob" placeholder="Enter Data of Birth" required>
	</div>

	<div class="form-group">
		<label for="program">Progarm</label>
		<select class="form-control" id="program" required>
  			<option selected>Choose program</option>
			<?php
			$html = '';
				while ( $program_row = mysqli_fetch_assoc($programs) )
				{
					$html .= '<option value= '. $program_row['program_id'] .'>' . $program_row['program_id'] . '</option>';
				}
			echo $html;
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="password">Password</label>
		<input name="password" type="text" class="form-control" id="password" placeholder="Password" maxlength="30" size="30"  required>
	</div>

	<button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php
	include_once(SHARED_PATH . '/main_footer.php');
?>