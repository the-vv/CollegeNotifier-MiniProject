<?php

require_once 'connection.php';

$participant_table_name = TableNames::participants;

$create_query = "CREATE TABLE IF NOT EXISTS $participant_table_name (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id INT(6) UNSIGNED NOT NULL,
    student_id INT(6) UNSIGNED NOT NULL,
    FOREIGN KEY (event_id) REFERENCES events(id),
    FOREIGN KEY (student_id) REFERENCES students(id)
)";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $participant_table_name" . mysqli_error($connection);
    die();
}

function create_participant($eid = '', $sid = '')
{
    global $participant_table_name, $connection;
    $query = "INSERT INTO $participant_table_name (
            event_id, student_id
        )
        VALUES (
            ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ii', $eid, $sid)) {
            echo "Error Creating participant values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating participant Error: " . $safeQuery->error;
            return false;
        }
        $safeQuery->close();
    } else {
        echo "Error Creating participant Error: " . mysqli_error($connection);
        return false;
    }
    return true;
}

function get_participant($id)
{
    global $participant_table_name, $connection;
    $query = "SELECT * from $participant_table_name WHERE id = ?";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting participant values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error grtting participant Error: " . $safeQuery->error;
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
