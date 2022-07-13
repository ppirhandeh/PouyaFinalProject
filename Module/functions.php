<?php
include 'Strings.php';

//validate User if login before
function checkUserIsValid()
{
    session_start();
    if (!isset($_SESSION['is_valid']) || !$_SESSION['is_valid']) {
        header('location: index.php?message=' . UNAUTHORIZED_ACCESS . '&messageType=warning');
        exit;
    }
}

//get first of news body for preview
function getPreview($body)
{
    return str_replace("&nbsp;", '<br/>', "<p>" . str_split(strip_tags($body), 400)[0] . "</p>");
}

?>