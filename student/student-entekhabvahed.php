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
            $student_Fullname =  "دانشجو:" . $student["student_name"] . ' ' . $student["student_family"];
            $student_code = $student["student_code"];
        }

        ?>
        <div class="mb-3 mt-3">
            <a href="../logout.php"class="btn btn-danger">خروج</a>
            <a href="student-dashboard.php" class="btn btn-primary">داشبورد</a>
        </div>

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

        <h2>
            <?php echo $student_Fullname; ?>
        </h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">استاد</th>
                <th scope="col">درس</th>
                <th scope="col">عملیات</th>
            </tr>
            </thead>
            <tbody>

                <?php

                $tod_ghbol_code_ary = [];
                $sql_tod_ghabol_shodeh = "SELECT tn.nomarat_code,tn.nomreh,tn.entekhab_vahed_code ,te.term_ostad_dars_id , drs.dars_code,drs.dars_name 
                    FROM `nomarat` as tn 
                        INNER JOIN entekhab_vahed as te on tn.entekhab_vahed_code = te.id 
                        INNER JOIN term_ostad_dars as tod on tod.term_ostad_dars_id = te.term_ostad_dars_id 
                        INNER JOIN ostad_dars as od on od.id = tod.ostad_dars_code 
                        INNER JOIN dars as drs on od.dars_code = drs.dars_code 
                    WHERE tn.nomreh >= 10 and tn.entekhab_vahed_code in ( SELECT `id` FROM `entekhab_vahed` WHERE `student_code` = $student_code );";


                $result_tod_ghabol = $conn->query($sql_tod_ghabol_shodeh);
                if($result_tod_ghabol->num_rows > 0 ){
                    while ($row_tod_ghabol = $result_tod_ghabol->fetch_assoc()){
                        $tod_ghbol_code_ary[] = $row_tod_ghabol["dars_code"];
                    }
                }


                 //var_dump($tod_ghbol_code_ary);
                //print_r($tod_ghbol_code_ary);

                /*exit("***********************");*/


                $sql_dros_term_active = "select t3.`term_ostad_dars_id`,t3.`term_code`,t3.`ostad_code`,t3.`dars_code`,t3.`term_sal_tahsili` ,t3.term_shomareh,t3.ostad_name ,t3.ostad_family ,t6.dars_name 
                            from (select t3.`term_ostad_dars_id`,t3.`term_code`,t3.term_shomareh,t3.`ostad_code`,t3.`dars_code`,t3.`term_sal_tahsili` ,t4.ostad_name ,t4.ostad_family 
                                        from (select t1.`term_ostad_dars_id`,t1.`term_code`,t1.`ostad_code`,t1.`dars_code`,t2.`term_sal_tahsili`,t2.term_shomareh 
                                              from (SELECT `term_ostad_dars`.`term_ostad_dars_id`,`term_ostad_dars`.`term_code` , `ostad_dars`.`ostad_code` ,`ostad_dars`.`dars_code` 
                                                    FROM `term_ostad_dars` INNER JOIN `ostad_dars` on `term_ostad_dars`.`ostad_dars_code` = `ostad_dars`.`id`) 
                                                  AS t1 join `term` as t2 on t1.`term_code` = t2.`term_code`) as t3 join `ostad` as t4 on t3.`ostad_code` = t4.ostad_code) 
                                                    as t3 join `dars` as t6 on t3.`dars_code` = t6.dars_code
                                                    WHERE t3.`term_code` =(SELECT `term_code` FROM `term` WHERE `term_active` = 1);";

                $result_dros_term_active = $conn->query($sql_dros_term_active);


                if ($result_dros_term_active->num_rows > 0) {

                    // `term_code`, `term_sal_tahsili`, `term_shomareh`, `tozihat`
                    while ($row_dros_term = $result_dros_term_active->fetch_assoc()) {
                        // INSERT INTO `entekhab_vahed`(`id`, `term_ostad_dars_id`, `student_code`, `tozihat`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')
                        // ostad_name ,ostad_family ,dars_name
                        //echo  $row_dros_term["dars_code"];
                        //echo "<br>";
                        $is_dissabled = false;
                        if(( gettype( array_search($row_dros_term["dars_code"],$tod_ghbol_code_ary))) == "integer"){
                            //var_dump(array_search($row_dros_term["dars_code"],$tod_ghbol_code_ary));
                            $is_dissabled = true;
                        }
                        //var_dump(array_search($row_dros_term["dars_code"],$tod_ghbol_code_ary));
                        //echo "<hr>";

                        //exit("<hr>");

                        $term_ostad_dars_id = $row_dros_term["term_ostad_dars_id"];
                        $ostad_name = $row_dros_term["ostad_name"];
                        $ostad_family = $row_dros_term["ostad_family"];
                        $dars_name = $row_dros_term["dars_name"];
                        $ostad_Fullname = $ostad_name  . ' '.$ostad_family;
                    echo "<tr>";
                        echo "<td>";
                        echo "$ostad_Fullname";
                        echo "</td>";

                        echo "<td>";
                        echo "$dars_name";
                        echo "</td>";

                         echo "<td>";
                         if($is_dissabled == false) {
                             $chk_id = "chk_" . $term_ostad_dars_id;
                             echo "<input type='checkbox' id='$chk_id' onclick='checkboxes_term_ostad_dars_id(\"$chk_id\")' value='$term_ostad_dars_id'>";
                         }
                        echo "</td>";
                    echo "</tr>";
                    }
                    echo "</tbody>
                    </table>";
                } else {
                    echo " ثبت نشده!";
                }
                ?>
                <td>
                    <form id="form_term_ostad_dars_add" action="student-entekhabvahed-action.php" method="post">
                        <input type="hidden" name="ary_term_ostad_dars_id" id="ary_term_ostad_dars_id" value="">
                        <input type="hidden" name="student_code"  value="<?php  echo $student_code ?>">
                        <input type="hidden" name="student_Fullname"  value="<?php  echo $student_Fullname ?>">
                        <input type="submit" class="btn btn-primary d-block" value="ثبت" >
                    </form>
                </td>
            </tr>
            </tbody>
        </table>


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


            $sql_vahedhay_akhz_shodeh = "SELECT t.term_ostad_dars_id  ,t.ostad_name,t.ostad_family,t.dars_name,t.dars_vahed,tt.term_sal_tahsili ,tt.term_shomareh FROM
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
(SELECT t11.`term_ostad_dars_id` ,t22.term_sal_tahsili ,t22.term_shomareh 
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
                    echo "$term_title";
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
    id_ary=[]
    function checkboxes_term_ostad_dars_id(id_control){
        selector = "#"+id_control
        //document.querySelector("#chk_2").value
        //console.log("selector="+selector)
        chkbox_clicked = document.querySelector(selector)
        id = document.querySelector(selector).value
        if(chkbox_clicked.checked == true){
            id_ary.push(id)

        }
        else{
            removeItemFromArrayByValue(id,id_ary)
        }
        document.querySelector("#ary_term_ostad_dars_id").value = id_ary.join(",")
        console.log("id: " +id)
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

