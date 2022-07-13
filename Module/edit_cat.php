<?php
include '../config.php';
include 'dbMng.php';
include 'functions.php';
require_once '../Strings.php';

checkUserIsValid();
connectToDatabase();


if (count($_GET) && isset($_GET['id']) && !empty($_GET['id']) && preg_match("/[0-9]+/i", $_GET['id'])) {
    if (isset($_GET['title']) && $_GET['title'] != "") {
        $catId = $_GET['id'];
        $catTitle = $_GET['title'];
        updateCategory($catId, $catTitle);
        header('location: ../ManageCats.php?message=' . SUCCESS_UPDATE_CATEGORY);
        exit;
    }
}
header('location: ../ManageCats.php?message=' . FAIL_UPDATE_CATEGORY . '&messageType=warning');
exit;

?>