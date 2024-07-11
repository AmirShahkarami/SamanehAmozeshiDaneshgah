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
        var_dump($result_insrt);
    }
}








