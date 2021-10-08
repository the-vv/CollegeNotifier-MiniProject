<?php

require_once 'connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/admin.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/student.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/college.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/batch.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/rooms.php';

$form_table_name = TableNames::forms;
$batch_table_name = TableNames::batch;
$dpt_table_name = TableNames::department;
$college_table_name = TableNames::college;
$class_table_name = TableNames::classes;

$create_query = "CREATE TABLE IF NOT EXISTS $form_table_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        dpt_id INT(6) UNSIGNED,
        college_id INT(6) UNSIGNED,
        batch_id INT(6) UNSIGNED,
        class_id INT(6) UNSIGNED,
        room_id INT(6) UNSIGNED,
        title VARCHAR(200) NOT NULL,
        content MEDIUMTEXT,
        publish_time INT(15) NOT NULL,
        from_id INT(6) NOT NULL,
        from_user_type VARCHAR(50) NOT NULL,
        FOREIGN KEY (dpt_id) REFERENCES $dpt_table_name(id),
        FOREIGN KEY (college_id) REFERENCES $college_table_name(id),
        FOREIGN KEY (batch_id) REFERENCES $batch_table_name(id),
        FOREIGN KEY (class_id) REFERENCES $class_table_name(id)
    )";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $form_table_name " . mysqli_error($connection);
    die();
}

function get_owner_user_form($id, $type)
{
    if ($type == UserTypes::admin) {
        $user = get_admin($id)[0];
        unset($user['admin_password']);
        return $user;
    } else if ($type == UserTypes::student) {
        $user = get_student($id)[0];
        unset($user['student_password']);
        return $user;
    }
}

function get_level_details_form($form)
{
    $result = array();
    if ($form['room_id'] !== 0) {
        $rooms = new Rooms();
        $level = $rooms->get_one($form['room_id']);
        $result['type'] = LevelTypes::room;
        $result['name'] = $level[0]['room_name'];
    } elseif ($form['class_id'] !== 0) {
        $level = get_a_class($form['class_id']);
        $result['type'] = LevelTypes::classes;
        $result['name'] = $level[0]['division'];
    } elseif ($form['batch_id'] !== 0) {
        $level = get_batch($form['batch_id']);
        $result['type'] = LevelTypes::batch;
        $result['name'] = $level[0]['start_year'] . " - " . $level[0]['end_year'];
    } elseif ($form['dpt_id'] !== 0) {
        $level = get_dpt($form['dpt_id']);
        $result['type'] = LevelTypes::department;
        $result['name'] = $level[0]['dpt_name'];
    } elseif ($form['college_id'] !== 0) {
        $level = get_college($form['college_id']);
        $result['type'] = LevelTypes::college;
        $result['name'] = $level[0]['college_name'];
    }
    $result['details'] = $level[0];
    return $result;
}

function create_form($dpt_id = '', $college_id = '', $batch_id = '', $class_id = '', $title = '', $content = '', $time = '', $fromid = '', $fromtype = '', $rid = 0)
{
    global $form_table_name, $connection;
    $query = "INSERT INTO $form_table_name (
            dpt_id, college_id, batch_id, class_id, room_id, title, content, publish_time, from_id, from_user_type
        )
        VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ssssssssss', $dpt_id, $college_id, $batch_id, $class_id, $rid, $title, $content, $time, $fromid, $fromtype)) {
            echo "Error Creating form values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating form Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
    } else {
        echo "Error Creating form Error: " . mysqli_error($connection);
        return array("error" => true, "message" => mysqli_error($connection));
    }
    return array("success" => true, "message" => "form created successfully");
}

function get_form($id)
{
    global $form_table_name, $connection;
    $query = "SELECT * from $form_table_name WHERE id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting form values Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            echo "Error getting form Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            $row['level'] = get_level_details_form($row);
            $row['user'] = get_owner_user_form($row['from_id'], $row['from_user_type']);
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => mysqli_error($connection));
}

function get_forms_by_param($cid = 0, $did = 0, $bid = 0, $clid = 0, $rid = 0)
{
    global $form_table_name, $connection;
    $query = "SELECT * from $form_table_name
    WHERE college_id = ? AND dpt_id = ? AND batch_id = ? AND class_id = ? AND room_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('sssss', $cid, $did, $bid, $clid, $rid)) {
            echo "Error getting form values Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            echo "Error getting form Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            $row['level'] = get_level_details_form($row);
            $row['user'] = get_owner_user_form($row['from_id'], $row['from_user_type']);
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => mysqli_error($connection));
}

