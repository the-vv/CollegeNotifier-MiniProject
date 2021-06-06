<?php

require 'connection.php';

$TableName = 'admins';

$create_query = "CREATE TABLE IF NOT EXISTS $TableName (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        dpt_id INT(6) UNSIGNED,
        college_id INT(6) UNSIGNED,
        batch_id INT(6) UNSIGNED,
        class_id INT(6) UNSIGNED,
        admin_level INT(1) UNSIGNED,
        admin_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(10),
        admin_password VARCHAR(255) NOT NULL,
        FOREIGN KEY (dpt_id) REFERENCES departments(id),
        FOREIGN KEY (college_id) REFERENCES college(id),
        FOREIGN KEY (batch_id) REFERENCES batches(id),
        FOREIGN KEY (class_id) REFERENCES classes(id)
    )";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $TableName " . mysqli_error($connection);
    die();
}

function create_admin($dpt_id = 0, $college_id = 0, $batch_id = 0, $class_id = 0, $admin_level = 0, $name = '', $email = '', $phone = '', $admin_password)
{
    global $TableName, $connection;
    if(count(find_admin_user($email))) {
        return array("error" => true, "message" => "User Already Exists, Please Login");
    }
    $query = "INSERT INTO $TableName (
            dpt_id, college_id, batch_id, class_id, admin_level, admin_name, email, phone, admin_password
        )
        VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('iiiiissss', $dpt_id, $college_id, $batch_id, $class_id, $admin_level, $name, $email, $phone, $admin_password)) {
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
