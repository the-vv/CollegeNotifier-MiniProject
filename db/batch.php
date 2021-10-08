<?php

require_once 'connection.php';

$table_batch_name = TableNames::batch;
$dpt_table_name = TableNames::department;
$college_tbl_name = TableNames::college;

$create_query = "CREATE TABLE IF NOT EXISTS $table_batch_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        dpt_id INT(6) UNSIGNED,
        college_id INT(6) UNSIGNED,
        start_year INT(4) NOT NULL,
        start_month INT(2),
        end_year INT(4) NOT NULL,
        end_month INT(2),
        FOREIGN KEY (dpt_id) REFERENCES $dpt_table_name(id),
        FOREIGN KEY (college_id) REFERENCES $college_tbl_name(id)
    )";
if (!mysqli_query($connection, $create_query)) {
    echo "Error creating Table $table_batch_name " . mysqli_error($connection);
    die();
}

function create_batch($dpt = '', $clg = '', $syear = '', $smonth = '', $eyear = '', $emonth = '')
{
    global $table_batch_name, $connection;
    $query = "INSERT INTO $table_batch_name (
            dpt_id, college_id, start_year, start_month, end_year, end_month
        )
        VALUES (
            ?, ?, ?, ?, ?, ?
        )";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ssssss', $dpt, $clg, $syear, $smonth, $eyear, $emonth)) {
            echo "Error Creating batch values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error Creating batch Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
    } else {
        echo "Error Creating batch Error: " . mysqli_error($connection);
        return array("error" => true, "message" => $safeQuery->error);
    }
    return array("success" => true, "message" => "Batch created successfully");
}
function update_batch($id, $syear = '', $smonth = '', $eyear = '', $emonth = '')
{
    global $table_batch_name, $connection;
    $query = "UPDATE $table_batch_name SET
            start_year = ?, start_month = ?, end_year = ?, end_month = ?
            WHERE id = ?
        ";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('sssss', $syear, $smonth, $eyear, $emonth, $id)) {
            echo "Error Updating batch values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error Updating batch Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
    } else {
        echo "Error Updating batch Error: " . mysqli_error($connection);
        return array("error" => true, "message" => $safeQuery->error);
    }
    return array("success" => true, "message" => "Batch Updated successfully");
}

function get_batch($id)
{
    global $table_batch_name, $connection;
    $query = "SELECT * from $table_batch_name WHERE id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('i', $id)) {
            echo "Error getting batch values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error getting batch Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => "Unknown error occurred: " . mysqli_error($connection));
}
function get_all_batches($cid)
{
    global $table_batch_name, $connection;
    $tbl_dpt = TableNames::department;
    $query = "SELECT
        $table_batch_name.start_year, $table_batch_name.start_month, $table_batch_name.end_year, $table_batch_name.end_month, $table_batch_name.id,
        $tbl_dpt.dpt_name, $tbl_dpt.category as dpt_category, $tbl_dpt.id as dpt_id
        from $table_batch_name
        LEFT JOIN $tbl_dpt ON $tbl_dpt.id = $table_batch_name.dpt_id
        WHERE $table_batch_name.college_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('i', $cid)) {
            echo "Error getting batch values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error getting batch Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => "Unknown error occurred: " . mysqli_error($connection));
}
function delete_batch($id)
{
    global $table_batch_name, $connection;
    $query = "DELETE from $table_batch_name WHERE id = ?";
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('i', $id)) {
            echo "Error deleting batch values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            echo "Error deleting batch Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
        return array("success" => true, "message" => "Batch deleted successfully");
    }
    return array("error" => true, "message" => "Unknown error occurred: " . mysqli_error($connection));
}
function delete_batch_multiple($ids)
{
    global $table_batch_name, $connection;
    $query = "DELETE from $table_batch_name WHERE id IN (?)";
    $id_string = implode(',', $ids);
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('s', $id_string)) {
            // echo "Error deleting batch values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            // echo "Error deleting batch Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $safeQuery->close();
        return array("success" => true, "message" => "Batch deleted successfully");
    }
    return array("error" => true, "message" => "Unknown error occurred: " . mysqli_error($connection));
}

function get_batches($cid, $did)
{
    global $table_batch_name, $connection;
    $query = "SELECT * from $table_batch_name WHERE dpt_id = ? AND college_id = ?";
    $results = array();
    if ($safeQuery = mysqli_prepare($connection, $query)) {
        if (!$safeQuery->bind_param('ii', $did, $cid)) {
            // echo "Error getting batch values Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        if (!$safeQuery->execute()) {
            // echo "Error getting batch Error: " . $safeQuery->error;
            return array("error" => true, "message" => $safeQuery->error);
        }
        $res = $safeQuery->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results, $row);
        }
        $safeQuery->close();
        return $results;
    }
    return array("error" => true, "message" => "Unknown error occurred: " . mysqli_error($connection));
}
