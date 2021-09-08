<?php

require_once 'connection.php';

$parent_table_name = tableNames::parents;

$create_query = "CREATE TABLE IF NOT EXISTS $parent_table_name (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    phone VARCHAR(15),
    password VARCHAR(255) NOT NULL
)";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $parent_table_name" . mysqli_error($connection);
    die();
}

function create_parent($name, $email, $phone, $password)
{
    global $parent_table_name, $connection;
    $query = "INSERT INTO $parent_table_name (
            name, email, phone, password
        )
        VALUES (
            ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ssss', $name, $email, $phone, $password)) {
            echo "Error Creating parent values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating parent Error: " . $safeQuery->error;
            return false;
        }
        $safeQuery->close();
    } else {
        echo "Error Creating parent Error: " . mysqli_error($connection);
        return false;
    }
    return true;
}

function get_parent($id)
{
    global $parent_table_name, $connection;
    $query = "SELECT * from $parent_table_name WHERE id = ?";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting parent values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error grtting parent Error: " . $safeQuery->error;
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
