<?php
  ob_start(); // output buffering is turned on

  session_start(); // turn on session

  define("LOGIC_PATH", dirname(__FILE__));
  define("SHARED_PATH", LOGIC_PATH . '/shared');

  define("WWW_ROOT", "");

  require_once('functions.php');

  require_once('pdo_database.php');
  require_once('pdo_query_functions.php');

  require_once('database.php');
  require_once('query_functions.php');
  
  require_once('validation_functions.php');
  require_once('auth_functions.php');

  $db = db_connect();
  $errors = [];

?>
