<?php
	require_once('../logic/initialize.php');

	// Checking there is id
	if (!isset($_GET['s_id'])) {
		redirect_to(url_for('/student/login.php'));
	}
	$id = $_GET['s_id'];
	$student = find_student_by_id($id);

	$courses = find_all_course();
	$course_enrollments = find_all_course_enrollment_by_student_id($id);
?>

<?php
	include_once(SHARED_PATH . '/main_header.php');
?>

<div class="page_heading">
	<h1>Hello <?php echo $student['first_name'] . ' ' . $student['last_name']; ?>!</h1>
	<h1>Course Table</h1>
</div>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Student ID</th>
      <th scope="col">Last Name</th>
      <th scope="col">First Name</th>
      <th scope="col">Sex</th>
      <th scope="col">Data of Birth</th>
      <th scope="col">Program</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>

  <?php 
	while ($course_enrollment = mysqli_fetch_assoc($course_enrollments))
	{
		print_r($course_enrollment);
		while ($course = mysqli_fetch_assoc($courses))
		{
			if($course['course_id'] == $course_enrollment['course_id'])
			{
				$html = '<tr>';
					$html .= '<th scope="row">' . $course['course_id'] . '</th>'; 
					$html .= '<td>' . $course['course_name'] . '</td>'; 
					$html .= '<td>' . $course['credit'] . '</td>'; 
				$html .= '</tr>';
				echo $html;
			}
		}
	}
  ?>

  </tbody>
</table>


<?php
	include_once(SHARED_PATH . '/main_footer.php');
?>