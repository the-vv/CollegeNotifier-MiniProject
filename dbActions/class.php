<?php

require_once 'connection.php';

$class_table_name = 'classes';
// TODO: add Reference to tutor id
$create_query = "CREATE TABLE IF NOT EXISTS $class_table_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        dpt_id INT(6) UNSIGNED,
        college_id INT(6) UNSIGNED,
        batch_id INT(6) UNSIGNED,
        division VARCHAR(10) NOT NULL,
        tutor_id INT(6) UNSIGNED,
        FOREIGN KEY (dpt_id) REFERENCES departments(id),
        FOREIGN KEY (college_id) REFERENCES college(id),
        FOREIGN KEY (batch_id) REFERENCES batches(id)
    )";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $class_table_name " . mysqli_error($connection);
    die();
}

function create_class($dpt_id = '', $college_id = '', $batch_id = '', $division = '', $tutor_id = 0)
{
    global $class_table_name, $connection;
    $query = "INSERT INTO $class_table_name (
            dpt_id, college_id, batch_id, division, tutor_id
        )
        VALUES (
            ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('sssss', $dpt_id, $college_id, $batch_id, $division, $tutor_id)) {
            echo "Error Creating class values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating class Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
    } else {
        echo "Error Creating class Error: " . mysqli_error($connection);
        return array("error" => true, "message" => $safeQuery->error);
    }
    return array("success" => true, "message" => "Class created successfully");
}

function get_a_class($id)
{
    global $class_table_name, $connection;
    $query = "SELECT * from $class_table_name WHERE id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting class values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error getting class Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => "Unknown error occurred");
} 


function get_classes($dpt_id, $college_id, $batch_id)
{
    global $class_table_name, $connection;
    $query = "SELECT * from $class_table_name WHERE dpt_id = ? AND college_id = ? AND batch_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('iii', $dpt_id, $college_id, $batch_id)) {
            echo "Error getting class values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error getting class Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => "Unknown error occurred");
}
