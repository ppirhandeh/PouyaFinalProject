<?php
include '../config.php';
include 'dbMng.php';
require_once '../Strings.php';

connectToDatabase();
session_start();

if (count($_POST)) {
    $res = validateLogin($_POST['username'], md5($_POST['password']));
    if ($res->rowCount() == 1) {
        $_SESSION['is_valid'] = 1;
        header('location: ../index.php?message=' . SUCCESS_LOGIN);
        exit;
    }
}
header('location: ../index.php?message=' . FAIL_LOGIN . '&messageType=warning');
exit;
?>