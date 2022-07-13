<?php
include '../config.php';
include 'dbMng.php';
require_once '../Strings.php';

connectToDatabase();
session_start();
$res1 = true;
$res2 = true;
if (count($_POST)) {
    var_dump($_POST);
    if (isset($_POST['username']) && !empty($_POST['username'])) {
        if (isset($_POST['oldPassword']) && !empty($_POST['oldPassword'])) {
            $res = validateLogin($_POST['username'], md5($_POST['oldPassword']));
            if ($res->rowCount() == 1)
                $id = $res->fetch(PDO::FETCH_ASSOC)['UserID'];
            else
                $res1 = $res2 = false;
            if (isset($id) && isset($_POST['password']) && strlen($_POST['password']) >= 8) {
                $res2 = updatePassword(md5($_POST['password']), $id);
            }
            if (isset($id) && isset($_POST['newUsername']) && strlen($_POST['newUsername']) >= 5) {
                $res1 = updateUsername($_POST['newUsername'], $id);
            }
        }
    }
}
if ($res1 && $res2) {
    header('location: ../ManageUser.php?message=' . SUCCESS_UPDATE_USER);
    exit;
}
header('location: ../ManageUser.php?message=' . FAIL_UPDATE_USER . '&messageType=warning');
exit;
//25d55ad283aa400af464c76d713c07ad
?>
