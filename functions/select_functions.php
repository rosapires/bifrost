<?php

function select_all_from_students()
{
    global $mysqli;

    $data = array();

    $query = "
            SELECT name, image_file_name, email, phone, portfolio_link
            FROM students
            ";
    $result = $mysqli->query($query);

    if(!$result)
    {
        query_error($query, __LINE__, __FILE__);
    }

    while($row = $result->fetch_object())
    {
        $data[] = $row;
    }
    return $data;
}