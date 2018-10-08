<?php
  ob_start(); // output buffering is turned on

  session_start(); // turn on session

  define("ROOT_PATH", dirname(__FILE__));
  define("PROJECT_PATH", dirname(ROOT_PATH));
  define("STATIC_PATH", PROJECT_PATH . '/static');
  define("SHARED_PATH", ROOT_PATH . '/shared');

  $public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
  $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
  define("WWW_ROOT", $doc_root);

  require_once('functions.php');
  require_once('database.php');
  require_once('query_functions.php');
  require_once('validation_functions.php');
//   require_once('auth_functions.php');

  $db = db_connect();
  $errors = [];

?>
