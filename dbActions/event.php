<?php

require_once 'connection.php';

$event_table_name = 'events';

$create_query = "CREATE TABLE IF NOT EXISTS $event_table_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        dpt_id INT(6) UNSIGNED,
        college_id INT(6) UNSIGNED,
        batch_id INT(6) UNSIGNED,
        class_id INT(6) UNSIGNED,
        title VARCHAR(200) NOT NULL,
        content MEDIUMTEXT,
        sendtime INT(15) NOT NULL,
        from_id INT(6) NOT NULL,
        attatchement VARCHAR(500),
        is_event INT(1) NOT NULL,
        starttime VARCHAR(50),
        endtime VARCHAR(50),
        CHECK (is_event IN (1, 0)),
        FOREIGN KEY (dpt_id) REFERENCES departments(id),
        FOREIGN KEY (college_id) REFERENCES college(id),
        FOREIGN KEY (batch_id) REFERENCES batches(id),
        FOREIGN KEY (class_id) REFERENCES classes(id)
    )";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $event_table_name " . mysqli_error($connection);
    die();
}

function create_event($dpt_id = '', $college_id = '', $batch_id = '', $class_id = '', $title = '', $content = '', $time = '', $fromid = '', $attatchement = '', $isevent = 0, $st = 0, $et = 0)
{
    global $event_table_name, $connection;
    $query = "INSERT INTO $event_table_name (
            dpt_id, college_id, batch_id, class_id, title, content, sendtime, from_id, attatchement, is_event, starttime, endtime
        )
        VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ssssssssssss', $dpt_id, $college_id, $batch_id, $class_id, $title, $content, $time, $fromid, $attatchement, $isevent, $st, $et)) {
            echo "Error Creating event values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating event Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
    } else {
        echo "Error Creating event Error: " . mysqli_error($connection);
        return array("error" => true, "message" => mysqli_error($connection));
    }
    return array("success" => true, "message" => "Department created successfully");
}

function get_event($id)
{
    global $event_table_name, $connection;
    $query = "SELECT * from $event_table_name WHERE id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting event values Error: " . $safeQuery->error;
             return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            echo "Error getting event Error: " . $safeQuery->error;
             return array("error" => true, "message" => mysqli_error($connection));
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
     return array("error" => true, "message" => mysqli_error($connection));
}

function get_events_by_param($cid = 0, $did = 0, $bid = 0, $clid = 0, $rid = 0) {
    global $event_table_name, $connection;
    $query = "SELECT * from $event_table_name
    WHERE college_id = ? AND dpt_id = ? AND batch_id = ? AND class_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ssss', $cid, $did, $bid, $clid)) {
            echo "Error getting event values Error: " . $safeQuery->error;
             return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            echo "Error getting event Error: " . $safeQuery->error;
             return array("error" => true, "message" => mysqli_error($connection));
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
     return array("error" => true, "message" => mysqli_error($connection));
}

function delete_event($eid)
{
    global $event_table_name, $connection;
    $query = "DELETE FROM $event_table_name WHERE id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $eid)) {
            // echo "Error deleting event values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            // echo "Error deleting event Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
        return array("success" => true, "message" => "Event deleted Successfully");
    } else {
        return array("error" => true, "message" => mysqli_error($connection));
    }
    return array("error" => true, "message" => mysqli_error($connection));
}