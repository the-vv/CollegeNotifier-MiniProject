<?php

require './connection.php';

$TableName = 'college';
$create_query = "CREATE TABLE IF NOT EXISTS $TableName (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    college_name VARCHAR(100) NOT NULL,
    college_address VARCHAR(200) NOT NULL,
    website VARCHAR(200),
    phone: INT(15) NOT NULL
)";
if(!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $TableName" . mysqli_error($connection);
    die();
}

function create_college($name = '', $address = '', $website = '', $phone = '') {
    global $TableName, $connection;
    $query = "INSERT INTO $TableName VALUES(
        $name, $address, $website, $phone
    )";
    if(!mysqli_query($connection, $query)) {
        return false;
    }
    return true;
}

function get_colleges($id) {    
    global $TableName, $connection;
    $query = " SELECT * from $TableName WHERE id = $id";
    $result = mysqli_query($connection, $query);
}