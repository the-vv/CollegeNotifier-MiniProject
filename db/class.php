<?php

require_once 'connection.php';

$class_table_name = TableNames::classes;
$batch_table_name = TableNames::batch;
$dpt_table_name = TableNames::department;
$college_table_name = TableNames::college;
// TODO: add Reference to tutor id
$create_query = "CREATE TABLE IF NOT EXISTS $class_table_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        dpt_id INT(6) UNSIGNED,
        college_id INT(6) UNSIGNED,
        batch_id INT(6) UNSIGNED,
        division VARCHAR(10) NOT NULL,
        tutor_id INT(6) UNSIGNED,
        FOREIGN KEY (dpt_id) REFERENCES $dpt_table_name(id),
        FOREIGN KEY (college_id) REFERENCES $college_table_name(id),
        FOREIGN KEY (batch_id) REFERENCES $batch_table_name(id)
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
    return array("error" => true, "message" => "Unknown error occurred" . mysqli_error($connection));
} 
function get_all_classes($cid)
{
    global $class_table_name, $connection;
    $dpt_table = TableNames::department;
    $batch_table = TableNames::batch;
    $query = "SELECT 
        $class_table_name.id as id, $class_table_name.division as division, $class_table_name.tutor_id,
        $dpt_table.id as dpt_id, $dpt_table.dpt_name, $dpt_table.category as dpt_category,
        $batch_table.id as batch_id, $batch_table.start_year, $batch_table.end_year, $batch_table.start_month, $batch_table.end_month
        FROM $class_table_name
        LEFT JOIN $dpt_table ON $dpt_table.id = $class_table_name.dpt_id
        LEFT JOIN $batch_table ON $batch_table.id = $class_table_name.batch_id
        WHERE $class_table_name.college_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $cid)) {
            echo "Error getting classes values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error getting classes Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => "Unknown error occurred: " . mysqli_error($connection));
} 
function update_class($id, $division)
{
    global $class_table_name, $connection;
    $query = "UPDATE $class_table_name SET division = ? WHERE id = ?";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ss', $division, $id)) {
            echo "Error updating class values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error updating class Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
        return array("success" => true, "message" => "Class updating successfully");
    }
    return array("error" => true, "message" => "Unknown error occurred: " . mysqli_error($connection));
} 
function delete_class($id)
{
    global $class_table_name, $connection;
    $query = "DELETE from $class_table_name WHERE id = ?";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error deleting class values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error deleting class Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
        return array("success" => true, "message" => "Class deleted successfully");
    }
    return array("error" => true, "message" => "Unknown error occurred: " . mysqli_error($connection));
} 
function delete_class_multiple($ids)
{
    global $class_table_name, $connection;
    $query = "DELETE from $class_table_name WHERE id IN (?)";
    $id_string = implode(',', $ids);
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id_string)) {
            // echo "Error getting class values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            // echo "Error getting class Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
        return array("success" => true, "message" => "Classes deleted successfully");
    } else {
        return array("error" => true, "message" => mysqli_error($connection));
    }
    return array("error" => true, "message" => "Unknown error occurred: " . mysqli_error($connection));
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
    return array("error" => true, "message" => "Unknown error occurred: " . mysqli_error($connection));
}