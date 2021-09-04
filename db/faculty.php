<?php

require_once 'connection.php';

$tbl_faculty_name = 'faculties';

$create_query = "CREATE TABLE IF NOT EXISTS $tbl_faculty_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(10),
        role VARCHAR(100),
        faculty_password VARCHAR(255) NOT NULL
    )";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $tbl_faculty_name " . mysqli_error($connection);
    die();
}

function create_faculty($name = '', $email = '', $phone = '', $role = '', $faculty_password)
{
    global $tbl_faculty_name, $connection;
    if(count(find_faculty_user($email))) {
        return array("error" => true, "message" => "User Already Exists, Please Login");
    }
    $query = "INSERT INTO $tbl_faculty_name (
            name, email, phone, role,  faculty_password
        )
        VALUES (
            ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('sssss',$name, $email, $phone, $role, $faculty_password)) {
            echo "Error Creating faculty values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating faculty Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
        return find_faculty_user($email);
    } else {
        echo "Error Creating faculty Error: " . mysqli_error($connection);
        return array("error" => true, "message" => "Unknown Error Occured");
    }
    return true;
}

function get_faculty($id)
{
    global $tbl_faculty_name, $connection;
    $query = "SELECT * from $tbl_faculty_name WHERE id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting faculty values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error getting faculty Error: " . $safeQuery->error;
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

function find_faculty_user($email)
{
    global $tbl_faculty_name, $connection;
    $query = "SELECT * from $tbl_faculty_name WHERE email = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $email)) {
            echo "Error getting faculty values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error getting faculty Error: " . $safeQuery->error;
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
