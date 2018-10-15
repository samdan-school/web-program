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
	// Updating Class Enrollment
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		// print_r($_POST['courses']);
		foreach($_POST['courses'] as $input_course)
		{
			if ( ! find_course_enrollment_by_student_and_course_id($id, $input_course) )
			{
				insert_course_enrollment($id, $input_course);
			}
		}

		while ($course = mysqli_fetch_assoc($course_enrollments))
		{
			if( ! in_array( $course['course_id'], $_POST['courses'] ) )
			{
				delete_course_enrollment_by_student_and_course_id($id, $course['course_id']);
			}
		}
		
		mysqli_data_seek($course_enrollments, 0);
		$course = null;
		redirect_to(url_for('/student/index.php?s_id=' . $id));
	}
?>

<?php
	include_once(SHARED_PATH . '/main_header.php');
?>

<div class="page_heading">
	<h1>Hello <?php echo $student['first_name'] . ' ' . $student['last_name']; ?>!</h1>
	<h1>Course Table</h1>
</div>

<form method="POST" action="#">
	<table class="table">
	<thead>
		<tr>
		<th scope="col">Course ID</th>
		<th scope="col">Course Name</th>
		<th scope="col">Credit</th>
		<th scope="col">Enrolled</th>
		</tr>
	</thead>
	<tbody>

	<?php
		$html = '';
		$selected_course = [];
		while ($course_enrollment = mysqli_fetch_assoc($course_enrollments))
		{
			while ($course = mysqli_fetch_assoc($courses))
			{
				if($course['course_id'] == $course_enrollment['course_id'])
				{
					$html .= '<tr class="table-success">';
						$html .= '<th scope="row">' . $course['course_id'] . '</th>'; 
						$html .= '<td>' . $course['course_name'] . '</td>'; 
						$html .= '<td>' . $course['credit'] . '</td>'; 
						$html .= '<td><input name="courses[]" checked type="checkbox" value="'. $course['course_id'] .'" />';
					$html .= '</tr>';
					array_push($selected_course, $course['course_id']);
					break;
				}
			}
		}

		mysqli_data_seek($courses, 0);
		while ($course = mysqli_fetch_assoc($courses))
		{
			if( ! in_array( $course['course_id'], $selected_course ) )
			{
				$html .= '<tr>';
					$html .= '<th scope="row">' . $course['course_id'] . '</th>'; 
					$html .= '<td>' . $course['course_name'] . '</td>'; 
					$html .= '<td>' . $course['credit'] . '</td>'; 
					$html .= '<td><input name="courses[]" type="checkbox"  value="'. $course['course_id'] .'" />';
				$html .= '</tr>';
			}
		}
		echo $html;
		?>

	</tbody>
	</table>
	<input type="submit" value="Save">
</form>

<?php
	include_once(SHARED_PATH . '/main_footer.php');
?>