<?php
include '../config.php';
include 'dbMng.php';
include 'functions.php';
require_once '../Strings.php';

checkUserIsValid();
connectToDatabase();


if (count($_GET) && isset($_GET['id']) && !empty($_GET['id']) && preg_match("/[0-9]+/i", $_GET['id'])) {
    $catId = $_GET['id'];
    deleteCategory($catId);
    header('location: ../ManageCats.php?message=' . SUCCESS_DELETE_CATEGORY);
    exit;
}
header('location: ../ManageCats.php?message=' . FAIL_DELETE_CATEGORY . '&messageType=warning');
exit;

?>