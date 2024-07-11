<?php
session_start();

if (!(isset($_SESSION["user_logged"]))) {
    header("location:../login.html");
}

include("../db.php");
$conn = (new my_database())->connection_database;

$user = $_SESSION["user_logged"];
if ($user["role"] != "student") {
    ?>
    <div class="alert alert-danger" role="alert">
        شما مجوز ورود به این صفحه را ندارید .
        <a href="../login.html" class="alert-link">صفحه ی ورود</a>
    </div>
    <?php
} else {
$user_code = $user["user_code"];

$sql_student = "SELECT * FROM `student` WHERE `user_code` = $user_code";
$result_student = $conn->query($sql_student);
if ($result_student->num_rows == 1) {
    $student = $result_student->fetch_assoc();
    //`student_name`,`student_family`
    $student_Fullname =  "دانشجو:" . $student["student_name"] . ' ' . $student["student_family"];
    $student_code = $student["student_code"];
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

    <h1><?php echo $student_Fullname; ?></h1>
    <a href="student-entekhabvahed.php"> انتخاب واحد</a>

    <h2>واحد های اخذ شده</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">استاد</th>
            <th scope="col">درس</th>
            <th scope="col">تعداد واحد</th>
            <th scope="col">ترم</th>
        </tr>
        </thead>
        <tbody>

        <?php


        $sql_vahedhay_akhz_shodeh = "SELECT t.term_ostad_dars_id  ,t.ostad_name,t.ostad_family,t.dars_name,t.dars_vahed,tt.term_sal_tahsili FROM
(
SELECT tos.term_ostad_dars_id  ,o.ostad_name,o.ostad_family,d.dars_name,d.dars_vahed FROM ostad_dars  as od
INNER JOIN term_ostad_dars as tos on od.id = tos.ostad_dars_code
INNER JOIN ostad as o on o.ostad_code = od.ostad_code
INNER JOIN dars as d on d.dars_code = od.dars_code
WHERE `term_ostad_dars_id` = (SELECT t1.`term_ostad_dars_id` FROM `entekhab_vahed` as te INNER join term_ostad_dars as t1 on te.term_ostad_dars_id = t1.term_ostad_dars_id INNER join term as t2 on t2.term_code = t1.term_code INNER join ostad_dars as t3 on t3.id = t1.ostad_dars_code WHERE `student_code` = $student_code)) as t
JOIN
(SELECT t11.`term_ostad_dars_id` ,t22.term_sal_tahsili FROM `entekhab_vahed` as te INNER join term_ostad_dars as t11 on te.term_ostad_dars_id = t11.term_ostad_dars_id INNER join term as t22 on t22.term_code = t11.term_code WHERE `student_code` = $student_code) as tt
on t.term_ostad_dars_id = tt.term_ostad_dars_id
;";

        $result_hedhay_akhz_shodeh = $conn->query($sql_vahedhay_akhz_shodeh);


        if ($result_hedhay_akhz_shodeh->num_rows > 0) {

            // `term_code`, `term_sal_tahsili`, `term_shomareh`, `tozihat`
            while ($row_dros_term = $result_hedhay_akhz_shodeh->fetch_assoc()) {
                // term_ostad_dars_id  ,ostad_name,ostad_family,dars_name,dars_vahed,term_sal_tahsili
                $term_ostad_dars_id = $row_dros_term["term_ostad_dars_id"];
                $ostad_name = $row_dros_term["ostad_name"];
                $ostad_family = $row_dros_term["ostad_family"];
                $dars_name = $row_dros_term["dars_name"];
                $dars_vahed = $row_dros_term["dars_vahed"];
                $term_sal_tahsili = $row_dros_term["term_sal_tahsili"];
                $ostad_Fullname = $ostad_name  . ' '.$ostad_family;
                echo "<tr>";
                echo "<td>";
                echo "$ostad_Fullname";
                echo "</td>";

                echo "<td>";
                echo "$dars_name";
                echo "</td>";

                echo "<td>";
                echo "$dars_vahed";
                echo "</td>";

                echo "<td>";
                echo "$term_sal_tahsili";
                echo "</td>";

                echo "<td>";
                $chk_id = "chk_".$term_ostad_dars_id;

                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>
                    </table>";
        } else {
            echo " ثبت نشده!";
        }
        ?>


        </tbody>
    </table>
</div>
<script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
}