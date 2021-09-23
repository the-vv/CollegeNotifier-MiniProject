<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/college.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/rooms.php';
require_once 'connection.php';

class RoomStudentMap
{
    public $table_name = TableNames::room_student_map;

    function __construct()
    {
        global $connection;
        $create_map_query = "CREATE TABLE IF NOT EXISTS {$this->table_name}(
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            cid INT(6) UNSIGNED NOT NULL REFERENCES college(id),
            room_id INT(6) UNSIGNED NOT NULL REFERENCES rooms(id),
            students_id INT(6) UNSIGNED NOT NULL REFERENCES students(id)
        )";
        if (!mysqli_query($connection, $create_map_query)) {
            echo "Error creating Table {$this->table_name}" . mysqli_error($connection);
            die();
        }
    }
    function insert_one($cid = '', $rid = '', $mid = '')
    {
        global $connection;
        $query = "INSERT INTO {$this->table_name} (
                cid, room_id, students_id
            )
            VALUES (
                ?, ?, ?
            )";
        if ($safeQuery = mysqli_prepare($connection, $query)) {
            if (!$safeQuery->bind_param('sss', $cid, $rid, $mid)) {
                echo "Error Inserting a room map values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            if (!$safeQuery->execute()) {
                echo "Error Inserting room map Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            $safeQuery->close();
        } else {
            echo "Error Inserting room map Error: " . mysqli_error($connection);
            return array("error" => true, "message" => "Unknown Error occurred");
        }
        return array("success" => true, "message" => "Room map Updated successfully");
    }
    function remove_one($rid = '', $sid = '')
    {
        global $connection;
        $query = "DELETE FROM {$this->table_name} WHERE rid = ? AND student_id = ?";
        if ($safeQuery = mysqli_prepare($connection, $query)) {
            if (!$safeQuery->bind_param('ss', $rid, $sid)) {
                echo "Error Removing Room map values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            if (!$safeQuery->execute()) {
                echo "Error Removing Room map Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            $safeQuery->close();
        } else {
            echo "Error Removing room map Error: " . mysqli_error($connection);
            return array("error" => true, "message" => "Unknown Error occurred");
        }
        return array("success" => true, "message" => "room map removed successfully");
    }
    function remove_one_by_room($rid = '')
    {
        global $connection;
        $query = "DELETE FROM {$this->table_name} WHERE room_id = ?";
        if ($safeQuery = mysqli_prepare($connection, $query)) {
            if (!$safeQuery->bind_param('s', $rid)) {
                echo "Error Deleting Room map values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            if (!$safeQuery->execute()) {
                echo "Error Deleting Room map Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            $safeQuery->close();
        } else {
            echo "Error Deleting room map Error: " . mysqli_error($connection);
            return array("error" => true, "message" => "Unknown Error occurred");
        }
        return array("success" => true, "message" => "room map deleted successfully");
    }
    function remove_one_by_student($sid = '')
    {
        global $connection;
        $query = "DELETE FROM {$this->table_name} WHERE students_id = ?";
        if ($safeQuery = mysqli_prepare($connection, $query)) {
            if (!$safeQuery->bind_param('s', $sid)) {
                echo "Error Deleting Room map values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            if (!$safeQuery->execute()) {
                echo "Error Deleting Room map Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            $safeQuery->close();
        } else {
            echo "Error Deleting room map Error: " . mysqli_error($connection);
            return array("error" => true, "message" => "Unknown Error occurred");
        }
        return array("success" => true, "message" => "room map deleted successfully");
    }
    function get_students_to_map($cid, $rid)
    {
        global $connection, $Rooms;
        $Rooms = new Rooms();
        $student_table_name = TableNames::students;
        $query = "SELECT
            $student_table_name.id, $student_table_name.name, $student_table_name.email, $student_table_name.college_id
            FROM {$this->table_name}
            RIGHT JOIN $student_table_name
            ON {$this->table_name}.students_id = $student_table_name.id  
            WHERE $student_table_name.id NOT IN
            (
                SELECT {$this->table_name}.students_id FROM {$this->table_name}
                WHERE {$this->table_name}.room_id = ?
            )
            AND $student_table_name.college_id = ?;
        ";
        $results = array();
        if ($safeQuery = mysqli_prepare($connection, $query)) {
            if (!$safeQuery->bind_param('ss', $rid, $cid)) {
                echo "Error Creating Room map values Error: " . $safeQuery->error;
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
    function get_all_students_in_room($cid, $rid)
    {
        global $connection, $Rooms;
        $Rooms = new Rooms();
        $student_table_name = TableNames::students;
        $query = "SELECT
            $student_table_name.id, $student_table_name.name, $student_table_name.email, $student_table_name.college_id
            FROM {$this->table_name}
            INNER JOIN $student_table_name
            ON {$this->table_name}.students_id = $student_table_name.id 
            WHERE {$this->table_name}.room_id = ? 
            AND $student_table_name.college_id = ?;
        ";
        $results = array();
        if ($safeQuery = mysqli_prepare($connection, $query)) {
            if (!$safeQuery->bind_param('ss', $rid, $cid)) {
                echo "Error getting Room map values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            if (!$safeQuery->execute()) {
                echo "Error getting student Error: " . $safeQuery->error;
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
    function get_rooms_of_student($cid, $sid)
    {
        global $connection;
        $query = "SELECT room_id FROM {$this->table_name} 
            WHERE cid = ? AND students_id = ?";
        $results = array();
        if ($safeQuery = mysqli_prepare($connection, $query)) {
            if (!$safeQuery->bind_param('ss', $cid, $sid)) {
                echo "Error geting rids map values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            if (!$safeQuery->execute()) {
                echo "Error geting rids Error: " . $safeQuery->error;
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
        } else {
            echo "Error geting rids Error: " . mysqli_error($connection);
            return array("error" => true, "message" => "Unknown Error occurred");
        }
        return array("success" => true, "message" => "Room map Updated successfully");
    }
}
