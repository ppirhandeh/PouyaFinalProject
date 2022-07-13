<?php
require_once '../Strings.php';

session_start();

session_destroy();
header('location: ../index.php?message=' . SUCCESS_LOGOUT);
exit;
?>