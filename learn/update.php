<?php

echo "update.file";

include ("../db.php");
$conn = (new my_database())->connection_database;

$sql = "UPDATE `user` SET `username` = 'tch2', `password` = 't2', `role` = 'teacher' WHERE `user`.`user_code` = 5";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
