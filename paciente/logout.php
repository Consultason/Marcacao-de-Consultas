<?php
session_start();
session_unset();
session_destroy();
header("Location: ../pagina_de_login/login.html");
exit;
?>
