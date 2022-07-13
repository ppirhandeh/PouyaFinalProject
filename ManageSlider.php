<?php
include 'config.php';
include 'Module/dbMng.php';
include 'Module/functions.php';
require_once 'Strings.php';

checkUserIsValid();
connectToDatabase();

//get slider titles and links from db;
$slider = getSlider();

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
                <th><?php echo TABLE_SLIDER_TITLE_LABEL; ?></th>
                <th><?php echo TABLE_SLIDER_LINK_LABEL; ?></th>
                <th><?php echo TABLE_OPERATION_LABEL; ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($slider as $i => $slider_item) { ?>
                <form id="<?php echo $i ?>" action="Module/edit_Slider.php" method="post" enctype="multipart/form-data">

                    <tr>
                        <td><input class="shortInput" name="id" type="text" value="<?php echo $slider_item['id'] ?>"
                                   readonly></td>
                        <td><input class="mediumInput" name="title" type="text"
                                   value="<?php echo $slider_item['title'] ?>"></td>
                        <td><input name="link" type="text" value="<?php echo $slider_item['link'] ?>"></td>
                        <td>
                            <label class="imgFile" for="img"><img id="imgIcon" class="icon"
                                                                  alt="<?php echo NEW_PICTURE_LABEL; ?>"
                                                                  src="img/newPic.png"/></label>
                            <input style="width: 0;" type="file" name="img" id="img" onchange="changePickFileIcon();"
                                   accept="image/*">
                            <a onclick="editSlider('<?php echo $i ?>')">
                                <img class="icon" alt="<?php echo EDIT_LABEL; ?>" src="img/done.png"/>
                            </a>
                        </td>
                    </tr>
                </form>

            <?php } ?>
            </tbody>
        </table>
    </div>
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
    function changePickFileIcon() {
        var e = document.getElementById("imgIcon");
        e.setAttribute("src", "img/newPicDone.png")
    }

    function editSlider(id) {
        if (confirmMessage('<?php echo CONFIRM_MESSAGE; ?>')) {
            submitForm(id, true);
        }
    }
</script>
</body>
</html>
