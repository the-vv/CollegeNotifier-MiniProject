<?php

require 'connection.php';
// TODO: add referemce to owner_id
$TableName = 'college';
$create_query = "CREATE TABLE IF NOT EXISTS $TableName (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    owner_id INT(6) NOT NULL
    college_name VARCHAR(200) NOT NULL,
    college_address VARCHAR(200) NOT NULL,
    website VARCHAR(200),
    phone VARCHAR(10) NOT NULL,
    FOREIGN KEY (owner_id) REFERENCES admins(id)
)";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $TableName" . mysqli_error($connection);
    die();
}

function create_college($name = '', $address = '', $website = '', $phone = '')
{
    global $TableName, $connection;
    $query = "INSERT INTO $TableName (
            college_name, college_address, website, phone
        )
        VALUES (
            ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ssss', $name, $address, $website, $phone)) {
            echo "Error Creating college values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating college Error: " . $safeQuery->error;
            return false;
        }
        $safeQuery->close();
    } else {
        echo "Error Creating college Error: " . mysqli_error($connection);
        return false;
    }
    return true;
}

function get_college($id)
{
    global $TableName, $connection;
    $query = "SELECT * from $TableName WHERE id = ?";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting college values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error grtting college Error: " . $safeQuery->error;
            return false;
        }
        $res = $safeQuery->get_result();
        $results = array();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
    }
    return $results;
}

var_dump(get_college(1));