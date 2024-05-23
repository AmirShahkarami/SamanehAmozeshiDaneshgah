<?php
session_start();

if (!(isset($_SESSION["user_logged"]))) {
    header("location:../login.html");
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>داشبورد استاد</title>
    <link rel="stylesheet" href="../assets/bootstrap-5.3.3-dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
    <!-- Content here -->
    <?php
    include("../db.php");
    $conn = (new my_database())->connection_database;

    $user = $_SESSION["user_logged"];

    $user_code = $user["user_code"];
    $sql_teacher = "SELECT * FROM `ostad` WHERE `user_code` = $user_code";
    $result_teacher = $conn->query($sql_teacher);
    if ($result_teacher->num_rows == 1) {
        $teacher = $result_teacher->fetch_assoc();
        //`ostad_name`,`ostad_family`
        $teacher_Fullname =  "استاد:" . $teacher["ostad_name"] . ' ' . $teacher["ostad_family"];
    }




    if ($user["role"] == "student") {
        ?>
        <div class="alert alert-danger" role="alert">
            شما مجوز ورود به این صفحه را ندارید .
            <a href="../login.html" class="alert-link">صفحه ی ورود</a>
        </div>
        <?php
    } else {

        ?>
        <div class="mb-3 mt-3">
            <a href="user-managment-adduser.php" class="btn btn-primary">اضافه کردن کاربر جدید</a>
            <a href="../logout.php" class="btn btn-primary">خروج</a>
        </div>

        <h2>
            <?php echo $teacher_Fullname; ?>
        </h2>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">code</th>
                <th scope="col">username</th>
                <th scope="col">password</th>
                <th scope="col">role</th>
                <th scope="col">عملیات</th>
            </tr>
            </thead>
            <tbody>

            <?php


            $sql = "SELECT `student_code`,`student_name`,`student_family`,`student_codemeli` FROM `student` ";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $student_code = $row["student_code"];
                    $student_name = $row["student_name"];
                    $student_family = $row["student_family"];
                    $student_codemeli = $row["student_codemeli"];
                    echo " <tr>
        <td >" . $row["student_code"] . "</td>
        <td>" . $row["student_name"] . "</td>
        <td>" . $row["student_family"] . "</td>
        <td>" . $row["student_codemeli"] . "</td>
        <td>
        <a href=\"user-managment-update.php?user_code=$student_code\">
        بروزرسانی
        </a>
        |
        <a href=\"user-managment-delete.php?user_code=$student_code\" class=''>
        حذف
        </a>
</td>
    </tr>";
                    //echo "user_code: " . $row["user_code"]. " - username:<span style='font-size: 24px'> " . $row["username"]. "</span>  password: <span style='font-size: 24px'>" . $row["password"]. "</span>  role: <span style='font-size: 24px'>" . $row["role"]. "</span><br>";

                }
            } else {
                echo "0 results";
            }


            ?>

            </tbody>
        </table>

        <form action="" method="get">
            <div class="mb-3 mt-3">
                <label for="username" class="form-label">نام کاربری</label>
                <input type="search" class="form-control" id="username" placeholder="جستجوی نام کاربری" name="username"
                       value="">
            </div>
        </form>
        <?php
    }
    ?>

</div>

<script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
