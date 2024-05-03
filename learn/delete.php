<?php

echo "delete.file";

include ("../db.php");
$conn = (new my_database())->connection_database;

// sql to delete a record
$sql = "DELETE FROM user WHERE `user`.`user_code` = 5";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
