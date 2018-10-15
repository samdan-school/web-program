<!doctype html>

<html lang="en">
  <head>
    <title>Student App <?php if(isset($page_title)) { echo '- ' . h($page_title); } ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<?php echo url_for('static/stylesheet/bootstrap.css'); ?>" />
    <link rel="stylesheet" media="all" href="<?php echo url_for('static/stylesheet/main.css'); ?>" />
  </head>

  <body>
	<div class="container-fluid">
	<div class="row">

	<div>
		<header>
		<h1>
			<a href="<?php echo url_for('/admin/index.php'); ?>">
			<img src="<?php echo url_for('/static/images/sisi_logo.png'); ?>" width="150" height="90" alt="" />
			</a>
		</h1>
		<?php include_once SHARED_PATH . '/main_navigation.php'; ?>
		</header>
	</div>

	<div class="col">
	<!-- Main content starts here -->
	<main>