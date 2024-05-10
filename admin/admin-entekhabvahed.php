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
    <title>داشبورد استاد</title>
    <link rel="stylesheet" href="../assets/bootstrap-5.3.3-dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/jquery/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <!-- Content here -->
    <?php

    $user = $_SESSION["user_logged"];
    if ($user["role"] != "admin") {
        ?>
        <div class="alert alert-danger" role="alert">
            شما مجوز ورود به این صفحه را ندارید .
            <a href="../login.html" class="alert-link">صفحه ی ورود</a>
        </div>
        <?php
    } else {

        ?>
        <div class="mb-3 mt-3">
            <a href="../logout.php" class="btn btn-primary">خروج</a>
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">ترم</th>
                <th scope="col">استاد</th>
                <th scope="col">درس</th>
                <th scope="col">عملیات</th>
            </tr>
            </thead>
            <tr>

                <?php

                include("../db.php");
                $conn = (new my_database())->connection_database;

                $sql_term = "SELECT * FROM `term`";
                $sql_ostad = "SELECT * FROM `ostad`";
                //$sql_dars = "SELECT * FROM `dars`";

                $result_term = $conn->query($sql_term);
                $result_ostad = $conn->query($sql_ostad);
                //$result_dars = $conn->query($sql_dars);

                if ($result_term->num_rows > 0) {

                    // `term_code`, `term_sal_tahsili`, `term_shomareh`, `tozihat`
                    echo "
<tr>
<td>
         <select class='form-select' aria-label='Default select example' name='term' id='select-term'>
  <option selected>انتخاب ترم</option>
  ";
                    while ($row_term = $result_term->fetch_assoc()) {
                        $term_code = $row_term["term_code"];
                        $term_sal_tahsili = $row_term["term_sal_tahsili"];
                        $term_shomareh = $row_term["term_shomareh"];
                        echo "<option value='$term_code'>$term_sal_tahsili - $term_shomareh</option>";
                    }
                    echo "</select>
</td>
";
                } else {
                    echo "ترمی ثبت نشده!";
                }


                if ($result_ostad->num_rows > 0) {

                    //  (`ostad_code`, `ostad_name`, `ostad_family`, `ostad_madrak`, `ostad_reshtah`, `user_code`, `tozihat`)
                    echo "

<td>
         <select class='form-select' aria-label='Default select example' name='ostad'  id='select_ostad'>
  <option selected>انتخاب استاد</option>
  ";
                    while ($row_ostad = $result_ostad->fetch_assoc()) {
                        $ostad_code = $row_ostad["ostad_code"];
                        $ostad_name = $row_ostad["ostad_name"];
                        $ostad_family = $row_ostad["ostad_family"];

                        echo "<option value='$ostad_code'>$ostad_name  $ostad_family</option>";
                    }
                    echo "</select>
</td>
";
                } else {
                    echo "استادی ثبت نشده!";
                }


                //  (`dars_code`, `dars_name`, `dars_vahed`, `dars_zarfeiat`, `tozihat`)
                echo "

<td>
         <select class='form-select' aria-label='Default select example' name='dars' id='select_dros_ostad'>  
  ";

                echo "</select>
</td>

";

                ?>
                <td>
                    <form id="form_term_ostad_dars_add" action="ajax-term-ostad-dars-add.php" method="post">
                        <input type="hidden" name="term_code" id="term_code" value="">
                        <input type="hidden" name="ostad_code" id="ostad_code" value="">
                        <input type="hidden" name="dars_code" id="dars_code" value="">
                        <input type="button" value="ثبت" onclick="load_all_records_termostaddars()">
                    </form>
                </td>
            </tr>
            </tbody>
        </table>

        <div id="get_data_from_ajax"></div>

        <table class="table table-striped" id="table_termostaddars_rows">
            <thead>
            <tr>
                <th scope="col">ترم</th>
                <th scope="col">استاد</th>
                <th scope="col">درس</th>
                <th scope="col">عملیات</th>
            </tr>
            </thead>
            <tbody id="tr_table_termostaddars">
            <?php

            $sql_termostaddars = "select t3.`term_ostad_dars_id`,t3.`term_code`,t3.`ostad_code`,t3.`dars_code`,t3.`term_sal_tahsili` ,t3.term_shomareh,t3.ostad_name ,t3.ostad_family ,t6.dars_name 
                            from (select t3.`term_ostad_dars_id`,t3.`term_code`,t3.term_shomareh,t3.`ostad_code`,t3.`dars_code`,t3.`term_sal_tahsili` ,t4.ostad_name ,t4.ostad_family 
                                        from (select t1.`term_ostad_dars_id`,t1.`term_code`,t1.`ostad_code`,t1.`dars_code`,t2.`term_sal_tahsili`,t2.term_shomareh 
                                              from (SELECT `term_ostad_dars`.`term_ostad_dars_id`,`term_ostad_dars`.`term_code` , `ostad-dars`.`ostad_code` ,`ostad-dars`.`dars_code` 
                                                    FROM `term_ostad_dars` INNER JOIN `ostad-dars` on `term_ostad_dars`.`ostad_dars_code` = `ostad-dars`.`id`) 
                                                  AS t1 join `term` as t2 on t1.`term_code` = t2.`term_code`) as t3 join `ostad` as t4 on t3.`ostad_code` = t4.ostad_code) 
                                                    as t3 join `dars` as t6 on t3.`dars_code` = t6.dars_code;";

            $result_termostaddars = $conn->query($sql_termostaddars);
            if ($result_termostaddars->num_rows > 0) {
                // tod    term  ostad  dars
                while ($row_tod = $result_termostaddars->fetch_assoc()) {
                    $term_ostad_dars_id = $row_tod["term_ostad_dars_id"];
                    $term_shomareh = $row_tod["term_shomareh"];
                    $term_sal_tahsili = $row_tod["term_sal_tahsili"];
                    $ostad_name = $row_tod["ostad_name"];
                    $ostad_family = $row_tod["ostad_family"];
                    $dars_name = $row_tod["dars_name"];

                    echo "
        <tr>
            <td>$term_sal_tahsili - $term_shomareh</td>
            <td>$ostad_name $ostad_family</td>
            <td>$dars_name</td>
            <td>...</td>
        </tr>
        ";
                } // while ($row_tod = $result_termostaddars->fetch_assoc())
            }  // if($result_termostaddars->num_rows > 0)
            ?>
            </tbody>
        </table>
        <?php
    }
    ?>

