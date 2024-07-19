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
$nomreh = $_POST["nomreh"];
$term_ostad_dars_id = $_POST["term_ostad_dars_id"];
$student_code = $_POST["student_code"];

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

    <?php
    $sql_entekhabahed = "SELECT `id` FROM `entekhab_vahed` 
            WHERE `term_ostad_dars_id` = $term_ostad_dars_id AND `student_code` = $student_code;";
    $result_1 = $conn->query($sql_entekhabahed);
    if ($result_1->num_rows == 1) {
        $row_1 = $result_1->fetch_assoc();
        $entekhabvahed_id = $row_1["id"];

        $sql_insert = "INSERT INTO `nomarat`(`nomarat_code`, `entekhab_vahed_code`, `nomreh`, `vazeiat_eeteraz`, `tozihat`) 
                        VALUES (null,$entekhabvahed_id,$nomreh,' ',' ')";
        $result_insert = $conn->query($sql_insert);
        if ($result_insert > 0) {
            echo "با موفقیت ثبت شد";
        }
    }
    }
    }
    ?>

    <script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/jquery/jquery.min.js"></script>
</body>
</html>
