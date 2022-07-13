<?php
include 'config.php';
include 'Module/dbMng.php';
include 'Module/functions.php';
require_once 'Strings.php';

checkUserIsValid();
connectToDatabase();

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
    <form id="updateUser" class="main" action="Module/edit_user.php" method="post">
        <div class="addNDiv">
            <label for="username"><input id="username" name="username" type="text" value=""
                                         placeholder="<?php echo USERNAME_LABEL; ?>"/></label>
        </div>
        <div class="addNDiv">
            <label for="newUsername"><input id="newUsername" name="newUsername" type="text" value=""
                                            placeholder="<?php echo NEW_USERNAME_LABEL; ?>"/></label>
        </div>
        <div class="addNDiv">
            <label for="oldPassword"><input id="oldPassword" name="oldPassword" type="password" value=""
                                            placeholder="<?php echo OLD_PASSWORD_LABEL; ?>"/></label>
        </div>
        <div class="addNDiv">
            <label for="password">
                <input id="password" name="password" type="password" value=""
                       placeholder="<?php echo PASSWORD_LABEL; ?>"
                       title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters"/>
            </label>
        </div>
        <div class="addNDiv">
            <label for="confirmPassword"><input id="confirmPassword" name="confirmPassword" type="password" value=""
                                                placeholder="<?php echo CONFIRM_PASSWORD_LABEL; ?>"/></label>
        </div>
        <div class="addNDiv">
            <a onclick="submitForm('updateUser',validateForm())">
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
        document.getElementById("username").setAttribute("required", '');
        document.getElementById("oldPassword").setAttribute("required", '');
        if (document.getElementById('password').value.length > 0 ||
            document.getElementById('confirmPassword').value.length > 0) {
            document.getElementById("password").setAttribute("required", '');
            document.getElementById("confirmPassword").setAttribute("required", '');
            document.getElementById("password").setAttribute("minlength", '8');
            document.getElementById("confirmPassword").setAttribute("minlength", '8');
            document.getElementById("password").setAttribute("pattern", "(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{8,}");
        } else {
            document.getElementById("password").removeAttribute("required");
            document.getElementById("confirmPassword").removeAttribute("required");
            document.getElementById("confirmPassword").removeAttribute("minlength");
            document.getElementById("confirmPassword").removeAttribute("minlength");
            document.getElementById("password").removeAttribute("pattern");
        }
        if (document.getElementById('newUsername').value.length > 0) {
            document.getElementById("newUsername").setAttribute("minlength", '5');
            document.getElementById("newUsername").setAttribute("pattern", '[A-Za-z0-9]{5,}');
        } else {
            document.getElementById("newUsername").removeAttribute("minlength");
            document.getElementById("newUsername").removeAttribute("pattern");
        }
        if (document.getElementById('password').value !==
            document.getElementById('confirmPassword').value) {
            document.getElementById("password").setAttribute("class", "invalid");
            document.getElementById("confirmPassword").setAttribute("class", "invalid");
            return false;
        } else {
            document.getElementById("password").removeAttribute("class");
            document.getElementById("confirmPassword").removeAttribute("class");
        }
        return document.getElementById("updateUser").reportValidity();
    }
</script>
</body>
</html>


