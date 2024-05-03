<?php


$user_code = $_GET['user_code'];

//echo $user_code;

include("../db.php");
$conn = (new my_database())->connection_database;

$sql = "SELECT * FROM `user` WHERE `user_code` = $user_code";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    $user_code = $row["user_code"];
    $username = $row["username"];
    $password = $row["password"];
    $role = $row["role"];
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>فرم بروزرسانی</title>
    <link rel="stylesheet" href="../assets/bootstrap-5.3.3-dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
    <!-- Content here -->
    <form action="user-managment-update-action.php" method="post">
        <div class="mb-3 mt-3">
            <label for="username" class="form-label">نام کاربری</label>
            <input type="text" class="form-control" id="username" placeholder="نام کاربری" name="username"
                   value="<?php echo $username; ?>">
        </div>
        <div class="mb-3 mt-3">
            <label for="password" class="form-label">کلمه ی عبور</label>
            <input type="text" class="form-control" id="password" placeholder="کلمه عبور" name="password"
                   value="<?php echo $password; ?>">
        </div>


        <div class="form-check">
            <input class="form-check-input" type="radio" name="role"
                   id="role1" <?php
            if ($role == "student") echo "checked";
            ?> value="student">
            <label class="form-check-label" for="role1">
                نقش دانشجو
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="role"
                   id="role2" <?php
            if ($role == "teacher") echo "checked";
            ?> value="teacher">
            <label class="form-check-label" for="role2">
                نقش استاد
            </label>
        </div>

        <input type="hidden" name="user_code" value="<?php echo $user_code; ?>">

        <div class="mb-3 mt-3">
            <button type="submit" class="btn btn-primary">ثبت تغییرات</button>

            <a href="user-list.php" class="btn btn-primary">لیست کاربران</a>
        </div>

    </form>
</div>
<script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
