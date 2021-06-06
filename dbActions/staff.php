<?php

require 'connection.php';

$TableName = 'staffs';

$create_query = "CREATE TABLE IF NOT EXISTS $TableName (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        dpt_id INT(6) UNSIGNED,
        college_id INT(6) UNSIGNED,
        staff_type VARCHAR(20),
        staff_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(10),
        staff_password VARCHAR(255),
        CHECK (staff_type IN ('teaching', 'non-teaching')),
        FOREIGN KEY (dpt_id) REFERENCES departments(id),
        FOREIGN KEY (college_id) REFERENCES college(id)
    )";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $TableName " . mysqli_error($connection);
    die();
}

function create_staff($dpt_id = '', $college_id = '', $staff_type = '', $name = '', $email = '', $phone = '', $staff_password)
{
    global $TableName, $connection;
    $query = "INSERT INTO $TableName (
            dpt_id, college_id, staff_type, staff_name, email, phone, staff_password
        )
        VALUES (
            ?, ?, ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('sssssss', $dpt_id, $college_id, $staff_type, $name, $email, $phone, $staff_password)) {
            echo "Error Creating staff values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating class Error: " . $safeQuery->error;
            return false;
        }
        $safeQuery->close();
    } else {
        echo "Error Creating staff Error: " . mysqli_error($connection);
        return false;
    }
    return true;
}

function get_staff($id)
{
    global $TableName, $connection;
    $query = "SELECT * from $TableName WHERE id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting staff values Error: " . $safeQuery->error;
            return false;
        }
        if (!$safeQuery->execute()) {
            echo "Error getting staff Error: " . $safeQuery->error;
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


create_staff(1,2,'non-teaching', 'dfvdfv', 'erferf', 3435, 'eferfef');
var_dump(get_staff(1));