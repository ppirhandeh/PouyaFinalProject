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
    <title>Documentation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide%7COpen+Sans%7CTrirong%7CKarla">
    <link rel="stylesheet" href="Styles.css"/>
    <script src="JS/JS.js"></script>
</head>

<body class="MainBody">
<div class="header" role="banner">
    <h1>Documentation</h1>
</div>

<div class="Body">

    <?php if (!isset($_SESSION['is_valid'])) { ?>
        <form id="login" class="login" action="Module/login.php" method="post">
            <a href="index.php"><?php echo HOME_BUTTON; ?></a>
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
        </div>
    <?php } ?>

    <div role="article" aria-labelledby="title" aria-describedby="body" class="main">
        <h2 class="newsTitle" id="title">News Website Project</h2>
        <div class="newsBody" id="body">
            <p>This project is about a news website that gives users the chance to post news in different
                categories.</p>
            <h3>Design</h3>
            <p>This project contains two parts: <b>main and management</b>.</p>
            <p>In the main part, home page and the pages related to each news have been designed. In this part, there
                are two menus for categorizing the news and another menu for entering the website and options for
                exiting to the management part.</p>
            <p>These two pages are responsive, and they&rsquo;ve been designed as <b>mobile-first design</b> which use
                two
                breakpoints with 480px and 768px and it changes like the pictures below:</p>
            <div style="max-width: 100%;   border: 1px solid black;">
                <img src="img/Documentation/break%20points.png" alt="break points"
                     style="max-width: 100%; object-fit: contain;   ">
            </div>
            <p>There is a <a href="index.php#slider">slider</a> containing 5 slides as a <b>keyframe</b> at the top of
                the <a
                        href="index.php">first page</a>. Its pictures and links
                can be changes in the management part. For designing this slider, these resources has been used:</p>
            <ul>
                <li><a href="https://www.smashingmagazine.com/2012/04/pure-css3-cycling-slideshow/">https://www.smashingmagazine.com/2012/04/pure-css3-cycling-slideshow/</a>
                </li>
                <li><a href="https://unsplash.com/photos/H6eaxcGNQbU">Picture A</a></li>
                <li><a href="https://unsplash.com/photos/iFSvn82XfGo">Picture B</a></li>
                <li><a href="https://unsplash.com/photos/c5QdMcuFlgY">Picture C</a></li>
                <li><a href="https://unsplash.com/photos/WYd_PkCa1BY">Picture D</a></li>
                <li><a href="https://unsplash.com/photos/_Zua2hyvTBk">Picture E</a></li>
            </ul>
            <h3>Management section features</h3>
            <p>This section has 4 separate parts,
                <a href="ManageCats.php">managing the categories</a>,
                <a href
                   ="ManageNews.php">managing news</a>,
                <a href
                   ="ManageSlider.php">managing slides</a> and
                <a href
                   ="ManageUser.php" a>user security</a>.
            </p>
            <p>In the categories management section, we can define a new category or change the name of an existing one.
                If the category of one the news gets removed, the category value for that news changes to null.</p>
            <div style="max-width: 100%;   border: 1px solid pink;">
                <img src="img/Documentation/ManageCatsPage.PNG" alt="Manage Categories Page"
                     style="max-width: 100%; object-fit: contain;   ">
            </div>
            <p>In the news management section, we can edit the past news or delete them or create a new one by clicking
                on the &ldquo;+&rdquo; sign.</p>
            <div style="max-width: 100%;   border: 1px solid black;">
                <img src="img/Documentation/ManageNewsPage.PNG" alt="Manage News Page"
                     style="max-width: 100%; object-fit: contain;   ">
            </div>
            <p>In the slider management section, we can edit the 5 pictures of the slider, the title and the link
                related to it. For doing this, we need to select a picture and define the title and the link and click
                the &ldquo;done&rdquo; button.</p>
            <div style="max-width: 100%;   border: 1px solid black;">
                <img src="img/Documentation/ManageSliderPage.PNG" alt="Manage Slider Page"
                     style="max-width: 100%; object-fit: contain;   ">
            </div>
            <p>In the user security section, we can make a new username and password for the user which they are &ldquo;admin&rdquo;
                and &ldquo;12345678&rdquo; (in order) by default. The username must be at least 5 characters that can be
                letters or numbers and the password must be at least 8 characters containing one lower case and one
                upper case letter and one number.</p>
            <div style="max-width: 100%;   border: 1px solid black;">
                <img src="img/Documentation/ManageUserPage.PNG" alt="Manage User Security Page"
                     style="max-width: 100%; object-fit: contain;   ">
            </div>
            <p>For the menus and buttons, all the pages use a <b>CSS transition</b> animation for a better user
                experience.</p>
            <p>All the forms get validates on the user side and in case of a problem, a red border will be displayed
                around the related field and the instructions will be showed to the user.</p>
            <div style="max-width: 100%;   border: 1px solid black;">
                <img src="img/Documentation/ValidationClientSideExample.png" alt="Client Side Validation Form Example"
                     style="max-width: 100%; object-fit: contain;   ">
            </div>
            <p>In this project, 10 icons have been used for user interface which have been downloaded from the below
                links:</p>
            <table class="myTable">
                <thead>
                <tr>
                    <th>src</th>
                    <th>icon</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <a href="https://www.flaticon.com/free-icon/menu-button-of-three-horizontal-lines_56763">https://www.flaticon.com/free-icon/menu-button-of-three-horizontal-lines_56763</a>
                    </td>
                    <td>
                        <div style="max-width: 100%;   border: 1px solid black;">
                            <img src="img/list.png" alt="List Icon"
                                 style="max-width: 100%; object-fit: contain;   ">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="https://www.flaticon.com/free-icon/dots-menu_17704">https://www.flaticon.com/free-icon/dots-menu_17704</a>
                    </td>
                    <td>
                        <div style="max-width: 100%;   border: 1px solid black;">
                            <img src="img/grid.png" alt="Grid Icon"
                                 style="max-width: 100%; object-fit: contain;   ">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="https://www.flaticon.com/free-icon/edit_1827933">https://www.flaticon.com/free-icon/edit_1827933</a>
                    </td>
                    <td>
                        <div style="max-width: 100%;   border: 1px solid black;">
                            <img src="img/edit.png" alt="Edit Icon"
                                 style="max-width: 100%; object-fit: contain;   ">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="https://www.flaticon.com/free-icon/done_7179748">https://www.flaticon.com/free-icon/done_7179748</a>
                    </td>
                    <td>
                        <div style="max-width: 100%;   border: 1px solid black;">
                            <img src="img/done.png" alt="Done Icon"
                                 style="max-width: 100%; object-fit: contain;   ">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="https://www.flaticon.com/premium-icon/failed_4131516">https://www.flaticon.com/premium-icon/failed_4131516</a>
                    </td>
                    <td>
                        <div style="max-width: 100%;   border: 1px solid black;">
                            <img src="img/deletePic.png" alt="Delete Image Icon"
                                 style="max-width: 100%; object-fit: contain;   ">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="https://www.flaticon.com/free-icon/trash_3096687">https://www.flaticon.com/free-icon/trash_3096687</a>
                    </td>
                    <td>
                        <div style="max-width: 100%;   border: 1px solid black;">
                            <img src="img/trash.png" alt="Delete Icon"
                                 style="max-width: 100%; object-fit: contain;   ">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="https://www.flaticon.com/premium-icon/new_4131800">https://www.flaticon.com/premium-icon/new_4131800</a>
                    </td>
                    <td>
                        <div style="max-width: 100%;   border: 1px solid black;">
                            <img src="img/newPicDone.png" alt="Selected Image Icon"
                                 style="max-width: 100%; object-fit: contain;   ">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="https://www.flaticon.com/premium-icon/new_4131597">https://www.flaticon.com/premium-icon/new_4131597</a>
                    </td>
                    <td>
                        <div style="max-width: 100%;   border: 1px solid black;">
                            <img src="img/newPic.png" alt="Select Image Icon"
                                 style="max-width: 100%; object-fit: contain;   ">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="https://www.flaticon.com/free-icon/magnifier_64673">https://www.flaticon.com/free-icon/magnifier_64673</a>
                    </td>
                    <td>
                        <div style="max-width: 100%;   border: 1px solid black;">
                            <img src="img/magnifier.png" alt="Search Icon"
                                 style="max-width: 100%; object-fit: contain;   ">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="https://www.flaticon.com/premium-icon/new-page_4202611">https://www.flaticon.com/premium-icon/new-page_4202611</a>
                    </td>
                    <td>
                        <div style="max-width: 100%;   border: 1px solid black;">
                            <img src="img/new.png" alt="Adding Icon"
                                 style="max-width: 100%; object-fit: contain;   ">
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <p>For the <b>painting</b>, MaterialUI system has been used which can be accessed through the below link:
            </p>
            <a href="https://material.io/design/color/the-color-system.html#color-theme-creation">https://material.io/design/color/the-color-system.html</a>
            <p>For writing the text of the website, the <b>fonts</b> Karla, Trirong, Open Sans and Audiowide have been
                used.
                For writing the news text, a HTML editor has been used called TinyMCE that can be accessed through the
                following link:</p>
            <a href="https://www.tiny.cloud">https://www.tiny.cloud</a>
            <p>I designed the website in a way that it has the <b>ARIA tags</b> so that access is easier for disabled
                people.</p>
            <h2>Running</h2>
            <p>The program filing has been shown in the below picture with an explanation of each step.</p>
            <div style="max-width: 100%;   border: 1px solid black;">
                <img src="img/Documentation/ProjectDirectories.PNG" alt="Project Directories"
                     style="max-width: 100%; object-fit: contain;   ">
            </div>
            <ul>
                <li>Root: In this part, the main pages of the website and the CSS files have been saved.</li>
                <li>Img: in this directory, the mentioned icons that have been used in the website, are saved.</li>
                <li>JS: in this directory, there is file called Javascript which is for the general functions of the
                    pages.
                </li>
                <li>Module: In this directory, PHP modules, which are used for reading and editing the site, have been
                    saved.
                </li>
                <li>News_image: In this directory, the related thumbnail for each news will be saved.</li>
                <li>Slider: In this directory, the related images for each news will be saved.</li>
                <li>tinyMCE: In this directory, extension and editor files for HTML have been saved.</li>
            </ul>
            <ol>
                <li>Setting Files:</li>
                <ol style="lower-alpha;">
                    <li>Config.php: In this file, the necessary settings for connecting to the database is saved.
                    </li>
                    <li>String.php: All the strings in this website are in this file which can be used to change the
                        language of the website to any chosen LTR languages.
                    </li>
                </ol>
                <li>Styling files:</li>
                <ol style="lower-alpha;">
                    <li>Style.css: All the styles used in all pages is saved in this file. All the colors and fonts
                        are defined as variables at the beginning of the file so they can be changed easily.
                    </li>
                    <div style="max-width: 100%;   border: 1px solid black;">
                        <img src="img/Documentation/StylesCSSFile.png" alt="First of Style.Css File"
                             style="max-width: 100%; object-fit: contain;   ">
                    </div>
                    <li>Slider.css: In this file, styles and keyframes for the slider are saved and they are only
                        used in the main pages of the website.
                    </li>
                </ol>
                <li>Pages Files:</li>
                <ol style="lower-alpha;">
                    <li>Index.php: The main page and the home page are designed in this file. The search and the news
                        preview changing parts have not been designed but the code can be found in the commented area.
                    </li>
                    <li>MangeCats.php: In this file, the catagoriess management is designed.</li>
                    <li>MangeNews.php: In this file, the news management is designed.</li>
                    <li>MangeSlider.php: In this file, the slider management is designed.</li>
                    <li>MangeUser.php: In this file, the user and password changing is designed.</li>
                    <li>New.php: In this file, writing a news or editing one is designed.</li>
                    <li>showNew.php: In this file, showing the whole news is designed.</li>
                </ol>
                <li>Website Modules: In this section, we&rsquo;ll go through the files directory for the module.</li>
                <ol style="lower-alpha;">
                    <li>dbMng.php: All the dependencies of database and SQL codes are defined in this file.</li>
                    <li>Functions.php: The function for validating the user and realizing the authority of a user to
                        access the management section of the site, is in this file.
                    </li>
                    <li>Add_cat.php, edit_cat.php, delete_cat.php: These files by receiving the needed variables
                        through Get or Post methods and by using dbMng functions, will do the CRUD actions on the
                        categories.
                    </li>
                    <li>Add_new.php, edit_new.php, delete_new.php: These files by receiving the needed variables
                        through Get or Post methods and by using dbMng functions, will do the CRUD actions on the news.
                    </li>
                    <li>edit_slider.php: These files by receiving the needed variables through Get or Post methods
                        and by using updateSlider function in the dbmng file, will do the update action on the slider.
                    </li>
                    <li>edit_User.php: These files by receiving the needed variables through Get or Post methods and
                        by using updatePassword and updateUsername functions in the dbmng file, will do the update
                        action on the user.
                    </li>
                    <li>login.php, logout.php: These two file by reading the database and making a feature on the
                        Session global variable, gives the authority to the user to access the management section and
                        logout file, will remove this feature and the user&rsquo;s authority.
                    </li>
                </ol>
            </ol>
            <p>All the respond messages will be shown to the user through Get method using a popup message that created
                by JavaScript.</p>
            <h2>Security:</h2>
            <p>All the forms will be <b>validated on the client side</b> first and if even one attacker sends data
                directly to the modules, all the received fields through Get and Post methods will be <b>checked with
                    regex</b>. All the defined SQL queries on the project will be set on the database in a <b>prepared
                    SQL</b> format. User
                <b>authorization</b> is checked by session and if user is unauthorized, all requests will be rejected.
            </p>
            <h2>Data</h2>
            <p>The database for this website is based on 4 tables as the following:</p>
            <ul>
                <li>Categories: This table has id and title columns that they show id and title in the database.</li>
                <li>News: This table has id, cat_id, title and body columns. The body column is the text of the news.
                </li>
                <li>Slider: This table has id, title and link columns.</li>
                <li>Users: This table has userID, name and pass columns.</li>
            </ul>
            <p>Here you can find the news used for testing the website:</p>
            <a href="https://www.cnn.com/world/live-news/world-cup-draw-qatar-2022-spt-intl/index.html">https://www.cnn.com/world/live-news/world-cup-draw-qatar-2022-spt-intl/index.html</a>
            <a href="https://www.cnn.com/2022/04/01/europe/russia-ukraine-belgorod-fire-intl/index.html">https://www.cnn.com/2022/04/01/europe/russia-ukraine-belgorod-fire-intl/index.html</a>
            <h2>Validating the website</h2>
            <p>Index.html</p>
            <div style="max-width: 100%;   border: 1px solid black;">
                <img src="img/Documentation/ValidateIndexHTML.PNG" alt="Validate index.html Page"
                     style="max-width: 100%; object-fit: contain;   ">
            </div>
            <p>ManageUser.html</p>
            <div style="max-width: 100%;   border: 1px solid black;">
                <img src="img/Documentation/ValidateManageUserHTML.PNG" alt="Validate ManageUser.html Page"
                     style="max-width: 100%; object-fit: contain;   ">
            </div>
            <p>ShowNew.html</p>
            <div style="max-width: 100%;   border: 1px solid black;">
                <img src="img/Documentation/ValidateShowNewHTML.PNG" alt="Validate ShowNew.html Page"
                     style="max-width: 100%; object-fit: contain;   ">
            </div>
            <p>ManageNews.html</p>
            <div style="max-width: 100%;   border: 1px solid black;">
                <img src="img/Documentation/ValidateManageNewsHTML.PNG" alt="Validate ManageNews.html Page"
                     style="max-width: 100%; object-fit: contain;   ">
            </div>
            <p>New.html</p>
            <div style="max-width: 100%;   border: 1px solid black;">
                <img src="img/Documentation/ValidateNewHTML.PNG" alt="Validate New.html Page"
                     style="max-width: 100%; object-fit: contain;   ">
            </div>
            <p>ManageCats.html</p>
            <div style="max-width: 100%;   border: 1px solid black;">
                <img src="img/Documentation/ValidateManageCatsHTML.PNG" alt="Validate ManageCats.html Page"
                     style="max-width: 100%; object-fit: contain;   ">
            </div>
            <p>ManageSlider.html</p>
            <div style="max-width: 100%;   border: 1px solid black;">
                <img src="img/Documentation/ValidateManageSliderHTML.PNG" alt="Validate ManageSlider.html Page"
                     style="max-width: 100%; object-fit: contain;   ">
            </div>
            <p>Slider.css</p>
            <div style="max-width: 100%;   border: 1px solid black;">
                <img src="img/Documentation/ValidateSliderCSS.PNG" alt="Validate Slider.css File"
                     style="max-width: 100%; object-fit: contain;   ">
            </div>
            <p>Styles.css</p>
            <div style="max-width: 100%;   border: 1px solid black;">
                <img src="img/Documentation/ValidateStylesCSS.PNG" alt="Validate Styles.css File"
                     style="max-width: 100%; object-fit: contain;   ">
            </div>
            <h3>Designed By PP.</h3>
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