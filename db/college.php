<?php

require_once 'connection.php';
// TODO: add referemce to owner_id
$college_table = TableNames::college;

$create_query = "CREATE TABLE IF NOT EXISTS $college_table (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    owner_id INT(6) UNSIGNED NOT NULL,
    college_name VARCHAR(200) NOT NULL,
    college_address VARCHAR(200) NOT NULL,
    website VARCHAR(200),
    phone VARCHAR(10) NOT NULL,
    FOREIGN KEY (owner_id) REFERENCES admins(id)
)"; 
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $college_table" . mysqli_error($connection);
    die();
}

function create_college($name = '', $address = '', $website = '', $phone = '', $owner = '')
{
    global $college_table, $connection;
    $query = "INSERT INTO $college_table (
            college_name, college_address, website, phone, owner_id
        )
        VALUES (
            ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ssssi', $name, $address, $website, $phone, $owner)) {
            echo "Error Creating college values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating college Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
    } else {
        echo "Error Creating college Error: " . mysqli_error($connection);
        return array("error" => true, "message" => "Unknown Error occured");
    }
    return array("success" => true, "message" => "College created successfully");
}

function get_college($id)
{
    global $college_table, $connection;
    $query = "SELECT * from $college_table WHERE id = ?";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id)) {
            echo "Error getting college values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error grtting college Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $res = $safeQuery->get_result();
        $results = array();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("success" => true, "message" => "Error getting college " . mysqli_error($connection));
}


function get_colleges($oid)
{
    global $college_table, $connection;
    $results = array();
    $query = "SELECT * from $college_table WHERE owner_id = ?";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('i', $oid)) {
            echo "Error getting college values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error getting college Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("success" => true, "message" => "Error getting college " . mysqli_error($connection));
}
