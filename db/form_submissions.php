<?php

require_once 'connection.php';

$submission_table = TableNames::form_submissions;

$create_query = "CREATE TABLE IF NOT EXISTS $submission_table (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    user_data MEDIUMTEXT,
    form_id INT(6) UNSIGNED NOT NULL,
    from_user_id INT(6) UNSIGNED NOT NULL,
    from_user_type VARCHAR(200) NOT NULL
    )"; 
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $submission_table" . mysqli_error($connection);
    die();
}

function create_submission($title = '', $data = '', $form_id = '', $from = '', $from_type = '')
{
    global $submission_table, $connection;
    $query = "INSERT INTO $submission_table (
            title, user_data, form_id, from_user_id, from_user_type
        )
        VALUES (
            ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('sssss', $title, $data, $form_id, $from, $from_type)) {
            echo "Error Creating submission values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating submission Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
    } else {
        echo "Error Creating submission Error: " . mysqli_error($connection);
        return array("error" => true, "message" => "Unknown Error occured");
    }
    return array("success" => true, "message" => "submission created successfully");
}

function update_submission_by_id($subId = '',$title = '', $data = '', $form_id = '', $from = '', $from_type = '')
{
    global $submission_table, $connection;
    $query = "UPDATE $submission_table
            SET title = ?, user_data = ?, form_id = ?, from_user_id = ?, from_user_type = ?
            WHERE id= ?
        ";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ssssss', $title, $data, $form_id, $from, $from_type, $subId)) {
            echo "Error updating submission values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error updating submission Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
    } else {
        echo "Error updating submission Error: " . mysqli_error($connection);
        return array("error" => true, "message" => "Unknown Error occured");
    }
    return array("success" => true, "message" => "submission created successfully");
}

function delete_submission_by_id($subId = '')
{
    global $submission_table, $connection;
    $query = "DELETE FROM $submission_table WHERE id= ?";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $subId)) {
            echo "Error deleting submission values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error deleting submission Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
    } else {
        echo "Error deleting submission Error: " . mysqli_error($connection);
        return array("error" => true, "message" => "Unknown Error occured");
    }
    return array("success" => true, "message" => "submission created successfully");
}

function get_submission($id)
{
    global $submission_table, $connection;
    $query = "SELECT * from $submission_table WHERE id = ?";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting submission values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error grtting submission Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $res = $safeQuery->get_result();
        $results = array();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("success" => true, "message" => "Error getting submission " . mysqli_error($connection));
}

function get_submissions_by_user($from_user_id, $from_type)
{
    global $submission_table, $connection;
    $results = array();
    $query = "SELECT * from $submission_table WHERE from_user_id = ? AND from_user_type = ?";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('is', $from_user_id, $from_type)) {
            echo "Error getting submissions values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error getting submissions Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("success" => true, "message" => "Error getting submission " . mysqli_error($connection));
}
function get_submissions_by_user_and_formid($from_user_id, $from_type, $form_id)
{
    global $submission_table, $connection;
    $results = array();
    $query = "SELECT * from $submission_table WHERE from_user_id = ? AND from_user_type = ? AND form_id = ?";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('iss', $from_user_id, $from_type, $form_id)) {
            echo "Error getting submission values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error getting submission Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("success" => true, "message" => "Error getting submission " . mysqli_error($connection));
}
