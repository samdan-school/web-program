</main>
<!-- Main content ends here -->
</div>
</div> 
<!-- Row ends here -->
</div>
<!-- container fluid ends here -->


<script src="<?php echo url_for('static/javascript/jquery.js'); ?>">
<script src="<?php echo url_for('static/javascript/popper.js'); ?>">
<script src="<?php echo url_for('static/javascript/bootstrap.js'); ?>">
<script src="<?php echo url_for('static/javascript/main.js'); ?>">
<footer>
  &copy; <?php echo date('Y'); ?> Student App
</footer>

</body>
</html>

<?php
  db_disconnect($db);
  global $pdo_connection;
  $pdo_connection = null;
?>
