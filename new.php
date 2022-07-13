<?php
include 'config.php';
include 'Module/dbMng.php';
include 'Module/functions.php';
require_once 'Strings.php';

checkUserIsValid();
connectToDatabase();

//get slider titles and links from db;
$cats = getAllCategories();
//if getting an id with Get request page shown in edit mode
$edit_mode = false;
if (count($_GET)) {
    if (isset($_GET['id']) && $_GET['id'] != "") {
        $edit_mode = true;
        $newsId = $_GET['id'];
        $newsData = getNewByID($newsId);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title><?php echo MANAGE_PAGE_TITLE ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="Styles.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide%7COpen+Sans%7CTrirong%7CKarla">
    <script src="tinymce/tinymce.min.js"></script>
    <script src="JS/JS.js"></script>
</head>

<body class="MainBody">

<div class="header" role="banner">
    <h1><?php echo MANAGE_PAGE_TITLE ?></h1>
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
    <form id="new" class="main" method="post" enctype="multipart/form-data"
        <?php if ($edit_mode) { ?>
            action="Module/edit_new.php"
        <?php } else { ?>
            action="Module/add_new.php"
        <?php } ?> >
        <?php if ($edit_mode) { ?>
            <div class="addNDiv">
                <label for="id"><?php echo TABLE_ID_LABEL; ?></label>
                <input type="text" name="id" id="id"
                       value="<?php echo $newsId ?>" readonly/>
            </div>
        <?php } ?>

        <div class="addNDiv">
            <label for="title"><?php echo NEW_TITLE_LABEL; ?></label>
            <input type="text" name="title" id="title"
                <?php if ($edit_mode) { ?>
                    value="<?php echo $newsData['title'] ?>"
                <?php } ?>
            />
        </div>


        <div class="addNDiv">
            <label for="cat_id"><?php echo CATEGORY_LABEL; ?></label>
            <select name="cat_id" id="cat_id">
                <?php foreach ($cats as $cat) { ?>
                    <option value="<?php echo $cat['id'] ?>"
                        <?php if ($edit_mode) { ?>
                            <?php if ($cat['id'] == $newsData['cat_id']) { ?>
                                selected
                            <?php } ?>
                        <?php } ?>
                    ><?php echo $cat['title'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="addNDiv ">
            <label for="img"><?php if ($edit_mode) echo NEW_PICTURE_LABEL; else echo PICTURE_LABEL; ?></label>
            <input type="file" name="img" id="img" accept="image/*"/>
        </div>
        <?php if ($edit_mode) { ?>
            <?php if (count(glob("news_image/" . $newsId . ".*")) == 1) { ?>
                <img class="imgBox" src="<?php echo glob("news_image/" . $newsId . ".*")[0] ?>"
                     alt="<?php echo $newsData['title'] ?>"/>
            <?php } ?>
        <?php } ?>
        <div class="textarea" id="textBody">
            <label for="Editor"><textarea id="Editor" name="body">
                <?php if ($edit_mode) { ?>
                    <?php echo $newsData['body'] ?>
                <?php } ?>
            </textarea></label>
        </div>
        <div class="addNDiv">
            <a onclick="submitForm('new',validateForm())">
                <img class="icon" alt="<?php echo DONE_LABEL; ?>" src="img/done.png"/>
            </a>
        </div>

    </form>
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

    function validateForm() {
        document.getElementById("title").setAttribute("required", '');
        let content = tinymce.get("Editor").getContent();
        if (content === "") {
            document.getElementById("textBody").setAttribute("class", "invalid");
            return false;
        } else {
            document.getElementById("textBody").setAttribute("class", "");
        }
        return document.getElementById("new").reportValidity();
    }
</script>
<script>
    tinymce.init({
        menubar: false,
        selector: "textarea",
        plugins: [
            "lists link image emoticons hr table textcolor code"],
        toolbar: "undo redo code | styleselect removeformat | bold italic | superscript subscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor",
        branding: false
    });
</script>
</body>
</html>


