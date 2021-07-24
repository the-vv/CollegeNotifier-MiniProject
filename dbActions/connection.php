<?php

// Global Database Variables
$host = 'localhost';
$username = 'root';
$password = '';
$databaseName = 'collegeapp';

// Connection
$connection = mysqli_connect($host, $username, $password);
if (!$connection) {
    echo "Error connecting to MYSQL: $databaseName<br>" . mysqli_connect_error($connection);
    die();
}

// Verifying Database
if (!mysqli_query($connection, "CREATE DATABASE IF NOT EXISTS $databaseName")) {
    echo "Error Creating Database: $databaseName" . mysqli_error($connection);
    die();
}

// Selecting Database
if (!mysqli_select_db($connection, $databaseName)) {
    echo "Database Selection Error <br>" . mysqli_error($connection);
    die();
}

