<?php

include 'config.php';
include 'Module/dbMng.php';
include 'Module/functions.php';
require_once 'Strings.php';

session_start();
connectToDatabase();

//get list of categories from db
$cats = getAllCategories();
//set default value if user wont select a category
$cat_id = "0";
//set default value if user wont select a page
$page = "1";
//set default value for page type and news per page if user wont select a type of list
$pageType = "list";
$countPerPage = 5;

//set values if parameter present in request
if (count($_GET) && isset($_GET['id']) && !empty($_GET['id']) && preg_match("/[0-9]+/i", $_GET['id']))
    $cat_id = $_GET['id'];
if (count($_GET) && isset($_GET['page']) && !empty($_GET['page']) && preg_match("/[0-9]+/i", $_GET['page']))
    $page = $_GET['page'];
if (count($_GET) && isset($_GET['type']) && !empty($_GET['type']) && !empty($_GET['type']) && preg_match("/list|grid/i", $_GET['type'])) {
    $pageType = $_GET['type'];
    if ($pageType == "list")
        $countPerPage = 5;
    else
        $countPerPage = 15;
}

//how many pages we have
if (getNewsCount($cat_id) % $countPerPage == 0)
    $pages = getNewsCount($cat_id) / $countPerPage;
else
    $pages = getNewsCount($cat_id) / $countPerPage + 1;
//if page was wrong set default
if ($page > $pages || $page < 1)
    $page = 1;
//get news from db
$news = getNews($page, $cat_id, $countPerPage);
//get slider titles and links from db;
$slider = getSlider();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title><?php echo TITLE; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide%7COpen+Sans%7CTrirong%7CKarla">
    <link rel="stylesheet" href="Styles.css"/>
    <link rel="stylesheet" href="Slider.css"/>
    <script src="JS/JS.js"></script>
</head>

<body class="MainBody">
<div class="header" role="banner">
    <h1><?php echo TITLE; ?></h1>
</div>
<div class="slider" role="alertdialog" id="slider">
    <div class="mask">
        <ul>
            <?php foreach ($slider as $i => $slider_item) { ?>
                <li id="<?php echo $slider_item['id']; ?>" class="animation<?php echo $slider_item['id']; ?>">
                    <a href="<?php echo $slider_item['link']; ?>"> <img
                                src="Slider/<?php echo $slider_item['id']; ?>.jpg"
                                alt="<?php echo $slider_item['title']; ?>"/> </a>
                    <div class="tooltip"><h1><?php echo $slider_item['title']; ?></h1></div>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="progress-bar"></div>
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
    <div class="main">
        <!--        <div class="topBar">-->
        <!--            <div class="listType">-->
        <!--                <a href="?page=1&id=--><?php //echo $cat_id ?><!--&type=list"-->
        <!--                   target="_self"><img class="searchBarItem" src="img/list.png" alt="-->
        <?php //echo LIST_LABEL; ?><!--"></a>-->
        <!--                <a href="?page=1&id=--><?php //echo $cat_id ?><!--&type=grid"-->
        <!--                   target="_self"><img class="searchBarItem" src="img/grid.png" alt="-->
        <?php //echo GRID_LABEL; ?><!--"></a>-->
        <!--            </div>-->
        <!--            <div class="searchBar" role="searchbox">-->
        <!--                <input class="searchInput" type="text" placeholder="--><?php //echo SEARCH_HIT; ?><!--">-->
        <!--                <a><img class="searchBarItem" src="img/magnifier.png" alt="-->
        <?php //echo SEARCH_LABEL; ?><!--"></a>-->
        <!--            </div>-->
        <!--        </div>-->
        <div class="newDiv" role="feed" aria-busy="false">
            <?php foreach ($news as $i => $new) { ?>
                <div class="newBox" role="article" aria-posinset="<?php echo $i ?>"
                     aria-setsize="<?php echo $countPerPage ?>"
                     aria-labelledby="link-<?php echo $i ?>" aria-describedby="preview-<?php echo $i ?>">
                    <div class="linkPreview" id="new-<?php echo $i ?>">
                        <div class="newLink" id="link-<?php echo $i ?>"><a title="<?php echo $new['title'] ?>"
                                                                           href="showNew.php?id=<?php echo $new['id'] ?>">
                                <h2><?php echo $new['title'] ?></h2></a>
                        </div>
                        <div class="newPreview"
                             id="preview-<?php echo $i ?>"><?php echo getPreview($new['body']); ?></div>
                    </div>
                    <?php if (count(glob("news_image/" . $new['id'] . ".*")) == 1) { ?>
                        <a role="figure" class="imgBox" title="<?php echo $new['title'] ?>"
                           href="showNew.php?id=<?php echo $new['id'] ?>">
                            <img src="<?php echo glob("news_image/" . $new['id'] . ".*")[0] ?>"
                                 alt="<?php echo $new['title'] ?>"/></a>

                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <div id="cats" class="cats" role="complementary" aria-label="Categories">
        <a onclick="changeVisibleCatMenu(showMenu)"><h2><?php echo CATEGORIES_TITLE; ?></h2></a>
        <?php foreach ($cats as $i => $cat) { ?>
            <a class="catItem" href="?page=1&id=<?php echo $cat['id'] ?>"><?php echo $cat['title'] ?></a>
        <?php } ?>
    </div>
</div>
<div class="pageButtonDiv">
    <?php for ($i = 1; $i <= $pages; $i++) { ?>
        <div class="pageButton"><a
                    href="?page=<?php echo $i ?>&id=<?php echo $cat_id ?>&type=<?php echo $pageType; ?>"
                    target="_self"><?php echo $i ?></a></div>
    <?php } ?>
</div>
<div class="footer" role="contentinfo"><?php echo FOOTER; ?></div>


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
</body>
</html>