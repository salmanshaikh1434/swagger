<?php

$host = "54.91.199.89";
$db_name = "asidb";
$username = "u_asidb";
$password = "RooT@@123";

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sqlUpdate = "
    UPDATE jnl
    SET tstamp = (
        SELECT tstamp
        FROM jnh
        WHERE jnh.sale = jnl.sale AND jnh.date = jnl.date
    )
    WHERE EXISTS (
        SELECT 1
        FROM jnh
        WHERE jnh.sale = jnl.sale AND jnh.date = jnl.date
    )";

if ($conn->query($sqlUpdate,MYSQLI_ASYNC) === TRUE) {
    echo json_encode(array("message" => "tstamp updated successfully"));
} else {
    echo json_encode(array("message" => "failed to update tstamp: " . $conn->error));
}


$conn->close();
?>