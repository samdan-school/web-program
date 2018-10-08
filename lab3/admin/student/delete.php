<?php
	require_once('../../logic/initialize.php');

	// Checking there is id
	if (!isset($_GET['s_id'])) {
		redirect_to(url_for('/admin/index.php'));
	}
	$id = $_GET['s_id'];
?>

<?php
	if ( is_post_request() )
	{
		echo "HEllo";
		delete_student($id);	
		redirect_to(url_for('/admin/index.php'));
	}
?>

<?php
	include_once(SHARED_PATH . '/main_header.php');
?>

<div class="page_heading">
	<a href="<?php echo url_for('/admin/index.php'); ?>" class="btn btn-primary float-left btn-left">Back</a>
	<h1>Delete Student</h1>
</div>

<form action="#" method="POST">	
	<button name="delete" type="submit" class="btn btn-danger btn-block">Delete</button>
</form>

<?php
	include_once(SHARED_PATH . '/main_footer.php');
?>