function get_forms_by_class($cid = 0, $did = 0, $bid = 0, $clid = 0)
{
    global $form_table_name, $connection;
    $query = "SELECT * from $form_table_name
    WHERE college_id = ? AND dpt_id = ? AND batch_id = ? AND class_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ssss', $cid, $did, $bid, $clid)) {
            echo "Error getting form values Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            echo "Error getting form Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            $row['level'] = get_level_details_form($row);
            $row['user'] = get_owner_user_form($row['from_id'], $row['from_user_type']);
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => mysqli_error($connection));
}

function get_forms_by_room($cid = 0, $rid = 0)
{
    global $form_table_name, $connection;
    $query = "SELECT * from $form_table_name
    WHERE college_id = ? AND room_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ss', $cid, $rid)) {
            echo "Error getting form values Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            echo "Error getting form Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            $row['level'] = get_level_details_form($row);
            $row['user'] = get_owner_user_form($row['from_id'], $row['from_user_type']);
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => mysqli_error($connection));
}

function get_forms_by_batch($cid = 0, $did = 0, $bid = 0)
{
    global $form_table_name, $connection;
    $query = "SELECT * from $form_table_name
    WHERE college_id = ? AND dpt_id = ? AND batch_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('sss', $cid, $did, $bid)) {
            echo "Error getting form values Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            echo "Error getting form Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            $row['level'] = get_level_details_form($row);
            $row['user'] = get_owner_user_form($row['from_id'], $row['from_user_type']);
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => mysqli_error($connection));
}

function get_forms_by_dpt($cid = 0, $did = 0)
{
    global $form_table_name, $connection;
    $query = "SELECT * from $form_table_name
    WHERE college_id = ? AND dpt_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ss', $cid, $did)) {
            echo "Error getting form values Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            echo "Error getting form Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            $row['level'] = get_level_details_form($row);
            $row['user'] = get_owner_user_form($row['from_id'], $row['from_user_type']);
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => mysqli_error($connection));
}

function get_forms_by_college($cid)
{
    global $form_table_name, $connection;
    $query = "SELECT * from $form_table_name
    WHERE college_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $cid)) {
            echo "Error getting form values Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        if (!$safeQuery->execute()) {
            echo "Error getting form Error: " . $safeQuery->error;
            return array("error" => true, "message" => mysqli_error($connection));
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            $row['level'] = get_level_details_form($row);
            $row['user'] = get_owner_user_form($row['from_id'], $row['from_user_type']);
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => mysqli_error($connection));
}

function delete_form($fid)
{
    global $form_table_name, $connection;
    $query = "DELETE FROM $form_table_name WHERE id = ?";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $fid)) {
            // echo "Error deleting form values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            // echo "Error deleting form Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
        return array("success" => true, "message" => "form deleted Successfully");
    } else {
        return array("error" => true, "message" => mysqli_error($connection));
    }
    return array("error" => true, "message" => mysqli_error($connection));
}
function delete_form_multiple($fids)
{
    global $form_table_name, $connection;
    $query = "DELETE FROM $form_table_name WHERE id IN (?)";
    $id_string = implode(",", $fids);
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id_string)) {
            // echo "Error deleting form values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            // echo "Error deleting form Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
        return array("success" => true, "message" => "form deleted Successfully");
    } else {
        return array("error" => true, "message" => mysqli_error($connection));
    }
    return array("success" => true, "message" => "form deleted Successfully");
}

function update_form_by_id($fid = '', $title = '', $content = '', $time = '', $fromid = '', $from_user_type = '')
{
    global $form_table_name, $connection;
    $query = "UPDATE $form_table_name SET
            title = ?, content = ?, publish_time = ?, from_id = ?, from_user_type = ?
            WHERE id= ?";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ssssss', $title, $content, $time, $fromid, $from_user_type, $fid)) {
            echo "Error Updating form values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error Updating form Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
    } else {
        echo "Error Updating form Error: " . mysqli_error($connection);
        return array("error" => true, "message" => mysqli_error($connection));
    }
    return array("success" => true, "message" => "form Updated successfully");
}
