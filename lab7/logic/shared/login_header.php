<!doctype html>

<html lang="en">
  <head>
    <title>Student App <?php if (isset($page_title)) {
    echo '- '.h($page_title);
} ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<?php echo url_for('static/stylesheet/bootstrap.css'); ?>" />
    <link rel="stylesheet" media="all" href="<?php echo url_for('static/stylesheet/main.css'); ?>" />
		<script src="<?php echo url_for('static/javascript/my.js'); ?>"></script>
  </head>

  <body>
	<div class="container-fluid">
	<div class="row">

	<div>
		<header>
		</header>
	</div>

	<div class="col">
	<!-- Main content starts here -->
	<main>