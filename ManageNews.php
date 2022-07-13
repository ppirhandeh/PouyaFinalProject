<?php
include 'config.php';
include 'Module/dbMng.php';
include 'Module/functions.php';
require_once 'Strings.php';

checkUserIsValid();
connectToDatabase();

//set values if parameter present in request
if (count($_GET) && isset($_GET['page']) && !empty($_GET['page']))
    $news = getAllNews($_GET['page'], 10);
else
    $news = getAllNews(1, 10);

//how many pages we have
if (getNewsCount(0) % 5 == 0)
    $pages = getNewsCount(0) / 10;
else
    $pages = getNewsCount(0) / 10 + 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title><?php echo MANAGE_PAGE_TITLE; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="Styles.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide%7COpen+Sans%7CTrirong%7CKarla">
    <script src="JS/JS.js"></script>
</head>

<body class="MainBody">

<div class="header" role="banner">
    <h1><?php echo MANAGE_PAGE_TITLE; ?></h1>
</div>

<div class="Body">
    <div class="menu" role="navigation" aria-label="Main Pages">
        <a href="index.php"><?php echo HOME_BUTTON; ?></a>
        <a href="ManageCats.php"><?php echo MANAGE_CATEGORIES_BUTTON; ?></a>
        <a href="ManageNews.php"><?php echo MANAGE_NEWS_BUTTON; ?></a>
        <a href="ManageSlider.php"><?php echo MANAGE_SLIDER_BUTTON; ?></a>
        <a href="ManageUser.php"><?php echo MANAGE_USER_BUTTON; ?></a>
        <a href="Module/logout.php"><?php echo LOGOUT_BUTTON; ?></a>
    </div>
    <div class="main">
        <table class="myTable">
            <thead>
            <tr>
                <th><?php echo TABLE_ID_LABEL; ?></th>
                <th><?php echo TABLE_NEWS_TITLE_LABEL; ?></th>
                <th><?php echo TABLE_OPERATION_LABEL; ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <a href="new.php"><img class="icon" alt="<?php echo ADD_LABEL ?>" src="img/new.png"/></a>
                </td>
            </tr>
            <?php foreach ($news as $i => $new) { ?>
                <tr>
                    <td><?php echo $new['id'] ?></td>
                    <td><h5 href=""><?php echo $new['title'] ?></h5></td>
                    <td>
                        <a href="new.php?id=<?php echo $new['id'] ?>">
                            <img class="icon" alt="<?php echo EDIT_LABEL; ?>" src="img/edit.png"/>
                        </a>
                        <a href="Module/delete_new.php?id=<?php echo $new['id'] ?>""
                        onclick="return confirmMessage('<?php echo CONFIRM_MESSAGE; ?>')">
                        <img class=" icon" alt="<?php echo DELETE_LABEL; ?>" src="img/trash.png"/>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="pageButtonDiv">
    <?php for ($i = 1; $i <= $pages; $i++) { ?>
        <div class="pageButton"><a href="?page=<?php echo $i ?>" target="_self"><?php echo $i ?></a></div>
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
    <?php } ?></script>
</body>
</html>
