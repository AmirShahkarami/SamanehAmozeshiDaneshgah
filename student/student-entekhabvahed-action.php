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
    <title>داشبورد دانشجو</title>
    <link rel="stylesheet" href="../assets/bootstrap-5.3.3-dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/jquery/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <!-- Content here -->
    <?php
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
            $student_Fullname = "دانشجو:" . $student["student_name"] . ' ' . $student["student_family"];
            $student_code = $student["student_code"];
        }

        ?>
        <div class="mb-3 mt-3">
            <a href="../logout.php" class="btn btn-danger">خروج</a>
            <a href="student-dashboard.php" class="btn btn-primary">داشبورد</a>
        </div>


        <?php
        $ary_term_ostad_dars_id = $_POST["ary_term_ostad_dars_id"];
        $student_code = $_POST["student_code"];
        $student_Fullname = $_POST["student_Fullname"];
        //var_dump($ary_term_ostad_dars_id);

        $ary_id = explode(",", $ary_term_ostad_dars_id);
        //var_dump($ary_id);

        $sum_vahed = -1;
        $max_vahed_mojaz = 20;
        $alert = "";

        foreach ($ary_id as $id) {

            $sql_sum_vahed = "SELECT sum(ttt.dars_vahed) as \"sum_vahed\" from (
SELECT t.term_ostad_dars_id  ,t.ostad_name,t.ostad_family,t.dars_name,t.dars_vahed,tt.term_sal_tahsili,tt.term_shomareh FROM
(
SELECT tos.term_ostad_dars_id  ,o.ostad_name,o.ostad_family,d.dars_name,d.dars_vahed 
FROM ostad_dars  as od
INNER JOIN term_ostad_dars as tos on od.id = tos.ostad_dars_code
INNER JOIN ostad as o on o.ostad_code = od.ostad_code
INNER JOIN dars as d on d.dars_code = od.dars_code
WHERE `term_ostad_dars_id` in 
      (SELECT t1.`term_ostad_dars_id` 
       FROM `entekhab_vahed` as te 
           INNER join term_ostad_dars as t1 on te.term_ostad_dars_id = t1.term_ostad_dars_id 
           INNER join term as t2 on t2.term_code = t1.term_code 
           INNER join ostad_dars as t3 on t3.id = t1.ostad_dars_code 
       WHERE te.student_code = 101 and t1.term_code = (SELECT `term_code` FROM `term` WHERE `term_active` = 1 )
      
      )
) as t
JOIN
(SELECT t11.`term_ostad_dars_id` ,t22.term_sal_tahsili,t22.term_shomareh 
 FROM `entekhab_vahed` as te 
     INNER join term_ostad_dars as t11 on te.term_ostad_dars_id = t11.term_ostad_dars_id 
     INNER join term as t22 on t22.term_code = t11.term_code 
 WHERE `student_code` = 101) as tt
on t.term_ostad_dars_id = tt.term_ostad_dars_id
    ) as ttt";


            $result_sum_vahed = $conn->query($sql_sum_vahed);
            if ($result_sum_vahed->num_rows == 1) {
                $row_sum_vahed = $result_sum_vahed->fetch_assoc();
                $sum_vahed = $row_sum_vahed["sum_vahed"];

                if ($sum_vahed >= $max_vahed_mojaz) {
                    break;
                }
            }


            $sql_insert = "INSERT INTO `entekhab_vahed`(`id`, `term_ostad_dars_id`, `student_code`, `tozihat`) 
                                        VALUES (null,'$id','$student_code','')";

            $alert = "<div class=\"container mt-3\">
  <h2>نتیجه</h2>";
            if ($conn->query($sql_insert) === TRUE) {
                $alert .= "<div class=\"alert alert-success\">
    <strong>موفقیت آمیز!</strong> درس جدید با موفقیت ثبت شد.
  </div>";
            } else {
                $alert .= "
    <div class=\"alert alert-danger\">
    <strong>خطا!</strong> $conn->error
  </div>
    ";
            }
        }


        if ($sum_vahed >= $max_vahed_mojaz) {
            $alert .= "
    <div class=\"alert alert-danger\">
    <strong>خطا!</strong>
    تعداد واحد های اخذ شده نمیتواند بیشتر از حد مجاز باشد 
  </div>
    ";
        }


        echo $alert;

        ?>



        <h2>
            لیست دروس انتخاب شده -
            <?php echo $student_Fullname; ?>
        </h2>


        <?php
        $sql_term_ative = "SELECT * FROM `term` WHERE `term_active` = 1";
        $result_term_active = $conn->query($sql_term_ative);
        if ($result_term_active->num_rows == 1) {
            $row_term_active = $result_term_active->fetch_assoc();
            $term_active_title = $row_term_active["term_sal_tahsili"] . ":[" . $row_term_active["term_shomareh"] . "]";
        }
        ?>

        <h3>
            <span>ترم فعال:</span>
            <span>
    <?php
    if (isset($row_term_active)) {
        echo $term_active_title;
    }
    ?>
        </span>
        </h3>

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


            $sql_vahedhay_akhz_shodeh = "SELECT t.term_ostad_dars_id  ,t.ostad_name,t.ostad_family,t.dars_name,t.dars_vahed,tt.term_sal_tahsili,tt.term_shomareh FROM
