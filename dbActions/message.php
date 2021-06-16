<?php

require_once 'connection.php';

$tbl_message = 'messages';

$create_query = "CREATE TABLE IF NOT EXISTS $tbl_message (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        dpt_id INT(6) UNSIGNED,
        college_id INT(6) UNSIGNED,
        batch_id INT(6) UNSIGNED,
        class_id INT(6) UNSIGNED,
        room_id INT(6) UNSIGNED,
        content TEXT,
        sendtime INT(15) NOT NULL,
        from_id INT(6) NOT NULL,
        event_type VARCHAR() NOT NULL,
        CHECK (event_type IN ('notification', 'event')),
        FOREIGN KEY (dpt_id) REFERENCES departments(id),
        FOREIGN KEY (college_id) REFERENCES college(id),
        FOREIGN KEY (batch_id) REFERENCES batches(id),
        FOREIGN KEY (class_id) REFERENCES classes(id)
    )";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $tbl_message " . mysqli_error($connection);
    die();
}

function create_message($dpt_id = '', $college_id = '', $batch_id = '', $class_id = '', $from = '', $to = '', $content = '', $time = '', $fromid = '')
{
    global $tbl_message, $connection;
    $query = "INSERT INTO $tbl_message (
            dpt_id, college_id, batch_id, class_id, from_level, to_level, content, sendtime, fromid
        )
        VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('iiiisssss', $dpt_id, $college_id, $batch_id, $class_id,  $from, $to, $content, $time, $fromid)) {
            echo "Error Creating message values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating message Error: " . $safeQuery->error;
            return false;
        }
        $safeQuery->close();
    } else {
        echo "Error Creating message Error: " . mysqli_error($connection);
        return false;
    }
    return true;
}

function get_message($id)
{
    global $tbl_message, $connection;
    $query = "SELECT * from $tbl_message WHERE id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting message values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error getting message Error: " . $safeQuery->error;
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
