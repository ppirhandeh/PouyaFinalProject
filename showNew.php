<?php

include 'config.php';
include 'Module/dbMng.php';
include 'Module/functions.php';
require_once 'Strings.php';

session_start();

connectToDatabase();
if (count($_GET) && isset($_GET['id']) && !empty($_GET['id']))
    $news = getNewByID($_GET['id']);

$cats = getAllCategories();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title><?php echo TITLE; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide%7COpen+Sans%7CTrirong%7CKarla">
    <link rel="stylesheet" href="Styles.css"/>
    <script src="JS/JS.js"></script>
</head>

<body class="MainBody">
<div class="header" role="banner">
    <h1><?php echo TITLE; ?></h1>
</div>

<div class="Body">

    <?php if (!isset($_SESSION['is_valid'])) { ?>
        <form id="login" class="login" action="Module/login.php" method="post">
            <a href="index.php"><?php echo HOME_BUTTON; ?></a>
            <a href="Documentation.php">Documentation</a>
            <label for="username"><input id="username" name="username" type="text" value=""
                                         placeholder="<?php echo USERNAME_LABEL; ?>"/></label>
            <label for="password"><input id="password" name="password" type="password" value=""
                                         placeholder="<?php echo PASSWORD_LABEL; ?>"/></label>
            <a onclick="submitForm('login',validateLogin());"><?php echo LOGIN_BUTTON; ?></a>
        </form>
    <?php } elseif (count($_SESSION) && $_SESSION['is_valid'] == 1) { ?>
        <div class="menu" role="navigation" aria-label="Main Pages">
            <a href="index.php"><?php echo HOME_BUTTON; ?></a>
            <a href="ManageCats.php" target="_self"><?php echo MANAGE_BUTTON; ?></a>
            <a href="Module/logout.php"><?php echo LOGOUT_BUTTON; ?></a>
            <a href="Documentation.php">Documentation</a>
        </div>
    <?php } ?>

    <div role="article" aria-labelledby="title" aria-describedby="body" class="main">
        <h2 class="newsTitle" id="title"><?php echo $news['title'] ?></h2>
        <?php $id = $news['id'];
        if (count(glob("news_image/" . $id . ".*")) == 1) { ?>
            <img alt="<?php echo $news['title'] ?>" class="imgBoxShowNew" role="img"
                 src="<?php echo glob("news_image/" . $id . ".*")[0] ?>"/>
        <?php } ?>
        <div class="newsBody" id="body">
            <p><?php echo $news['body'] ?></p>
        </div>
    </div>

    <div id="cats" class="cats" role="complementary" aria-label="Categories">
        <a onclick="changeVisibleCatMenu(showMenu)"><h2><?php echo CATEGORIES_TITLE; ?></h2></a>
        <?php foreach ($cats as $i => $cat) { ?>
            <a class="catItem" href="?page=1&id=<?php echo $cat['id'] ?>"><?php echo $cat['title'] ?></a>
        <?php } ?>
    </div>

</div>

<div class="footer" role="contentinfo"><?php echo FOOTER; ?></div>


</body>
<script>
    <?php if (count($_GET) && isset($_GET['message']) && $_GET['message'] != "") { ?>
    showMessage("<?php echo $_GET['message'];?>"
        <?php if (isset($_GET['messageType']) && $_GET['messageType'] === "warning") { ?>
        , 'warning'
        <?php } else { ?>
        , 'information'
        <?php } ?>
    );
    <?php } ?>
    let showMenu = {value: true};

    function validateLogin() {
        document.getElementById("username").setAttribute("required", '');
        document.getElementById("password").setAttribute("required", '');
        return document.getElementById("login").reportValidity();
    }
</script>

</html>