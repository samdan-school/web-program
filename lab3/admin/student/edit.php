<?php
	require_once('../../logic/initialize.php');
?>

<?php
	include_once(SHARED_PATH . '/main_header.php');

	$students = find_all_students();
?>

<div class="page_heading">
	<a href="<?php echo url_for('/admin/index.php'); ?>" class="btn btn-primary float-left btn-left">Back</a>
	<h1>Edit Student</h1>
</div>

<?php
	include_once(SHARED_PATH . '/main_footer.php');
?>