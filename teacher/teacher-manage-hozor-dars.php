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


    $sql_hozor_gheyab_sabt_shodeh = "  SELECT hg.entekhab_vahed_code , hg.vazeiat_hozor ,stu.student_code, stu.student_name , stu.student_family ,stu.student_codemeli , jls.jaleseh_tarikh , jls.jaleseh_shomareh ,jls.jaleseh_code 
FROM `hozor_gheyab` as hg 
    INNER JOIN entekhab_vahed as ev on hg.entekhab_vahed_code = ev.id 
    INNER JOIN term_ostad_dars as tod on ev.term_ostad_dars_id = tod.term_ostad_dars_id 
    INNER JOIN student as stu on stu.student_code = ev.student_code 
    INNER JOIN jaleseh as jls on jls.jaleseh_code = hg.jaleseh_id
    
 WHERE `entekhab_vahed_code`  IN ( SELECT id FROM `entekhab_vahed` WHERE `term_ostad_dars_id` =  $term_ostad_dars_id)";

    //echo $sql_hozor_gheyab_sabt_shodeh;
    //exit("<hr><hr>");

    
    $hozor_gheyab_sabt_shodeh = [];
    $result_sql_hozor_gheyab_sabt_shodeh = $conn->query($sql_hozor_gheyab_sabt_shodeh);
    if($result_sql_hozor_gheyab_sabt_shodeh->num_rows > 0){
     while ($row_hozor_gheyab_sabt_shodeh = $result_sql_hozor_gheyab_sabt_shodeh->fetch_assoc()){
         $hozor_gheyab_sabt_shodeh[]  = $row_hozor_gheyab_sabt_shodeh;
     }
    }


    //var_dump($hozor_gheyab_sabt_shodeh);
    //exit("<hr><hr>");


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
            <?php
            $jalasat_count = count($jalasat);
            foreach ($jalasat as $jaleseh) {
                ?>
                <th class="th-table-tarikh">
                    <?php echo $jaleseh["jaleseh_shomareh"] . "<br>" . $jaleseh["jaleseh_tarikh"]; ?>
                </th>
                <?php
            }
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
        $student_count = count($students);
        $student_code_stringAray = "[";
        $jalasat_code_stringAray = "[";
        $jalasat_value_stringAray = "[";
        $counter_jalesat = 0;
        foreach ($jalasat as $jaleseh) {
            if ($counter_jalesat == 0) {
                $jalasat_code_stringAray .= " " . $jaleseh["jaleseh_code"];
                //$jalasat_value_stringAray .= " " . $jaleseh["jaleseh_code"];
            } else {
                $jalasat_code_stringAray .= " , " . $jaleseh["jaleseh_code"];
            }
            $counter_jalesat++;
        }
        $jalasat_code_stringAray .= "]";

        $counter = 0;
        foreach ($students as $student) {
            $student_code = $student["student_code"];
            $student_name = $student["student_name"];
            $student_family = $student["student_family"];
            $student_codemeli = $student["student_codemeli"];
            if ($counter == 0) {
                $student_code_stringAray .= "$student_code";
            } else {
                $student_code_stringAray .= " , " . $student_code;
            }
            ?>
            <tr>
                <td><?php echo $student_name ?></td>
                <td><?php echo $student_family ?> </td>
                <td> <?php echo $student_codemeli ?></td>
                <?php
                $counter_jalesat = 1;
                //$hozor_gheyab_sabt_shodeh
                foreach ($hozor_gheyab_sabt_shodeh as $jaleseh) {
                    if($jaleseh["student_code"]==$student_code){
                    $control_name_id = "tod_" . $term_ostad_dars_id . "-studentcode_" . $student_code . "-jalesehcode_" . $jaleseh["jaleseh_code"];
                    ?>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input jaleseh-check jalasat-studentcode-<?php echo $student_code ?>"
                                   type="checkbox" role="switch"
                                   id="<?php echo $control_name_id ?>" name="<?php echo $control_name_id ?>"
                                   title="<?php echo $jaleseh["jaleseh_tarikh"] ?>"
                                   datajalasehcode="<?php echo $jaleseh["jaleseh_code"] ?>"
                                   value="<?php echo $jaleseh["vazeiat_hozor"] ?>"

                                   <?php
                                   if($jaleseh["vazeiat_hozor"]== "true"){
                                       ?>
                                            checked />
                                           <?php
                                   }
                                   else{
                                       ?>
                                            />
                                       <?php
                                   }
                                   ?>

                            <label class="form-check-label" for="<?php echo $control_name_id ?>"
                                   title="<?php echo $jaleseh["jaleseh_tarikh"] ?>">حاضر</label>
                        </div>
                    </td>
                    <?php
                }
                }
                ?>
            </tr>
            <?php
            $counter++;
        }
        $student_code_stringAray .= "]";

        //var_dump($student_code_stringAray);
        //exit("<hr>********************");
        ?>
        </tbody>
    </table>

    <form action="teacher-manage-hozor-dars-action.php" method="post">
        <input type="hidden" name="term_ostad_dars_id" id="term_ostad_dars_id"
               value="<?php echo $term_ostad_dars_id ?>">
        <input type="hidden" name="jalasat_hozor_students_data" value="" id="jalasat_hozor_students_data">
        <input type="hidden" name="dars_name" value="<?php echo $dars_name; ?>" id="dars_name">

        <input type="submit" value="ثبت">
    </form>
    <?php
    }
    }
    ?>
    <script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/jquery/jquery.min.js"></script>
    <script>
        jalasat_hozor_students_array = [];
        student_code_ary = [];
        jalasat_code_ary = [];

        <?php
        echo "student_code_ary = " . $student_code_stringAray . ";";
        echo "jalasat_code_ary = " . $jalasat_code_stringAray . ";";
        ?>

        $(document).ready(function () {
            $(".jaleseh-check").click(function () {
                if ($(this).val() == "true")
                    $(this).val("false");
                else
                    $(this).val("true");

                //console.log($(this).val());
                jalasat_json = "{ \"jalasat_hozor\": {\"tod\":";
                term_ostad_dars_id = $("#term_ostad_dars_id").val()
                jalasat_json += term_ostad_dars_id;
                jalasat_json += ",\"students\":[";

                counter_students = 0;
                if (student_code_ary.length > 0) {
                    for (n = 0; n < student_code_ary.length; n++) {
                        jalasat_studentcode = document.getElementsByClassName("jalasat-studentcode-" + student_code_ary[n]);
                        //console.log("jalasat_studentcode[0]  = " + jalasat_studentcode[0])
                        console.log("jalasat_studentcode[0].getAttribute('datajalasehcode')  = " + jalasat_studentcode[0].getAttribute('datajalasehcode'))
                        student_json = "";
                        if (counter_students == 0) {
                            student_json = "{\"student_code\":" + student_code_ary[0] + ", \"jalasat\":[";
                        } else {
                            student_json += "," + "{\"student_code\":" + student_code_ary[n] + ", \"jalasat\":[";
                        }
                        counter_students++;

                        //console.log("student_json="+student_json)
                        //break;

                        student_jalasat_json = "";
                        counter_jalasat = 0;
                        for (j = 0; j < jalasat_code_ary.length; j++) {
                            for (k = 0; k < jalasat_studentcode.length; k++) {
                                if (jalasat_studentcode[k].getAttribute("datajalasehcode") == jalasat_code_ary[j]) {
                                    value = jalasat_studentcode[k].getAttribute("value");
                                    if (counter_jalasat == 0) {
                                        student_jalasat_json = "{\"jalesehcode\":" + jalasat_code_ary[j] + ",\"value\":\"" + value + "\"}";
                                        counter_jalasat++;
                                    } else {
                                        student_jalasat_json += "," + "{\"jalesehcode\":" + jalasat_code_ary[j] + ",\"value\":\"" + value + "\"}";
                                        counter_jalasat++;
                                    }
                                }
                            }
                        }
                        student_json += student_jalasat_json + "]}"
                        jalasat_json += student_json;
                    }
                }


                //jalasat_hozor_students_data

                jalasat_json += "] } }";
                document.getElementById("jalasat_hozor_students_data").value = jalasat_json;
                console.log("jalasat_json=" + jalasat_json)
                //console.log("#######################################")

                jaleseh_check_items = document.getElementsByClassName("jaleseh-check");
                //console.log("jc_items.length=" + jc_items.length)
                jalasat_hozor_students_array = [];
                for (n = 0; n < jaleseh_check_items.length; n++) {
                    jalasat_hozor_students_array.push("{id:" + jaleseh_check_items[n].getAttribute("id") +
                        ", value:" + jaleseh_check_items[n].getAttribute("value") + "}");
                    //console.log(jaleseh_check_items[n].getAttribute("id"));
                }

                //console.log("==============================");

                let data_jalasat = "{";
                for (n = 0; n < jalasat_hozor_students_array.length; n++) {
                    //console.log(jalasat_hozor_students_array[n])
                    if (n > 0) {
                        data_jalasat += "," + jalasat_hozor_students_array[n]
                    } else {
                        data_jalasat += jalasat_hozor_students_array[n]
                    }
                }

                data_jalasat += "}"
                //console.log("data_jalasat=" + data_jalasat)
            });
        });


    </script>
</body>
</html>
