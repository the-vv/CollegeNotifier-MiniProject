<?php

require_once 'connection.php';

class Rooms
{
    public $table_name = TableNames::rooms;

    function __construct()
    {
        global $connection;
        $create_query = "CREATE TABLE IF NOT EXISTS {$this->table_name} (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            college_id INT(6) UNSIGNED NOT NULL REFERENCES college(id),
            room_name VARCHAR(200) NOT NULL,
            description VARCHAR(500)
            )";
        if (!mysqli_query($connection, $create_query)) {
            echo "Error creating Table {$this->table_name}" . mysqli_error($connection);
            die();
        }
    }
    function create_one($cid = '', $name = '', $description = '')
    {
        global $connection;
        $query = "INSERT INTO {$this->table_name} (
            college_id, room_name, description
        )
        VALUES (
            ?, ?, ?
        )";
        if ($safeQuery = mysqli_prepare($connection, $query)) {
            if (!$safeQuery->bind_param('sss', $cid, $name, $description)) {
                echo "Error Creating Room values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            if (!$safeQuery->execute()) {
                echo "Error Creating Room Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            $safeQuery->close();
        } else {
            echo "Error Creating Room Error: " . mysqli_error($connection);
            return array("error" => true, "message" => "Unknown Error occurred");
        }
        return array("success" => true, "message" => "Room created successfully");
    }

    function get_one($id)
    {
        global $connection;
        $query = "SELECT * from {$this->table_name} WHERE id = ?";
        $results = array();
        if ($safeQuery = mysqli_prepare($connection, $query)) {
            if (!$safeQuery->bind_param('s', $id)) {
                echo "Error getting Room values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            if (!$safeQuery->execute()) {
                echo "Error getting Room Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            $res = $safeQuery->get_result();
            while ($row = $res->fetch_assoc()) {
                array_push($results, $row);
            }
            $safeQuery->close();
            return $results;
        }
        return array("error" => true, "message" => "Unknown Error occured " . mysqli_error($connection));
    }

    function get_all_by_college($cid)
    {
        global $connection;
        $query = "SELECT * from {$this->table_name} WHERE college_id = ?";
        $results = array();
        if ($safeQuery = mysqli_prepare($connection, $query)) {
            if (!$safeQuery->bind_param('s', $cid)) {
                echo "Error getting Room values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            if (!$safeQuery->execute()) {
                echo "Error getting Room Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            $res = $safeQuery->get_result();
            while ($row = $res->fetch_assoc()) {
                array_push($results, $row);
            }
            $safeQuery->close();
            return $results;
        }
        return array("error" => true, "message" => "Unknown Error occured " . mysqli_error($connection));
    }
    function update_one($name, $desc, $rid)
    {
        global $connection;
        $query = "UPDATE {$this->table_name}
            SET room_name = ?, description = ?
            WHERE id = ?
            ";
        if ($safeQuery = mysqli_prepare($connection, $query)) {
            if (!$safeQuery->bind_param('sss', $name, $desc, $rid)) {
                echo "Error Updating Room values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            if (!$safeQuery->execute()) {
                echo "Error Updating Room Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            $safeQuery->close();
        } else {
            echo "Error Updating Room Error: " . mysqli_error($connection);
            return array("error" => true, "message" => "Unknown Error occurred");
        }
        return array("success" => true, "message" => "Room updated successfully");
    }
    function delete_one($id) {
        global $connection;
        $query = "DELETE from {$this->table_name}
            WHERE id = ?
            ";
        if ($safeQuery = mysqli_prepare($connection, $query)) {
            if (!$safeQuery->bind_param('s', $id)) {
                echo "Error Deleting Room values Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            if (!$safeQuery->execute()) {
                echo "Error Deleting Room Error: " . $safeQuery->error;
                return array("error" => true, "message" => $safeQuery->error);
            }
            $safeQuery->close();
        } else {
            echo "Error Deleting Room Error: " . mysqli_error($connection);
            return array("error" => true, "message" => "Unknown Error occurred");
        }
        return array("success" => true, "message" => "Room deleted successfully");
    }
}
