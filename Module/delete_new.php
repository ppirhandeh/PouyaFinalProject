<?php
include '../config.php';
include 'dbMng.php';
include 'functions.php';
require_once '../Strings.php';

checkUserIsValid();
connectToDatabase();


if (count($_GET) && isset($_GET['id']) && !empty($_GET['id']) && preg_match("/[0-9]+/i", $_GET['id'])) {
    $newId = $_GET['id'];
    deleteNew($newId);
    header('location: ../ManageNews.php?message=' . SUCCESS_DELETE_NEW);
    exit;
}
header('location: ../ManageNews.php?message=' . FAIL_DELETE_NEW . '&messageType=warning');
exit;

?>