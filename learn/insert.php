<?php

echo "insert.file";

include ("../db.php");
$conn = (new my_database())->connection_database;

$sql = "INSERT INTO `user` (`user_code`, `username`, `password`, `role`) VALUES (NULL, 'tch2', 't2', 'teacher')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
