<?php
include '../config.php';
include 'dbMng.php';
include 'functions.php';
require_once '../Strings.php';

checkUserIsValid();
connectToDatabase();
if (count($_POST) && isset($_POST['cat_id']) && !empty($_POST['cat_id']) && preg_match("/[0-9]+/i", $_POST['cat_id'])) {
    addNews($_POST['title'], $_POST['cat_id'], $_POST['body']);
    $newsId = getLastAddedNews();
    if (isset($_FILES['img']) && $_FILES['img']['size']) {
        move_uploaded_file($_FILES['img']['tmp_name'], "../news_image/" . $newsId . "." . pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
    }
    header('location: ../ManageNews.php?message=' . SUCCESS_ADDED_NEW);
    exit;
}
header('location: ../ManageNews.php?message=' . FAIL_ADDED_NEW . '&messageType=warning');
exit;
