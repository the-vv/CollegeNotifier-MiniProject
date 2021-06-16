<?php

require_once 'connection.php';

$TableName = 'events';

$create_query = "CREATE TABLE IF NOT EXISTS $TableName (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        dpt_id INT(6) UNSIGNED,
        college_id INT(6) UNSIGNED,
        batch_id INT(6) UNSIGNED,
        class_id INT(6) UNSIGNED,
        content TEXT,
        sendtime INT(15) NOT NULL,
        from_id INT(6) NOT NULL,
        attatchement VARCHAR(500),
        FOREIGN KEY (dpt_id) REFERENCES departments(id),
        FOREIGN KEY (college_id) REFERENCES college(id),
        FOREIGN KEY (batch_id) REFERENCES batches(id),
        FOREIGN KEY (class_id) REFERENCES classes(id)
    )";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $TableName " . mysqli_error($connection);
    die();
}

function create_event($dpt_id = '', $college_id = '', $batch_id = '', $class_id = '', $from = '', $to = '', $content = '', $time = '', $fromid = '', $attatchement = '')
{
    global $TableName, $connection;
    $query = "INSERT INTO $TableName (
            dpt_id, college_id, batch_id, class_id, from_level, to_level, content, sendtime, fromid, attatchement
        )
        VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ssssssssss', $dpt_id, $college_id, $batch_id, $class_id,  $from, $to, $content, $time, $fromid, $attatchement)) {
            echo "Error Creating event values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating event Error: " . $safeQuery->error;
            return false;
        }
        $safeQuery->close();
    } else {
        echo "Error Creating event Error: " . mysqli_error($connection);
        return false;
    }
    return true;
}

function get_event($id)
{
    global $TableName, $connection;
    $query = "SELECT * from $TableName WHERE id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting event values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error getting event Error: " . $safeQuery->error;
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


