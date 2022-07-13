<?php
include '../config.php';
include 'dbMng.php';
include 'functions.php';
require_once '../Strings.php';

checkUserIsValid();
connectToDatabase();
if (count($_POST) && isset($_POST['id']) && !empty($_POST['id']) && preg_match("/[0-9]+/i", $_POST['id'])) {
    updateSlider($_POST['id'], $_POST['title'], $_POST['link']);
    if (isset($_FILES['img']) && $_FILES['img']['size']) {
        move_uploaded_file($_FILES['img']['tmp_name'], "../Slider/" . $_POST['id'] . "." . pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
    }
    header('location: ../ManageSlider.php?message=' . SUCCESS_UPDATE_SLIDER);
    exit;
}
header('location: ../ManageSlider.php?message=' . FAIL_UPDATE_SLIDER . '&messageType=warning');
exit;
