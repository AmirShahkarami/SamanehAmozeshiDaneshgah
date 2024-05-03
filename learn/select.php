<?php

echo "select file";
echo "<hr>";

/*
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sad-db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    //echo "ارتباط با دیتابیس موفق میباشد";
    //die();
}
*/


include ("../db.php");
$conn = (new my_database())->connection_database;

$sql = "SELECT * FROM `user`";
$result = $conn->query($sql);

/*
echo $result->num_rows;
echo "<hr>";
die();
*/

if ($result->num_rows > 0) {
    /*
    var_dump(     $result->fetch_assoc());
    echo "<hr>";
    var_dump(     $result->fetch_assoc());
    echo "<hr>";
    var_dump(     $result->fetch_assoc());
    */
    /*
    echo $result->fetch_assoc()["username"];
    echo "<br>";
    echo $result->fetch_assoc()["username"];
    */


    /*
    $row1 = $result->fetch_assoc();
    $row2 = $result->fetch_assoc();
    $row3 = $result->fetch_assoc();
    $row4 = $result->fetch_assoc();

    var_dump(     $row1);
    echo "<hr>";
    var_dump(     $row2);
    echo "<hr>";
    var_dump(     $row3);
    echo "<hr>";
    var_dump(     $row4);
    echo "<hr>";
    echo "<hr>";

   // `user_code`, `username`, `password`, `role

    echo $row1["user_code"];
    echo "<hr>";
    echo "<hr>";
    echo $row1["password"];
    echo "<hr>";
    echo "<hr>";
*/

    // output data of each row

    while($row = $result->fetch_assoc()) {
        echo "user_code: " . $row["user_code"]. " - username:<span style='font-size: 24px'> " . $row["username"]. "</span>  password: <span style='font-size: 24px'>" . $row["password"]. "</span>  role: <span style='font-size: 24px'>" . $row["role"]. "</span><br>";
        //var_dump($row);
        //echo "<hr>";
    }
} else {
    echo "0 results";
}
$conn->close();