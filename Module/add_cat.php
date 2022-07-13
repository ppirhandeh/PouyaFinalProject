<?php
include '../config.php';
include 'dbMng.php';
include 'functions.php';
require_once '../Strings.php';

checkUserIsValid();
connectToDatabase();


if (count($_GET) && isset($_GET['title']) && !empty($_GET['title'])) {
    $cat_title = $_GET['title'];
    addCategory($cat_title);
    header('location: ../ManageCats.php?message=' . SUCCESS_ADDED_CATEGORY);
    exit;
}
header('location: ../ManageCats.php?message=' . FAIL_ADDED_CATEGORY . '&messageType=warning');
exit;

?>

