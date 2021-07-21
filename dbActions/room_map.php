<?php

require_once 'connection.php';

class EventMap
{
    public $table_name = 'room_mapping';
    function __construct()
    {
        global $connection;
        $create_map_query = "CREATE TABLE IF NOT EXISTS {$this->table_name} (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            cid INT(6) UNSIGNED NOT NULL REFERENCES college(id),
            room_id INT(6) UNSIGNED NOT NULL REFERENCES rooms(id),
            member_id INT(6) UNSIGNED NOT NULL,
            member_type VARCHAR(100) NOT NULL,
            CHECK (member_type IN ('student', 'employee'))
        )";
        if (!mysqli_query($connection, $create_map_query)) {
            echo "Error creating Table {$this->table_name}" . mysqli_error($connection);
            die();
        }
    }
    function insert_one($cid = '', $rid = '', $mid = '', $type = '')
    {
        global $connection;
        $query = "INSERT INTO {$this->table_name} (
                cid, room_id, member_id, member_type
            )
            VALUES (
                ?, ?, ?, ?
            )";
        if ($safeQuery = mysqli_prepare($connection, $query)) {
            if (!$safeQuery->bind_param('ssss', $cid, $rid, $mid, $type)) {
                echo "Error Deleting a room map values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            if (!$safeQuery->execute()) {
                echo "Error Deleting room map Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            $safeQuery->close();
        } else {
            echo "Error Deleting room map Error: " . mysqli_error($connection);
            return array("error" => true, "message" => "Unknown Error occurred");
        }
        return array("success" => true, "message" => "Room map Deleted successfully");
    }
    function remove_one($rid = '', $mid = '') {
        global $connection;
        $query = "DELETE FROM {$this->table_name} WHERE rid = ? AND mid = ?";
        if ($safeQuery = mysqli_prepare($connection, $query)) {
            if (!$safeQuery->bind_param('ssss', $cid, $rid, $mid, $type)) {
                echo "Error Creating Room map values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            if (!$safeQuery->execute()) {
                echo "Error Creating Room map Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            $safeQuery->close();
        } else {
            echo "Error Creating room map Error: " . mysqli_error($connection);
            return array("error" => true, "message" => "Unknown Error occurred");
        }
        return array("success" => true, "message" => "room map created successfully");
    }
    function get_students_to_map($cid, $rid) {
        global $connection;
        $query = "SELECT member_id from {$this->table_name} WHERE cid = ? AND room_id <> ? AND member_type = student";
        if ($safeQuery = mysqli_prepare($connection, $query)) {
            if (!$safeQuery->bind_param('ss', $cid, $rid)) {
                echo "Error getting students id values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            if (!$safeQuery->execute()) {
                echo "Error getting students id Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            $safeQuery->close();
        } else {
            echo "Error getting students id Error: " . mysqli_error($connection);
            return array("error" => true, "message" => "Unknown Error occurred");
        }
        return array("success" => true, "message" => "students id created successfully");
    }
    function get_students_detals($sids) {
        $studs = array();
        return $studs;
    }
}
