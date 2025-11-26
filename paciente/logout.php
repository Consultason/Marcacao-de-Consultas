<?php
session_start();
session_unset();
session_destroy();

// volta ao login
header("Location: ../login/login.html");
exit;
?>
