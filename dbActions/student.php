<?php

require_once 'connection.php';

$TableName = 'students';

$create_query = "CREATE TABLE IF NOT EXISTS $TableName (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        dpt_id INT(6) UNSIGNED,
        college_id INT(6) UNSIGNED,
        batch_id INT(6) UNSIGNED,
        class_id INT(6) UNSIGNED,
        parent_id INT(6) UNSIGNED,
        roll_no VARCHAR(5) NOT NULL,
        student_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(10),
        student_password VARCHAR(255),
        FOREIGN KEY (dpt_id) REFERENCES departments(id),
        FOREIGN KEY (college_id) REFERENCES college(id),
        FOREIGN KEY (batch_id) REFERENCES batches(id),
        FOREIGN KEY (class_id) REFERENCES classes(id)
    )";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $TableName " . mysqli_error($connection);
    die();
}

function create_student($dpt_id = '', $college_id = '', $batch_id = '', $class_id = '', $parent_id = '', $roll_no = '', $name = '', $email = '', $phone = '', $student_password)
{
    global $TableName, $connection;
    $query = "INSERT INTO $TableName (
            dpt_id, college_id, batch_id, class_id, parent_id, roll_no, student_name, email, phone, student_password
        )
        VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ssssssssss', $dpt_id, $college_id, $batch_id, $class_id, $parent_id, $roll_no, $name, $email, $phone, $student_password)) {
            echo "Error Creating student values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating class Error: " . $safeQuery->error;
            return false;
        }
        $safeQuery->close();
    } else {
        echo "Error Creating student Error: " . mysqli_error($connection);
        return false;
    }
    return true;
}

function get_student($id)
{
    global $TableName, $connection;
    $query = "SELECT * from $TableName WHERE id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting student values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error getting student Error: " . $safeQuery->error;
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

