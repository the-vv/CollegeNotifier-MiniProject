<?php

require 'connection.php';

$TableName = 'departments';
$create_query = "CREATE TABLE IF NOT EXISTS $TableName (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    college_id INT(6) UNSIGNED REFERENCES college(id),
    dpt_name VARCHAR(200) NOT NULL,
    category VARCHAR(100)
)";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $TableName" . mysqli_error($connection);
    die();
}

function create_dpt($cid = '', $name = '', $category = '')
{
    global $TableName, $connection;
    $query = "INSERT INTO $TableName (
            college_id, dpt_name, category
        )
        VALUES (
            ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('sss', $cid, $name, $category)) {
            echo "Error Creating department values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating department Error: " . $safeQuery->error;
            return false;
        }
        $safeQuery->close();
    } else {
        echo "Error Creating department Error: " . mysqli_error($connection);
        return false;
    }
    return true;
}

function get_dpt($id)
{
    global $TableName, $connection;
    $query = "SELECT * from $TableName WHERE id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting department values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error getting department Error: " . $safeQuery->error;
            return false;
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return false;
}
