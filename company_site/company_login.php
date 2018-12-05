<?php
require_once('../config.php');

//If already signed in, go to index.php
if (isset($_SESSION['user']['id']))
{
    header('Location: index.php');
    exit;
}
?>

    <!doctype html>
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

        <title>Log In</title>

    </head>
    <body>
    <?php

    //if it is set you go to this page
    if(isset($_SESSION['user_id']))
    {
        header('Location:index.php');
        exit;
    }
    //Login form
    //IMPORTANT! the name on the input fields should not match the name in the database!
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <?php

                        if(isset($_POST['email']))
                        {
                            if (login($_POST['email'], $_POST['password']))
                            {
                                header('Location: index.php');
                                exit;
                            }
                        }

                        ?>

                        <form method="post" role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <!--<div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>-->
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </body>
    </html>
<?php ob_end_flush(); ?>