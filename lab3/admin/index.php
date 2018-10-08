<?php
	require_once('../logic/initialize.php');
?>

<?php
	include_once(SHARED_PATH . '/main_header.php');

	$students = find_all_students();
?>

<div class="page_heading">
	<h1>Student List</h1>
	<a href="<?php echo url_for('admin/student/new.php'); ?>" class="btn btn-primary float-right btn-right">New Student</a>
</div>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Student ID</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Sex</th>
      <th scope="col">Data of Birth</th>
      <th scope="col">Program</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>

  <?php 
	while ($student_row = mysqli_fetch_assoc($students))
	{
		$html = '<tr>';
			$html .= '<th scope="row">' . $student_row['student_id'] . '</th>'; 
			$html .= '<td>' . $student_row['first_name'] . '</td>'; 
			$html .= '<td>' . $student_row['last_name'] . '</td>'; 
			$html .= '<td>' . $student_row['sex'] . '</td>'; 
			$html .= '<td>' . $student_row['dob'] . '</td>'; 
			$html .= '<td>' . $student_row['fk_program_id'] . '</td>'; 
			$html .= '<td><a class="btn btn-info" href=' . url_for('admin/student/edit.php?s_id=' . $student_row['student_id']) . '>Edit</a></td>'; 
			$html .= '<td><a class="btn btn-danger" href=' . url_for('admin/student/delete.php?s_id=' . $student_row['student_id']) . '>Delete</a></td>'; 
		$html .= '</tr>';
		echo $html;
	}
  ?>

  </tbody>
</table>

<?php
	include_once(SHARED_PATH . '/main_footer.php');
?>