</div>
<script>
    let term_code, dars_code, ostad_code;
    $(document).ready(function () {
        $("#select-term").on("change", function () {
            $("#form_term_ostad_dars_add>#term_code").val(this.value)
            term_code = this.value;
        });

        $("#select_dros_ostad").on("change", function () {
            $("#form_term_ostad_dars_add>#dars_code").val(this.value)
            dars_code = this.value;
        });


        $("#select_ostad").on("change", function () {
            //console.log("input#basic-default-name")
            var str = $("#select_ostad").val()
            $("#form_term_ostad_dars_add>#ostad_code").val(str)
            ostad_code = this.value;
            console.log("select_ostad    ostad_code="+str)
            $.ajax({
                type: "GET",
                url: "ajax-ostaddars.php",
                //data: "fname=" + fname + '&lname=' + lname,
                data: "data=" + str,
                success: function (result) {
                    //console.log(data2);
                    //$("#get_data_from_ajax").html(result)
                    $("#select_dros_ostad").html(result)
                }
            });
        });
    });


    function load_all_records_termostaddars() {
        alert("in load_all_records_termostaddars .")
        console.log("term_code=" + term_code)
        console.log("dars_code=" + dars_code)
        console.log("ostad_code=" + ostad_code)
        $(document).ready(function () {
            $.ajax({
                type: "POST",
                url: "ajax-term-ostad-dars-add.php",
                //data: "fname=" + fname + '&lname=' + lname,
                data: {term_code: term_code, dars_code: dars_code,ostad_code:ostad_code},
                success: function (result) {
                    //console.log(data2);
                    //$("#get_data_from_ajax").html(result)
                    $("#tr_table_termostaddars").html(result)
                }
            });
        });
    }
</script>
<script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

