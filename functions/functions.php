<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02/12/18
 * Time: 13:18
 */

//shows alerts in color and makes the message more clear
function alert($type, $message)
{
    ?>
    <div class="alert alert-<?php echo $type ?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-lable="Close">
            <span aria-hidden="true">x</span>
        </button><?php echo $message; ?>
    </div>
    <?php
}

//Shows connection errors and precisely where they are
function connect_error($error_no, $error, $line_number, $file_name)
{
    if(DEVELOPER_STATUS)
    {
        die('<p>Connection ('. $error_no .'): '. $error .'</p><p>Line number: ' . $line_number . '</p><p>File: '. $file_name .' </p>');
    }
    else
    {
        die(CONNECT_ERROR);
    }
}

//Shows the errors in an SQL statement more clearly so that it's easier to debug
function query_error($query, $line_number, $file_name)
{
    if(DEVELOPER_STATUS)
    {
        global $mysqli;

        $message =
            '<strong>' . $mysqli->error . '</strong><br><strong>
		Line:'.$line_number.'</strong><br><strong>
		File:'.$file_name.'</strong><pre class="prettyprint lang-sql linenums"><code>' . $query . '</code></pre>';

        alert('danger', $message);
        $mysqli->close();
    }
    else
    {
        global $mysqli;
        alert('danger', 'sql error');
        $mysqli->close();
    }
}
function login($email, $password)
{
    // If one of the required fields is empty, show alert
    if(empty($email) || empty($password))
    {
        alert('warning', 'You must fill both fields.');
    }
    // If all required fields is not empty, continue
    else
    {
        global $mysqli;

        $email = $mysqli->escape_string($email);

        $query = "
                    SELECT 
                            login_id, user_name, password, user_role_name
                    FROM 
                            login
                    INNER JOIN
                            user_role ON login.fk_user_role_id = user_role.user_role_id
                    WHERE 
                            user_name = '$email'
                            ";
        $result = $mysqli->query($query);

        // If result returns false, use the function query_error to show debugging info
        if(!$result)
        {

            query_error($query, __LINE__, __FILE__);
        }

        //If a user with they typed email was found in the database, do this
        if($result->num_rows == 1)
        {
            $row = $result->fetch_object();

            // Check if the typed password matched the hashed password in the Database
            if(password_verify($password, $row->user_password))
            {
                // Give the current session a new id before saving user information into it
                session_regenerate_id();

                $_SESSION['user']['id']                 = $row->user_id;
                $_SESSION['user']['access_level']       = $row->role_access_level;
                $_SESSION['fingerprint']                = fingerprint();

                //Use a function to insert event in log
                //create_event('info', '<a href="index.php?page=login&id' . $row->user_id . '" data-page="login" data-params="id=' . $row->user_id . ' ">' . $row->user_name . '</a>' . ' logged in', 100);

                return true;
            }
            // If the typed password isn't a match to the hashed password in the database
            else
            {
                alert('warning', 'Email or password is invalid.');
            }
        }
        // If no user with the typed email was found in the database, do this
        else
        {
            alert('warning', 'Email or password is invalid' . '2');
        }
    }
    return false;
}

// Delete the sessions from login and give the session a new id
function logout()
{
    unset($_SESSION['user']);
    unset($_SESSION['fingerprint']);
    unset($_SESSION['last_activity']);

    // Give the current session a new id before saving user information into it
    session_regenerate_id();
}

// Take the user agent info from the browser, add a salt and hash the information with the algorithm sha256
function fingerprint()
{
    return hash('sha256', $_SERVER['HTTP_USER_AGENT'] . '%wr?Ã¸V/sd)b*<sf#');
}

function check_fingerprint()
{
    // If the current fingerprint returned from the function doesn't match the fingerprint stored in session, logout!
    if ($_SESSION['fingerprint'] != fingerprint())
    {
        logout();
        ?>
        <script type="text/javascript">
            location.href='login.php';
        </script>
        <?php
        exit;
    }
}
