<?php
session_start();

if (!(isset($_SESSION["user_logged"]))) {
    header("location:../login.html");
}
else{

$user = $_SESSION["user_logged"];

if ($user["role"] == "student") {
    ?>
    <div class="alert alert-danger" role="alert">
        شما مجوز ورود به این صفحه را ندارید .
        <a href="../login.html" class="alert-link">صفحه ی ورود</a>
    </div>
    <?php
}
else {
$term_ostad_dars_id = $_GET["term_ostad_dars_id"];
$dars_name = $_GET["dars_name"];

include("../db.php");
$conn = (new my_database())->connection_database;

$user_code = $user["user_code"];
$sql_teacher = "SELECT * FROM `ostad` WHERE `user_code` = $user_code";
$result_teacher = $conn->query($sql_teacher);

$ostad_code = -1;
if ($result_teacher->num_rows == 1) {
    $teacher = $result_teacher->fetch_assoc();
    //`ostad_name`,`ostad_family`
    $teacher_Fullname = "استاد:" . $teacher["ostad_name"] . ' ' . $teacher["ostad_family"];
    $ostad_code = $teacher["ostad_code"];
} else {
    echo "اطلاعات نامعتبر";
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

    <div class="mb-3 mt-3">
        <a href="../logout.php" class="btn btn-danger">خروج</a>
        <a href="teacher-dashboard.php" class="btn btn-primary">داشبورد استاد</a>
    </div>

    <h2>
        <?php echo $teacher_Fullname; ?>
    </h2>
    <h2>
        حضور و غیاب درس:
        <?php echo $dars_name; ?>
    </h2>

    <?php

    $students = [];
    $jalasat = [];

    //  دریافت لیست دانشجویان
    $sql_teacher_students = " SELECT ev.term_ostad_dars_id,st.student_code,st.student_name,st.student_family,st.student_codemeli 
                     FROM `entekhab_vahed` as ev 
                     INNER JOIN student as st on st.student_code = ev.student_code 
                     WHERE `term_ostad_dars_id` = $term_ostad_dars_id;";

    $result_teacher_students = $conn->query($sql_teacher_students);
    if ($result_teacher_students->num_rows > 0) {
        while ($row_teacher_student = $result_teacher_students->fetch_assoc()) {
            $students[] = $row_teacher_student;
        }
        // جلسات  بر اساس ورودی: کد ترم-استاد-درس
        $sql_jalasat = "SELECT * FROM `jaleseh` WHERE `term_ostad_dars_id`= $term_ostad_dars_id;";
        //exit($sql_jalasat);
        $result_jalasat = $conn->query($sql_jalasat);
        if ($result_jalasat->num_rows > 0) {
            while ($row_jalasat = $result_jalasat->fetch_assoc()) {
                $jalasat[] = $row_jalasat;
            }
        }
    } else {
        echo "جلسه ای برای این درس ثبت نشده است.";
    }

    ?>

    <h3>حضور و غیاب دانشجویان</h3>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">نام</th>
            <th scope="col">نام خانوادگی</th>
            <th scope="col">کد ملی</th>
            <th scope="col">عملیات ثبت نمره</th>
        </tr>
        </thead>
        <tbody>
        <?php

        $counter = 0;
        foreach ($students as $student) {
            $student_code = $student["student_code"];
            $student_name = $student["student_name"];
            $student_family = $student["student_family"];
            $student_codemeli = $student["student_codemeli"];

            ?>
            <tr>
                <td><?php echo $student_name ?></td>
                <td><?php echo $student_family ?> </td>
                <td> <?php echo $student_codemeli ?></td>
                <td>
                    <a href="teacher-manage-mark-dars-student.php?term_ostad_dars_id=<?php echo $term_ostad_dars_id."&dars_name=".$dars_name."&student_code=".$student_code."&student_fullname=".$student_name." ".$student_family."\"" ?>"
                       class="btn btn-primary">
                        ثبت نمره
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
    }
    ?>
    <script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/jquery/jquery.min.js"></script>
</body>
</html>
