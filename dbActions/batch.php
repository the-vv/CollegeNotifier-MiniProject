<?php

require_once 'connection.php';

$TableName = 'batches';

$create_query = "CREATE TABLE IF NOT EXISTS $TableName (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        dpt_id INT(6) UNSIGNED,
        college_id INT(6) UNSIGNED,
        start_year INT(4) NOT NULL,
        start_month INT(2),
        end_year INT(4) NOT NULL,
        end_month INT(2),
        FOREIGN KEY (dpt_id) REFERENCES departments(id),
        FOREIGN KEY (college_id) REFERENCES college(id)
    )";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $TableName " . mysqli_error($connection);
    die();
}

function create_batch($dpt = '', $clg = '', $syear = '', $smonth = '', $eyear = '', $emonth = '')
{
    global $TableName, $connection;
    $query = "INSERT INTO $TableName (
            dpt_id, college_id, start_year, start_month, end_year, end_month
        )
        VALUES (
            ?, ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ssssss', $dpt, $clg, $syear, $smonth, $eyear, $emonth)) {
            echo "Error Creating batch values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating batch Error: " . $safeQuery->error;
            return false;
        }
        $safeQuery->close();
    } else {
        echo "Error Creating batch Error: " . mysqli_error($connection);
        return false;
    }
    return true;
}

function get_batch($id)
{
    global $TableName, $connection;
    $query = "SELECT * from $TableName WHERE id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting batch values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error getting batch Error: " . $safeQuery->error;
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
