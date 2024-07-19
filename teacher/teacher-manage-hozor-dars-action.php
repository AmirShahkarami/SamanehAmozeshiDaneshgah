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
} else {


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

    if (isset($_POST["jalasat_hozor_students_data"]) && isset($_POST["term_ostad_dars_id"]) && isset($_POST["dars_name"])) {
        $dars_name = $_POST["dars_name"];
        $term_ostad_dars_id = $_POST["term_ostad_dars_id"];
        $jalasat_hozor_students_data_json = $_POST["jalasat_hozor_students_data"];

        $jalasat_hozor_students_data = json_decode($jalasat_hozor_students_data_json);
        if (isset($jalasat_hozor_students_data->jalasat_hozor)) {
            $students = $jalasat_hozor_students_data->jalasat_hozor->students;
            var_dump($jalasat_hozor_students_data->jalasat_hozor);
        }
        exit("47");
        foreach ($students as $student) {
            echo "<h2>" . $student->student_code . "</h2>";
            foreach ($student->jalasat as $jalaseh) {
                $sql_entekhabvahed = "SELECT `id` FROM `entekhab_vahed` 
                                        WHERE `term_ostad_dars_id` = $term_ostad_dars_id 
                                          AND `student_code` = $student->student_code ";
                $result_entekhabvahed = $conn->query($sql_entekhabvahed);
                if ($result_entekhabvahed->num_rows == 1) {
                    $row_entekhabvahed = $result_entekhabvahed->fetch_assoc();

                    $entekhab_vahed_code = $row_entekhabvahed["id"];
                    $jalaseh_id = $jalaseh->jalesehcode;
                    $sql_student_jalaseh_hozor = "SELECT * FROM `hozor_gheyab` 
                                                    WHERE `entekhab_vahed_code` = $entekhab_vahed_code
                                                    AND `jaleseh_id` =  $jalaseh_id";

                    $result_student_jalaseh_hozor = $conn->query($sql_student_jalaseh_hozor);
                    if ($result_student_jalaseh_hozor->num_rows > 0) {
                        $row_sjh = $result_student_jalaseh_hozor->fetch_assoc();
                        $hozor_gheyab_id = $row_sjh["hozor_gheyab_id"];
                        $sql_update_hozor = "UPDATE `hozor_gheyab` SET `vazeiat_hozor` = '$jalaseh->value' 
                      WHERE `hozor_gheyab`.`hozor_gheyab_id` = $hozor_gheyab_id;";
                        $result_update_hozor = $conn->query($sql_update_hozor);
                    } else {
                        $empty_string = "";
                        $sql_insert_hozor = " INSERT INTO `hozor_gheyab`(`hozor_gheyab_id`, `entekhab_vahed_code`, `jaleseh_id`, `vazeiat_hozor`, `movajah`) 
                                            VALUES (null,$entekhab_vahed_code,$jalaseh_id,'$jalaseh->value','$empty_string')";
                        $result_insert_hozor = $conn->query($sql_insert_hozor);
                    }
                }
                //echo "<h3>" . $jalaseh->jalesehcode . " " . $jalaseh->value . "</h3>";
            }
        }
    }
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
        ثبت حضور و غیاب درس:
        <?php echo $dars_name; ?>
    </h2>

    <?php


    /*
     echo "term_ostad_dars_id=" . $term_ostad_dars_id;
    echo "<hr>";
    var_dump($jalasat_hozor_students_data_json);

    echo "<hr>";
    */


    /*
    var_dump($jalasat_hozor_students_data);
    echo "<hr>";
    var_dump($jalasat_hozor_students_data->jalasat_hozor);
    echo "<hr>";
    var_dump($jalasat_hozor_students_data->jalasat_hozor->tod);
    echo "<hr>";
    var_dump($jalasat_hozor_students_data->jalasat_hozor->students);
    echo "<hr>";
    var_dump($jalasat_hozor_students_data->jalasat_hozor->students[0]);
    echo "<hr>";
    var_dump($jalasat_hozor_students_data->jalasat_hozor->students[0]->student_code);
    echo "<hr>";
    var_dump($jalasat_hozor_students_data->jalasat_hozor->students[0]->jalasat);
    echo "<hr>";
    echo(count($jalasat_hozor_students_data->jalasat_hozor->students[0]->jalasat));
    echo "<hr>";
    */


    ?>

    <?php
    }
    ?>
    <script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/jquery/jquery.min.js"></script>
</body>
</html>





