<?php

// Connection
$connection = mysqli_connect(DatabaseConfig::host, DatabaseConfig::username, DatabaseConfig::password);
if (!$connection) {
    echo "Error connecting to MYSQL: " . DatabaseConfig::databaseName . "<br>" . mysqli_connect_error($connection);
    die();
}

// Configuring database
if (!mysqli_query($connection, "SET foreign_key_checks = 0")) {
    echo "Error Seting up database Configuration" . mysqli_error($connection);
    die();
}

// Verifying Database
if (!mysqli_query($connection, "CREATE DATABASE IF NOT EXISTS " . DatabaseConfig::databaseName)) {
    echo "Error Creating Database: " . DatabaseConfig::databaseName . "<br>" . mysqli_error($connection);
    die();
}

// Selecting Database
if (!mysqli_select_db($connection, DatabaseConfig::databaseName)) {
    echo "Database Selection Error <br>" . mysqli_error($connection);
    die();
}

