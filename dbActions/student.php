<?php

require_once 'connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/college.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/batch.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/class.php';

$student_table_name = 'students';

$create_query = "CREATE TABLE IF NOT EXISTS $student_table_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        dpt_id INT(6) UNSIGNED,
        college_id INT(6) UNSIGNED,
        batch_id INT(6) UNSIGNED,
        class_id INT(6) UNSIGNED,
        parent_id INT(6) UNSIGNED,
        roll_no VARCHAR(5),
        student_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(13),
        gender VARCHAR(8) NOT NULL,
        student_password VARCHAR(255) NOT NULL,
        CHECK (gender IN ('male', 'female')),
        FOREIGN KEY (dpt_id) REFERENCES departments(id),
        FOREIGN KEY (college_id) REFERENCES college(id),
        FOREIGN KEY (batch_id) REFERENCES batches(id),
        FOREIGN KEY (class_id) REFERENCES classes(id)
    )";
if (!mysqli_query($connection, $create_query)) {
    // echo "Error creating Table $student_table_name " . mysqli_error($connection);
    die();
}

function create_student($dpt_id = '', $college_id = '', $batch_id = '', $class_id = '', $parent_id = '', $roll_no = '', $name = '', $email = '', $phone = '', $gender = null, $student_password = '123')
{
    global $student_table_name, $connection;
    $query = "INSERT INTO $student_table_name (
            dpt_id, college_id, batch_id, class_id, parent_id, roll_no, student_name, email, phone, gender, student_password
        )
        VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        $hashed = password_hash($student_password, PASSWORD_DEFAULT);
        if (!$safeQuery->bind_param('sssssssssss', $dpt_id, $college_id, $batch_id, $class_id, $parent_id, $roll_no, $name, $email, $phone, $gender, $hashed)) {
            // echo "Error Creating student values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            // echo "Error Creating class Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
    } else {
        // echo "Error Creating student Error: " . mysqli_error($connection);
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
            // echo "Error getting student values Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            // echo "Error getting student Error: " . $safeQuery->error;
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

function get_students_from_class($cid)
{
    global $student_table_name, $connection;
    $query = "SELECT * from $student_table_name WHERE class_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $cid)) {
            // echo "Error getting student values Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            // echo "Error getting student Error: " . $safeQuery->error;
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

function get_students_from_batch($bid)
{
    global $student_table_name, $connection;
    $query = "SELECT * from $student_table_name WHERE batch_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $bid)) {
            // echo "Error getting student values Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            // echo "Error getting student Error: " . $safeQuery->error;
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

function get_students_from_college($cid)
{
    global $student_table_name, $connection;
    $query = "SELECT * from $student_table_name WHERE college_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $cid)) {
            // echo "Error getting student values Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            // echo "Error getting student Error: " . $safeQuery->error;
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

function get_students_from_dpt($did)
{
    global $student_table_name, $connection;
    $query = "SELECT * from $student_table_name WHERE dpt_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $did)) {
            // echo "Error getting student values Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            // echo "Error getting student Error: " . $safeQuery->error;
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

function create_multiple_students($students, $dpt_id = '', $college_id = '', $batch_id = '', $class_id = '', $phone = 0, $roll = 0, $parent_id = '', $student_password = '123')
{
    global $student_table_name, $connection;
    $query = "INSERT INTO $student_table_name (
            dpt_id, college_id, batch_id, class_id, parent_id, roll_no, student_name, email, phone, gender, student_password
        )
        VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        foreach ($students as $row) {
            $roll_number = isset($row['roll']) ? $row['roll'] : $roll;
            $phone_number = isset($row['phone']) ? $row['phone'] : $phone;
            $hashed = password_hash($student_password, PASSWORD_DEFAULT);
            if (!$safeQuery->bind_param('iiiiiisssss', $dpt_id, $college_id, $batch_id, $class_id, $parent_id, $roll_number, $row['name'], $row['email'], $phone_number, $row['gender'], $hashed)) {
                // echo "Error Creating student values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            if (!$safeQuery->execute()) {
                // echo "Error Creating Student Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
        }
        $safeQuery->close();
    } else {
        // echo "Error Creating student Error: " . mysqli_error($connection);
        return array("error" => true, "message" => mysqli_error($connection));
    }
    return array("success" => true, "message" => "Students created Successfully");
}

function get_all_students_bi_cid($cid)
{
    global $student_table_name, $connection, $department_table_name, $table_batch_name, $class_table_name;
    $query = "SELECT
    $student_table_name.id, $student_table_name.student_name, $student_table_name.email, $student_table_name.phone, $student_table_name.gender,
    $department_table_name.dpt_name, 
    $table_batch_name.start_year, $table_batch_name.end_year,
    $class_table_name.division
    FROM $student_table_name
    LEFT JOIN $department_table_name ON $student_table_name.dpt_id = $department_table_name.id
    LEFT JOIN $table_batch_name ON $student_table_name.batch_id = $table_batch_name.id
    LEFT JOIN $class_table_name ON $student_table_name.class_id = $class_table_name.id
    WHERE $student_table_name.college_id = ?
    ";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $cid)) {
            // echo "Error getting student values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            // echo "Error getting student Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }

        if (!$res = $safeQuery->get_result()) {
            return array("error" => true, "message" => $safeQuery->error);
        }
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => mysqli_error($connection));
}

function delete_student($sid)
{
    global $student_table_name, $connection;
    $query = "DELETE FROM $student_table_name WHERE id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $sid)) {
            // echo "Error deleting student values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            // echo "Error deleting student Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
        return array("success" => true, "message" => "Student deleted Successfully");
    } else {
        return array("error" => true, "message" => mysqli_error($connection));
    }
    return array("error" => true, "message" => mysqli_error($connection));
}

function update_student_by_id($sid, $name = '', $email = '', $phone = '', $gender = '', $student_password = '', $roll = 0)
{
    global $student_table_name, $connection;
    $query = "UPDATE $student_table_name SET
            student_name = ?, email = ?, phone = ?, gender = ?";
    if (strlen($student_password) > 0) {
        $query  .= ", student_password = ?";
    }
    $query .= " WHERE id = ?";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (strlen($student_password) > 0) {
            $hashed = password_hash($student_password, PASSWORD_DEFAULT);
            if (!$safeQuery->bind_param('ssssss', $name, $email, $phone, $gender, $hashed, $sid)) {
                // echo "Error Creating student values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
        } else {
            if (!$safeQuery->bind_param('sssss', $name, $email, $phone, $gender, $sid)) {
                // echo "Error Creating student values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
        }
        if (!$safeQuery->execute()) {
            // echo "Error Creating class Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
        return array("success" => true, "message" => "Student created Successfully");
    } else {
        // echo "Error Creating student Error: " . mysqli_error($connection);
        return array("error" => true, "message" => mysqli_error($connection));
    }
    return array("success" => true, "message" => "Student created Successfully");
}

function map_students($sids, $college_id = 0, $dpt_id = 0, $batch_id = 0, $class_id = 0)
{
    global $student_table_name, $connection;
    $query = "UPDATE $student_table_name SET 
              college_id = ?, dpt_id = ?, batch_id = ?, class_id = ?
              WHERE id = ?";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        foreach ($sids as $s) {
            if (!$safeQuery->bind_param('iiiii', $college_id, $dpt_id, $batch_id, $class_id, $s)) {
                // echo "Error Creating student values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            if (!$safeQuery->execute()) {
                // echo "Error Creating class Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
        }
        $safeQuery->close();
        return array("success" => true, "message" => "Student mapped Successfully");
    } else {
        // echo "Error Creating student Error: " . mysqli_error($connection);
        return array("error" => true, "message" => mysqli_error($connection));
    }
    return array("success" => true, "message" => "Student mapped Successfully");
}
