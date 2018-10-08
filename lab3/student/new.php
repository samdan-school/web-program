<?php
	require_once('./logic/initialize.php');
?>

<?php
	include_once(SHARED_PATH . '/main_header.php');

	$students = find_all_students();
?>

<?php
	include_once(SHARED_PATH . '/main_footer.php');
?>