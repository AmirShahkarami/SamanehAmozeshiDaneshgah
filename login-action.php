<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>بررسی لاگین</title>
    <link rel="stylesheet" href="assets/bootstrap-5.3.3-dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <!-- Content here -->


    <?php

    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    include("db.php");
    $conn = (new my_database())->connection_database;

    if (
        isset($_POST["username"]) &&
        isset($_POST["password"]) &&
        isset($_POST["role"])

    ) {

        $sql = "SELECT * FROM `user` WHERE `username` LIKE '$username' AND `password` LIKE '$password' AND `role` LIKE '$role'";

        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $_SESSION["user_logged"] = $result->fetch_assoc();
            $user = $_SESSION["user_logged"];
            if ($user["role"] == "student") {
                header("location:student/student-hozor.php");
            } else if ($user["role"] == "teacher") {
                header("location:teacher/teacher-dashboard.php");
            } else if ($user["role"] == "admin") {
                header("location:admin/user-list.php");
            }
        } else {
            ?>
            <div class="alert alert-danger" role="alert">
                نام کاربری یا گذرواژه نامعتبر است. به صفحه ی ورود مراجعه کنید.
                <a href="login.html" class="alert-link">صفحه ی ورود</a>
            </div>
            <?php
        }
    } else {
        header("location:login.html");
    }
    ?>
</div>
</body>
</html>
