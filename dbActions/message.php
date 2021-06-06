<?php

require_once 'connection.php';

$TableName = 'messages';

$create_query = "CREATE TABLE IF NOT EXISTS $TableName (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        dpt_id INT(6) UNSIGNED,
        college_id INT(6) UNSIGNED,
        batch_id INT(6) UNSIGNED,
        class_id INT(6) UNSIGNED,
        from_level INT(1) UNSIGNED NOT NULL,
        to_level INT(1) UNSIGNED NOT NULL,
        content VARCHAR(10000),
        sendtime INT(15) NOT NULL,
        fromid INT(6) NOT NULL,
        FOREIGN KEY (dpt_id) REFERENCES departments(id),
        FOREIGN KEY (college_id) REFERENCES college(id),
        FOREIGN KEY (batch_id) REFERENCES batches(id),
        FOREIGN KEY (class_id) REFERENCES classes(id)
    )";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $TableName " . mysqli_error($connection);
    die();
}

function create_message($dpt_id = '', $college_id = '', $batch_id = '', $class_id = '', $from = '', $to = '', $content = '', $time = '', $fromid = '')
{
    global $TableName, $connection;
    $query = "INSERT INTO $TableName (
            dpt_id, college_id, batch_id, class_id, from_level, to_level, content, sendtime, fromid
        )
        VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('sssssssss', $dpt_id, $college_id, $batch_id, $class_id,  $from, $to, $content, $time, $fromid)) {
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
    global $TableName, $connection;
    $query = "SELECT * from $TableName WHERE id = ?";
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
