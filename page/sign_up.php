<?php
//If name is defined in $_POST, we know that we have sent our form and that we can run the code between the {}

if(isset($_POST['submit']))
{
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    //Get all values from form, via $_POST, that we have chosen method="post", on our forms. We save them in variables with the same name that are on the inputs.
    //We need to secure our site against sql injections, and dangerous signs, such as ', So we use the function mysqli_real_escape_string or $mysqli->escape_string(when it's OOP) and intval to protect the numbers and floatval for numbers with decimals. Use whenever you get data using $_POST, $_GET, or $_SESSION.
    $user_name = $mysqli->escape_string($_POST['name']);
    $user_email = $mysqli->escape_string($_POST['email']);
    $user_password = $mysqli->escape_string($_POST['password']);
    $password_confirm = $mysqli->escape_string($_POST['confirm']);
    $fk_role_id = intval($_POST['role']);

    //If one of the fields is empty, show alert
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm']) || empty($_POST['role']))
    {
        alert('warning', REQUIRED_FIELDS_EMPTY);
    } // If all required fields is not empty, continue
    else {
        // Match users with this email
        $query = "
                                              SELECT 
                                                    login_id 
                                              FROM
                                                    login
                                              WHERE
                                                    user_email = '$user_email'   ";
        $result = $mysqli->query($query);

        // If result returns false, use the function query_error to show debugging info
        if (!$result) {

            query_error($query, __LINE__, __FILE__);
        }

        // If any row(S) was found, the email is not available, so show alert
        if ($result->num_rows > 0) {
            alert('warning', EMAIL_NOT_AVAILABLE);
        } // If email is available, continue
        else {
            // If the typed password isn't the same, show alert
            if ($_POST['password'] != $_POST['confirm']) {
                alert('warning', PASSWORD_MISMATCH);
            } //If the password matched, continue
            else {

                //Use password_hash with the algorithm from the predefined constant PASSWORD_DEFAULT, and default cost
                $password_hash =  password_hash($_POST['password'], PASSWORD_DEFAULT);

                //inserts into database
                $query = "INSERT INTO 
                              login (user_name, user_email, password, fk_user_role_id) 
                          VALUES ('$user_name', '$user_email', '$password_hash', '$fk_role_id')
                              ";

                // If result returns false, use the function query_error to show debugging info
                $result = $mysqli->query($query) or query_error($query, __LINE__, __FILE__);

                //Use a function to insert event in log
                //create_event('create', 'of user <a href="index.php?page=user_create&id' . $user_id . '" data-page="user_create" data-params="id=' . $user_id . '">' . $user_name . '</a>', 100);
                $status = 'You will receive a confirmation email shortly, click on the link to confirm';

              header('Location: ../index.php?page=sign_up' . $status['success']);
               exit();

            }// else for: if ($_POST['password'] != $_POST['confirm'])
        }// else for: if ($result->num_rows > 0) {
    }// else for: if (empty($_POST['name']) || empty($_POST['email']) ||
}// else for: if( isset($_POST['submit']) )

if (isset($_POST))
{
    print_r($_POST);
}
?>

<div class="row">
    <div class="col-lg-12">
        <div class="col-lg-11"><h1 class="page-header">Sign Up</h1></div>
        <h1 class=".col-lg-1 .col-lg-offset-1">
            <a href="index.php?page=home"><button type="reset" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i></button></a>
        </h1>
    </div>

    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-lg-12">
        <h2>
            <?php
            //If there is status in the url parameter, run this code
            if (isset($_GET['status']))
            {
                //If value of status is equal to success, show this message
                if ($_GET['status'] == 'success')
                {
                    echo 'User has been created.';
                }
            }
            ?>
        </h2>
        <form role="form" method="post">
            <div class="form-group">
                <label for="name">Username:</label>
                <input class="form-control" type="text" name="name" value="" placeholder="A name you create yourself" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input class="form-control" type="email" name="email" value="" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input class="form-control" type="password" name="password" value="" required>
            </div>
            <div class="form-group">
                <label for="confirm">Password Confirm:</label>
                <input class="form-control" type="password" name="confirm" value="" required>
            </div>  <div class="form-group">
                <label for="confirm">Password Confirm:</label>
                <input class="form-control" type="password" name="confirm" value="" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select class="form-control" name="role" required>
                    <?php

                    $query_role = "SELECT user_role_id, user_role_name FROM user_role ORDER BY user_role_name DESC";

                    $result_role = $mysqli->query($query_role) or query_error($query_role, __LINE__, __FILE__);

                    // Do while loop to create option for each row in the database
                    while ($row_role = $result_role->fetch_object())
                    {
                        // If the value saved in the $role matches the current rows role_id, add the attribute selected
                        //The role name in the database is a constant, so we use constant() on the value to display the real name from the lang/da_DK.php
                        echo '<option value="' . $row_role->user_role_id . '">' . $row_role->user_role_name . '</option>';
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-default" name="submit">Submit</button>

        </form>
        <br>
    </div><!--end row-->
</div><!--end forside_content-->
