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

    $ostad_code = -1;
    if ($result_teacher->num_rows == 1) {
        $teacher = $result_teacher->fetch_assoc();
        //`ostad_name`,`ostad_family`
        $teacher_Fullname =  "استاد:" . $teacher["ostad_name"] . ' ' . $teacher["ostad_family"];
        $ostad_code = $teacher["ostad_code"];
    }
    else{
        echo "اطلاعات نامعتبر";
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
            <a href="../logout.php" class="btn btn-primary">خروج</a>
        </div>

        <h2>
            <?php echo $teacher_Fullname; ?>
        </h2>
    <div class="mb-3 mt-3">
    <a href="teacher-manage-hozor.php" class="btn btn-primary">مدیریت حضور و غیاب</a>
    <a href="user-managment-adduser.php" class="btn btn-primary">مدیریت نمرات</a>
    </div>

        <h2>لیست دروس ارائه شده</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">درس</th>
            </tr>
            </thead>
            <tbody>

            <?php


            $sql = "SELECT tod.term_ostad_dars_id ,o.ostad_code, o.ostad_name,o.ostad_family,d.dars_name 
                         FROM `term_ostad_dars` as tod 
                         INNER JOIN ostad_dars as od on tod.ostad_dars_code = od.id 
                         INNER JOIN ostad as o on od.ostad_code = o.ostad_code 
                         INNER JOIN dars as d on od.dars_code = d.dars_code 
                         WHERE o.ostad_code = $ostad_code;";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>

                     <tr>
        <td>
            <a href="teacher-manage-hozor.php?term_ostad_dars_id=<?php echo $row["term_ostad_dars_id"] ?>" class="btn btn-primary">
                <?php
                echo $row["dars_name"];
                ?>
            </a>
        </td>
    </tr>
         <?php
                }
            ?>

            </tbody>
        </table>

        <?php
    }
    ?>

</div>

<script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
