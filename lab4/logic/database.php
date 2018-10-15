<?php
  function db_connect()
  {
      $connection = mysqli_connect('localhost', 'root', '', 'student_app_04');
      confirm_db_connect();
      return $connection;
  }

  function db_disconnect($connection)
  {
      if (isset($connection)) {
          mysqli_close($connection);
      }
  }

  function db_escape($connection, $string)
  {
      return mysqli_real_escape_string($connection, $string);
  }

  function confirm_db_connect()
  {
      if (mysqli_connect_errno()) {
          $msg = 'Database connection failed: ';
          $msg .= mysqli_connect_error();
          $msg .= ' (' . mysqli_connect_errno() . ')';
          exit($msg);
      }
  }

  function confirm_result_set($result_set)
  {
      if (!$result_set) {
          exit('Database query failed.');
      }
  }