(
SELECT tos.term_ostad_dars_id  ,o.ostad_name,o.ostad_family,d.dars_name,d.dars_vahed 
FROM ostad_dars  as od
INNER JOIN term_ostad_dars as tos on od.id = tos.ostad_dars_code
INNER JOIN ostad as o on o.ostad_code = od.ostad_code
INNER JOIN dars as d on d.dars_code = od.dars_code
WHERE `term_ostad_dars_id` in 
      (SELECT t1.`term_ostad_dars_id` 
       FROM `entekhab_vahed` as te 
           INNER join term_ostad_dars as t1 on te.term_ostad_dars_id = t1.term_ostad_dars_id 
           INNER join term as t2 on t2.term_code = t1.term_code 
           INNER join ostad_dars as t3 on t3.id = t1.ostad_dars_code 
       WHERE `student_code` = $student_code)
) as t
JOIN
(SELECT t11.`term_ostad_dars_id` ,t22.term_sal_tahsili,t22.term_shomareh 
 FROM `entekhab_vahed` as te 
     INNER join term_ostad_dars as t11 on te.term_ostad_dars_id = t11.term_ostad_dars_id 
     INNER join term as t22 on t22.term_code = t11.term_code 
 WHERE `student_code` = $student_code) as tt
on t.term_ostad_dars_id = tt.term_ostad_dars_id
;";

            //exit($sql_vahedhay_akhz_shodeh);

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
                    $term_title = $row_dros_term["term_sal_tahsili"] . ":[" . $row_dros_term["term_shomareh"] . "]";
                    $ostad_Fullname = $ostad_name . ' ' . $ostad_family;
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
                    echo "$term_title";
                    echo "</td>";

                    echo "<td>";
                    $chk_id = "chk_" . $term_ostad_dars_id;

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
        <hr>

        <?php
        $sql_sum_vahed = "SELECT sum(ttt.dars_vahed) as \"sum_vahed\" from (
SELECT t.term_ostad_dars_id  ,t.ostad_name,t.ostad_family,t.dars_name,t.dars_vahed,tt.term_sal_tahsili,tt.term_shomareh FROM
(
SELECT tos.term_ostad_dars_id  ,o.ostad_name,o.ostad_family,d.dars_name,d.dars_vahed 
FROM ostad_dars  as od
INNER JOIN term_ostad_dars as tos on od.id = tos.ostad_dars_code
INNER JOIN ostad as o on o.ostad_code = od.ostad_code
INNER JOIN dars as d on d.dars_code = od.dars_code
WHERE `term_ostad_dars_id` in 
      (SELECT t1.`term_ostad_dars_id` 
       FROM `entekhab_vahed` as te 
           INNER join term_ostad_dars as t1 on te.term_ostad_dars_id = t1.term_ostad_dars_id 
           INNER join term as t2 on t2.term_code = t1.term_code 
           INNER join ostad_dars as t3 on t3.id = t1.ostad_dars_code 
       WHERE te.student_code = 101 and t1.term_code = (SELECT `term_code` FROM `term` WHERE `term_active` = 1 )
      
      )
) as t
JOIN
(SELECT t11.`term_ostad_dars_id` ,t22.term_sal_tahsili,t22.term_shomareh 
 FROM `entekhab_vahed` as te 
     INNER join term_ostad_dars as t11 on te.term_ostad_dars_id = t11.term_ostad_dars_id 
     INNER join term as t22 on t22.term_code = t11.term_code 
 WHERE `student_code` = 101) as tt
on t.term_ostad_dars_id = tt.term_ostad_dars_id
    ) as ttt";
        $result_sum_vahed = $conn->query($sql_sum_vahed);
        if ($result_sum_vahed->num_rows == 1) {
            $row_sum_vahed = $result_sum_vahed->fetch_assoc();
            $sum_vahed = $row_sum_vahed["sum_vahed"];
        }
        ?>

        <h3>
            <span> مجموع واحد های اخذ شده:</span>
            <span>
    <?php
    if (isset($sum_vahed)) {
        echo $sum_vahed;
    }
    ?>
        </span>
        </h3>


        <?php
    }
    ?>

</div>


<script>
    id_ary = []

    function checkboxes_term_ostad_dars_id(id_control) {
        selector = "#" + id_control
        //document.querySelector("#chk_2").value
        //console.log("selector="+selector)
        chkbox_clicked = document.querySelector(selector)
        id = document.querySelector(selector).value
        if (chkbox_clicked.checked == true) {
            id_ary.push(id)

        } else {
            removeItemFromArrayByValue(id, id_ary)
        }
        document.querySelector("#ary_term_ostad_dars_id").value = id_ary.join(",")
        console.log("id: " + id)
        console.log("id_ay lenght: " + id_ary.length)

    }

    function removeItemFromArrayByValue(v, ary) {
        var index = ary.indexOf(v);
        if (index !== -1) {
            ary.splice(index, 1);
        }
    }
</script>
<script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

