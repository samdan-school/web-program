<?php
    require_once './logic/initialize.php';

    $id = $_SESSION['student_id'];
    require_login_student();

    $student = find_student_by_id($id);

    $courses = find_all_course();
    $course_enrollments = find_all_course_enrollment_by_student_id($id);
?>

<?php
    // Updating Class Enrollment
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // print_r($_POST['courses']);
        foreach ($_POST['courses'] as $input_course) {
            if (!find_course_enrollment_by_student_and_course_id($id, $input_course)) {
                insert_course_enrollment($id, $input_course);
            }
        }

        while ($course = mysqli_fetch_assoc($course_enrollments)) {
            if (!in_array($course['course_id'], $_POST['courses'])) {
                delete_course_enrollment_by_student_and_course_id($id, $course['course_id']);
            }
        }

        mysqli_data_seek($course_enrollments, 0);
        $course = null;
        redirect_to(url_for('/index.php?s_id='.$id));
    }
?>

<?php
    include_once SHARED_PATH.'/main_header.php';
?>

<div class="page_heading">
	<h1>Hello <?php echo $student['first_name'].' '.$student['last_name']; ?>!</h1>
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
	<tbody id="courses-table">
    <input id="all" type="button" value="Бүх хичээлийг харуулах">
    <input id="program" type="button" value="Мэрэгжлийн хичээлийг харуулах">
	</tbody>
	</table>
	<input type="submit" value="Хадаглах">
</form>
<input id="confirm" type="button" value="Баталгаажуулах">
<div id="confirm_box"></div>

<script>
var selectedCourses = [];
    window.onload = function() {
        getLessonEnrolled('<?php echo $id; ?>');

        document.getElementById('all').addEventListener('click', () => {
            getLessonEnrolled('<?php echo $id; ?>');
        });

        document.getElementById('program').addEventListener('click', () => {
            getProgramCourse('<?php echo $id; ?>');
        });
    }
    
</script>

<?php
    include_once SHARED_PATH.'/main_footer.php';
?>