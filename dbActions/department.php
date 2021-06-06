<?php

require_once 'connection.php';

$department_table_name = 'departments';
$create_query = "CREATE TABLE IF NOT EXISTS $department_table_name (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    college_id INT(6) UNSIGNED REFERENCES college(id),
    dpt_name VARCHAR(200) NOT NULL,
    category VARCHAR(100)
)";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $department_table_name" . mysqli_error($connection);
    die();
}

function create_dpt($cid = '', $name = '', $category = '')
{
    global $department_table_name, $connection;
    $query = "INSERT INTO $department_table_name (
            college_id, dpt_name, category
        )
        VALUES (
            ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('sss', $cid, $name, $category)) {
            echo "Error Creating department values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating department Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
    } else {
        echo "Error Creating department Error: " . mysqli_error($connection);
        return array("error" => true, "message" => "Unknown Error occurred");
    }    
    return array("success" => true, "message" => "Department created successfully");
}

function get_dpt($id)
{
    global $department_table_name, $connection;
    $query = "SELECT * from $department_table_name WHERE id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting department values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error getting department Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => "Unknown Error occured " . mysqli_error($connection));
}

function get_dpts($cid)
{
    global $department_table_name, $connection;
    $query = "SELECT * from $department_table_name WHERE college_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $cid)) {
            echo "Error getting department values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error getting department Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => "Unknown Error occured " . mysqli_error($connection));
}
