<?php

require_once 'connection.php';

$TableName = 'admins';

$create_query = "CREATE TABLE IF NOT EXISTS $TableName (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(10),
        admin_password VARCHAR(255) NOT NULL
    )";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $TableName " . mysqli_error($connection);
    die();
}

function create_admin($name = '', $email = '', $phone = '', $admin_password)
{
    global $TableName, $connection;
    if(count(find_admin_user($email))) {
        return array("error" => true, "message" => "User Already Exists, Please Login");
    }
    $query = "INSERT INTO $TableName (
            name, email, phone, admin_password
        )
        VALUES (
            ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ssss',$name, $email, $phone, $admin_password)) {
            echo "Error Creating Admin values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating Admin Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
        return find_admin_user($email);
    } else {
        echo "Error Creating Admin Error: " . mysqli_error($connection);
        return array("error" => true, "message" => "Unknown Error Occured");
    }
    return true;
}

function get_admin($id)
{
    global $TableName, $connection;
    $query = "SELECT * from $TableName WHERE id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting Admin values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error getting Admin Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => "Unknown Error occured");
}

function find_admin_user($email)
{
    global $TableName, $connection;
    $query = "SELECT * from $TableName WHERE email = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $email)) {
            echo "Error getting Admin values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error getting Admin Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => "Unknown Error occured");
}
