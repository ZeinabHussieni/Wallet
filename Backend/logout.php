<?php
session_start();
session_destroy();
header("Location: http://localhost/digital-wallet/Frontend/login.html");
exit;
?>