<?php
	function find_course_enrollment_by_student_and_course_id($s_id, $c_id)
	{
		global $pdo_connection;
		
		$result = $pdo_connection->prepare('SELECT * FROM course_enrollment WHERE student_id = :s_id AND course_id = :c_id LIMIT 1');
		$result->execute([':s_id' => $s_id, ':c_id' => $c_id ]);

		return $result->fetch();
	}

	function insert_course_enrollment($s_id, $c_id)
	{
		global $pdo_connection;
		
		$pdo_connection->prepare('INSERT INTO course_enrollment (student_id, course_id) VALUES ( :s_id , :c_id )')->execute([':s_id' => $s_id, ':c_id' => $c_id ]);
	}

	function delete_course_enrollment_by_student_and_course_id($s_id, $c_id)
	{
		global $pdo_connection;
		
		$pdo_connection->prepare('DELETE FROM course_enrollment WHERE student_id = :s_id AND course_id = :c_id LIMIT 1')->execute([':s_id' => $s_id, ':c_id' => $c_id ]);
	}
?>