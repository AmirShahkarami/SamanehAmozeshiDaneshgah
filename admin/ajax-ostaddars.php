<?php
if (isset($_GET["data"])) {
    $code_ostad = $_GET["data"];

    include("../db.php");
    $conn = (new my_database())->connection_database;

    $sql_dros_ostad = "SELECT * FROM `dars` WHERE dars_code in (SELECT dars_code FROM `ostad_dars` WHERE `ostad_code` = $code_ostad)";
    $result_dars = $conn->query($sql_dros_ostad);

    if ($result_dars->num_rows > 0) {
        echo "
        <option selected>انتخاب درس</option>";
        while ($row_dars = $result_dars->fetch_assoc()) {
            $dars_code = $row_dars["dars_code"];
            $dars_name = $row_dars["dars_name"];
            echo "<option value='$dars_code'>$dars_name</option>";
        }
    }
}

