<?php

function connectToDatabase()
{
    global $_connection;
    $connectionString = 'mysql:host=' . DBHOST . ';dbname=' . DBNAME;
    try {
        $_connection = new PDO($connectionString, DBUSER, DBPASS);
        $_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

function validateLogin($user, $pass)
{
    global $_connection;
    $sql = "SELECT UserID FROM users where Name=:username and Pass=:password";
    $statement = $_connection->prepare($sql);
    $statement->bindValue(':username', $user, PDO::PARAM_STR);
    $statement->bindValue(':password', $pass, PDO::PARAM_STR);
    $statement->execute();
    return $statement;
}

function updatePassword($new_password, $user_id)
{
    global $_connection;
    $sql = "update users set  Pass=:password where UserID=:uid";
    $statement = $_connection->prepare($sql);
    $statement->bindValue(':password', $new_password, PDO::PARAM_STR);
    $statement->bindValue(':uid', $user_id, PDO::PARAM_INT);
    $statement->execute();
    return true;
}

function updateUsername($new_username, $user_id)
{
    global $_connection;
    $sql = "update users set  Name=:username where UserID=:uid";
    $statement = $_connection->prepare($sql);
    $statement->bindValue(':username', $new_username, PDO::PARAM_STR);
    $statement->bindValue(':uid', $user_id, PDO::PARAM_INT);
    $statement->execute();
    return true;

}

function getAllCategories()
{
    global $_connection;
    $sql = "SELECT * FROM categories order by id";
    $statement = $_connection->prepare($sql);
    $statement->execute();
    $ret = array();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
        $ret[] = $row;
    return $ret;
}

function addCategory($cat_name)
{
    global $_connection;
    $sql = "insert into categories (title) values (:title)";
    $statement = $_connection->prepare($sql);
    $statement->bindValue(':title', $cat_name, PDO::PARAM_STR);
    $statement->execute();
    return true;
}

function deleteCategory($cat_id)
{
    global $_connection;
    $sql = "delete from categories where id=:cid";
    $statement = $_connection->prepare($sql);
    $statement->bindValue(':cid', $cat_id, PDO::PARAM_INT);
    $statement->execute();
    return true;
}

function updateSlider($slider_id, $title, $link)
{
    global $_connection;
    $sql = "update slider set title=:title,link=:link where id=:sid;";
    $statement = $_connection->prepare($sql);
    $statement->bindValue(':title', $title, PDO::PARAM_STR);
    $statement->bindValue(':link', $link, PDO::PARAM_STR);
    $statement->bindValue(':sid', $slider_id, PDO::PARAM_INT);
    $statement->execute();
    return true;
}


function updateCategory($cat_id, $cat_name)
{
    global $_connection;
    $sql = "update categories set title=:title where id=:cid";
    $statement = $_connection->prepare($sql);
    $statement->bindValue(':title', $cat_name, PDO::PARAM_STR);
    $statement->bindValue(':cid', $cat_id, PDO::PARAM_INT);
    $statement->execute();
    return true;
}

function getAllNewsCount()
{
    global $_connection;
    $sql = "SELECT COUNT(id) as c FROM news";
    $statement = $_connection->prepare($sql);
    $statement->execute();
    $ret = $statement->fetch();
    return $ret[0];
}


function getNewsCount($cat_id)
{
    if ($cat_id == "0")
        return getAllNewsCount();
    global $_connection;
    $sql = "SELECT COUNT(id) as c FROM news where cat_id=:cid";
    $statement = $_connection->prepare($sql);
    $statement->bindValue(':cid', $cat_id, PDO::PARAM_INT);
    $statement->execute();
    $ret = $statement->fetch();
    return $ret[0];
}

function getSlider()
{
    global $_connection;
    $sql = "SELECT * FROM slider order by id ASC;";
    $statement = $_connection->prepare($sql);
    $statement->execute();
    $ret = array();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
        $ret[] = $row;
    return $ret;
}

function getNews($page, $cat_id, $count)
{
    if ($cat_id == "0")
        return getAllNews($page, $count);

    global $_connection;
    $start = ($page - 1) * $count;
    $sql = "SELECT * FROM news where cat_id=:cid order by id DESC LIMIT :startIndex ,:c;";
    $statement = $_connection->prepare($sql);
    $statement->bindValue(':cid', $cat_id, PDO::PARAM_INT);
    $statement->bindValue(':startIndex', $start, PDO::PARAM_INT);
    $statement->bindValue(':c', $count, PDO::PARAM_INT);
    $statement->execute();
    $ret = array();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
        $ret[] = $row;
    return $ret;
}

function getAllNews($page, $count)
{
    global $_connection;
    $start = ($page - 1) * $count;
    $sql = "SELECT * FROM news order by id DESC LIMIT :startIndex , :c ;";
    $statement = $_connection->prepare($sql);
    $statement->bindValue(':startIndex', $start, PDO::PARAM_INT);
    $statement->bindValue(':c', $count, PDO::PARAM_INT);
    $statement->execute();
    $ret = array();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
        $ret[] = $row;
    return $ret;
}

function deleteNew($news_id)
{
    global $_connection;
    $sql = "delete from news where id=:newsID";
    $statement = $_connection->prepare($sql);
    $statement->bindValue(':newsID', $news_id, PDO::PARAM_INT);
    $statement->execute();
    return true;
}

function addNews($title, $cat_id, $body)
{
    global $_connection;
    $sql = "insert into news (title, cat_id, body) values (:title,:cid,:body)";
    $statement = $_connection->prepare($sql);
    $statement->bindValue(':title', $title, PDO::PARAM_STR);
    $statement->bindValue(':cid', $cat_id, PDO::PARAM_INT);
    $statement->bindValue(':body', $body, PDO::PARAM_STR);
    $statement->execute();
    return true;
}

function getLastAddedNews()
{
    global $_connection;
    $sql = "SELECT id FROM news order by id desc";
    $statement = $_connection->prepare($sql);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    return $row['id'];
}

function getNewByID($news_id)
{
    global $_connection;
    $sql = "SELECT * FROM news where id=:nid";
    $statement = $_connection->prepare($sql);
    $statement->bindValue(':nid', $news_id, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function updateNews($news_id, $title, $cat_id, $body)
{
    global $_connection;
    $sql = "update news set title=:title, cat_id=:cid, body=:body where id=:nid";
    $statement = $_connection->prepare($sql);
    $statement->bindValue(':title', $title, PDO::PARAM_STR);
    $statement->bindValue(':cid', $cat_id, PDO::PARAM_INT);
    $statement->bindValue(':body', $body, PDO::PARAM_STR);
    $statement->bindValue(':nid', $news_id, PDO::PARAM_INT);
    $statement->execute();
    return true;
}

?>