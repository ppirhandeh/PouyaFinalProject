<?php
include 'config.php';
include 'Module/dbMng.php';
include 'Module/functions.php';
require_once 'Strings.php';

checkUserIsValid();
connectToDatabase();

//get list of categories from db
$cats = getAllCategories();

?>
<!DOCTYPE html>
<html lang="en">
<head>
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
                <th><?php echo TABLE_ROW_LABEL; ?></th>
                <th><?php echo TABLE_ID_LABEL; ?></th>
                <th><?php echo TABLE_CATEGORY_NAME_LABEL; ?></th>
                <th><?php echo TABLE_OPERATION_LABEL; ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cats as $i => $cat) { ?>
                <tr>
                    <form id="<?php echo $i ?>" action="Module/edit_cat.php" method="get">
                        <td><?php echo $i + 1 ?></td>
                        <td><input name="id" type="text" value="<?php echo $cat['id'] ?>" readonly></td>
                        <td><input name="title" type="text" value="<?php echo $cat['title'] ?>" required></td>
                        <td>
                            <a onclick="editCat('<?php echo $i ?>')">
                                <img class="icon" alt="<?php echo EDIT_LABEL; ?>" src="img/done.png"/>
                            </a>
                            <a href="Module/delete_cat.php?id=<?php echo $cat['id'] ?>"
                               onclick="return confirmMessage('<?php echo CONFIRM_MESSAGE; ?>')">
                                <img class=" icon" alt="<?php echo DELETE_LABEL; ?>" src="img/trash.png"/>
                            </a>
                        </td>
                    </form>
                </tr>
                <?php
            }
            ?>
            <tr>
                <form id="addNewCat" action="Module/add_cat.php" method="get">
                    <td><?php echo $i + 2 ?></td>
                    <td></td>
                    <td><input type="text" id="newCat" name="title" value=""/></td>
                    <td>
                        <a onclick="addCat('<?php echo $i ?>')"><img class="icon" alt="<?php echo ADD_LABEL; ?>"
                                                                     src="img/new.png"/>
                        </a>
                    </td>
                </form>
            </tr>
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
    function editCat(cat_id) {
        if (confirmMessage('<?php echo CONFIRM_MESSAGE; ?>')) {
            if (document.getElementById(cat_id).reportValidity())
                submitForm(cat_id);
        }
    }

    function addCat() {
        if (confirmMessage('<?php echo CONFIRM_MESSAGE; ?>')) {
            document.getElementById("newCat").setAttribute("required", '');
            if (document.getElementById("addNewCat").reportValidity())
                submitForm("addNewCat");
        }
    }
</script>

</body>
</html>
