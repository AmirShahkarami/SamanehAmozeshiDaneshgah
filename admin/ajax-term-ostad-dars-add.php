<?php
session_start();

if (!(isset($_SESSION["user_logged"]))) {
    header("location:../login.html");
}

$user = $_SESSION["user_logged"];
if ($user["role"] != "admin") {
    ?>
    <div class="alert alert-danger" role="alert">
        شما مجوز ورود به این صفحه را ندارید .
        <a href="../login.html" class="alert-link">صفحه ی ورود</a>
    </div>
    <?php
} else {
$term_code = $_POST['term_code'];
$ostad_code = $_POST['ostad_code'];
$dars_code = $_POST['dars_code'];

    include("../db.php");
    $conn = (new my_database())->connection_database;

    $sql_select = "SELECT `id` FROM `ostad-dars` WHERE `ostad_code` = $ostad_code  AND `dars_code` = $dars_code";
    $result_select = $conn->query($sql_select);
    if($result_select-> num_rows == 1){
        $row = $result_select->fetch_assoc();
        $ostad_dars_code = $row["id"];
        $sql_insert = "INSERT INTO `term_ostad_dars`(`term_ostad_dars_id`, `term_code`, `ostad_dars_code`) 
                                VALUES ('null',                 $term_code,$ostad_dars_code)";

        $result_insrt = $conn->query($sql_insert);

        if($result_insrt == true){
            $sql_termostaddars = "select t3.`term_ostad_dars_id`,t3.`term_code`,t3.`ostad_code`,t3.`dars_code`,t3.`term_sal_tahsili` ,t3.term_shomareh,t3.ostad_name ,t3.ostad_family ,t6.dars_name 
                            from (select t3.`term_ostad_dars_id`,t3.`term_code`,t3.term_shomareh,t3.`ostad_code`,t3.`dars_code`,t3.`term_sal_tahsili` ,t4.ostad_name ,t4.ostad_family 
                                        from (select t1.`term_ostad_dars_id`,t1.`term_code`,t1.`ostad_code`,t1.`dars_code`,t2.`term_sal_tahsili`,t2.term_shomareh 
                                              from (SELECT `term_ostad_dars`.`term_ostad_dars_id`,`term_ostad_dars`.`term_code` , `ostad-dars`.`ostad_code` ,`ostad-dars`.`dars_code` 
                                                    FROM `term_ostad_dars` INNER JOIN `ostad-dars` on `term_ostad_dars`.`ostad_dars_code` = `ostad-dars`.`id`) 
                                                  AS t1 join `term` as t2 on t1.`term_code` = t2.`term_code`) as t3 join `ostad` as t4 on t3.`ostad_code` = t4.ostad_code) 
                                                    as t3 join `dars` as t6 on t3.`dars_code` = t6.dars_code;";

            $result_termostaddars = $conn->query($sql_termostaddars);
            $tr_table = "";
            if ($result_termostaddars->num_rows > 0) {
                // tod    term  ostad  dars
                while ($row_tod = $result_termostaddars->fetch_assoc()) {
                    $term_ostad_dars_id = $row_tod["term_ostad_dars_id"];
                    $term_shomareh = $row_tod["term_shomareh"];
                    $term_sal_tahsili = $row_tod["term_sal_tahsili"];
                    $ostad_name = $row_tod["ostad_name"];
                    $ostad_family = $row_tod["ostad_family"];
                    $dars_name = $row_tod["dars_name"];

                    $tr_table .= "
        <tr>
            <td>$term_sal_tahsili - $term_shomareh</td>
            <td>$ostad_name $ostad_family</td>
            <td>$dars_name</td>
            <td>...</td>
        </tr>
        ";
                } // while ($row_tod = $result_termostaddars->fetch_assoc())
            }  // if($result_termostaddars->num_rows > 0)
            echo $tr_table;
        }
    }
}








