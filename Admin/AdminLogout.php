<?php
session_start();

// Destroy all session variables
session_destroy();

// Redirect to home page
echo "<script>window.open('../index.html','_self')</script>";
?>
