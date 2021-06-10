<?php

require_once 'connection.php';

$student_table_name = 'students';

$create_query = "CREATE TABLE IF NOT EXISTS $student_table_name (
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
    echo "Error creating Table $student_table_name " . mysqli_error($connection);
    die();
}

function create_student($dpt_id = '', $college_id = '', $batch_id = '', $class_id = '', $parent_id = '', $roll_no = '', $name = '', $email = '', $phone = '', $student_password)
{
    global $student_table_name, $connection;
    $query = "INSERT INTO $student_table_name (
            dpt_id, college_id, batch_id, class_id, parent_id, roll_no, student_name, email, phone, student_password
        )
        VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ssssssssss', $dpt_id, $college_id, $batch_id, $class_id, $parent_id, $roll_no, $name, $email, $phone, $student_password)) {
            echo "Error Creating student values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating class Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
    } else {
        echo "Error Creating student Error: " . mysqli_error($connection);
        return array("error" => true, "message" => mysqli_error($connection));
    }
    return array("success" => true, "message" => "Student created Successfully");
}

function get_student($id)
{
    global $student_table_name, $connection;
    $query = "SELECT * from $student_table_name WHERE id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting student values Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            echo "Error getting student Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => "Unknown error has occurred");
}

function get_students_from_class($cid)
{
    global $student_table_name, $connection;
    $query = "SELECT * from $student_table_name WHERE class_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $cid)) {
            echo "Error getting student values Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            echo "Error getting student Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => "Unknown error has occurred");
}

function get_students_from_batch($bid)
{
    global $student_table_name, $connection;
    $query = "SELECT * from $student_table_name WHERE batch_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $bid)) {
            echo "Error getting student values Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            echo "Error getting student Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => "Unknown error has occurred");
}

function get_students_from_college($cid)
{
    global $student_table_name, $connection;
    $query = "SELECT * from $student_table_name WHERE college_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $cid)) {
            echo "Error getting student values Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            echo "Error getting student Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => "Unknown error has occurred");
}

function get_students_from_dpt($did)
{
    global $student_table_name, $connection;
    $query = "SELECT * from $student_table_name WHERE class_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $did)) {
            echo "Error getting student values Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            echo "Error getting student Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => "Unknown error has occurred");
}

function create_multiple_students($students, $dpt_id = '', $college_id = '', $batch_id = '', $class_id = '', $phone = 0, $roll = 0, $parent_id = '', $student_password = '123')
{
    global $student_table_name, $connection;
    $query = "INSERT INTO $student_table_name (
            dpt_id, college_id, batch_id, class_id, parent_id, roll_no, student_name, email, phone, student_password
        )
        VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        foreach ($students as $row) {
            $roll_number = isset($row['roll']) ? $row['roll'] : $roll;
            $phone_number = isset($row['phone']) ? $row['roll'] : $phone;
            if (!$safeQuery->bind_param('iiiiiissss', $dpt_id, $college_id, $batch_id, $class_id, $parent_id, $roll_number, $row['name'], $row['email'], $phone_number, $student_password)) {
                echo "Error Creating student values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            if (!$safeQuery->execute()) {
                echo "Error Creating Stundnt Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
        }
        $safeQuery->close();
    } else {
        echo "Error Creating student Error: " . mysqli_error($connection);
        return array("error" => true, "message" => mysqli_error($connection));
    }
    return array("success" => true, "message" => "Student created Successfully");
}
