<?php
require '../config.php';

//if logout is defined in URL params, run function for logout
if (isset($_GET['logout']))
{
    //logout();
    header('Location: index.php');
    exit;
}

//require 'admin/includes/lib/WideImage.php';

if (isset($_GET['page']))
{
    $page = $_GET['page'];
}
else
{
    $page = 'student_home';
}
$page_path = 'page/'. $page . '.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php
    //I used something similar to create breadcrumbs, for the title, because the variable $page is already here I got rid of the GET and just adjusted the variable with str_replace() and ucwords() to remove the underscore and add the capital letters
    ?>

    <title><?php echo ucwords(str_replace('_', ' ', $page)) ?></title>

    <!-- Bootstrap Core CSS
    <link href="admin/assets/startbootstrap-modern-business-gh-pages/css/bootstrap.min.css" rel="stylesheet">-->

    <!-- Custom CSS
    <link href="admin/assets/startbootstrap-modern-business-gh-pages/css/modern-business.css" rel="stylesheet">

    <!-- Prettify CSS
    <link href="admin/assets/google-code-prettify/prettify.css" rel="stylesheet" type="text/css">
    <!-- Prettify JavaScript
    <script type="text/javascript" src="admin/assets/google-code-prettify/prettify.js"></script>

    <!-- Custom Fonts
    <link href="admin/assets/startbootstrap-sb-admin-2-gh-pages/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Customized CSS -->
    <link href="../css/style.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>

    <!-- CKEditor
    <script src="admin/assets/ckeditor-4.5.1/ckeditor.js"></script>
    <script>CKEDITOR.dtd.$removeEmpty['span'] = false;</script> <!-- Sikrer at tomme spans ikke fjernes i editor, da de bruges til font awesome ikoner -->

   <!-- <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>-->

    <![endif]-->

</head>

<body> <!--onload="prettyPrint()"-->

<div class="container">
    <header>
        <?php
        include '../includes/header.php'
        ?>
    </header>


    <?php

    if (file_exists($page_path))
    {
        include($page_path);
    }
    else
    {
        echo 'Fejl: siden kunne ikke findes!';
    }


    ?>

    <?php
    //show_developer_info();
    ?>
    <footer>
        <?php
        include '../includes/footer.php';
        ?>
    </footer>
</div>


<!-- jQuery
<script src="admin/assets/startbootstrap-modern-business-gh-pages/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript
<script src="admin/assets/startbootstrap-modern-business-gh-pages/js/bootstrap.min.js"></script>-->


</body>

</html>
<?php
//Empty output buffer, when all html is generated to prevent performance problems on the server.
ob_end_flush();

// Close access to database to avoid to many open relations.
$mysqli->close();
?>
