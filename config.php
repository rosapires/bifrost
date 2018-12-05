<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02/12/18
 * Time: 12:38
 */
//session_start();

define('DEVELOPER_STATUS', true);
define('PAGE_LENGTH',       6);

// if developer status is true/enabled
if (DEVELOPER_STATUS)
{//set error_reporting to E_ALL (default on XAMPP), which display all errors
    error_reporting(E_ALL);
}
else
{//turn off all error_reporting
    error_reporting(0);
}

require 'functions/functions.php';
require 'functions/select_functions.php';
require 'includes/da_DK.php';

//config for db
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'puffin_project_db';

//connect to db
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

//check for connnection error
if($mysqli->connect_error)
{
    connect_error($mysqli->connect_errno, $mysqli->connect_error, __LINE__, __FILE__);
}

//set chartset from db text to utf8
$mysqli->set_charset('utf8');

//set the server to danish names for the date and times
$mysqli->query("SET lc_time_names = 'da_DK'");

//Array with options for page length
$page_lengths =
    [
        '1'         => 1,
        '2'         => 2,
        '10'        => 10,
        '25'        => 25,
        '50'        => 50,
        '100'        => 100
    ];

//Start output buffer via function ob_start(), to prevent warnings, for example "cannot modify heading information".
ob_start()
?>