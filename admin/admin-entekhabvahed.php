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
         while ($row_term = $result_term->fetch_assoc()){
             $term_code = $row_term["term_code"];
             $term_sal_tahsili = $row_term["term_sal_tahsili"];
             $term_shomareh = $row_term["term_shomareh"];
  echo "<option value='$term_code'>$term_sal_tahsili - $term_shomareh</option>";
         }
         echo "</select>
</td>
";
            }
              else {
                echo "ترمی ثبت نشده!";
            }


        if ($result_ostad->num_rows > 0) {

            //  (`ostad_code`, `ostad_name`, `ostad_family`, `ostad_madrak`, `ostad_reshtah`, `user_code`, `tozihat`)
            echo "

<td>
         <select class='form-select' aria-label='Default select example' name='ostad'  id='select_ostad'>
  <option selected>انتخاب استاد</option>
  ";
            while ($row_ostad = $result_ostad->fetch_assoc()){
                $ostad_code = $row_ostad["ostad_code"];
                $ostad_name = $row_ostad["ostad_name"];
                $ostad_family = $row_ostad["ostad_family"];

                echo "<option value='$ostad_code'>$ostad_name  $ostad_family</option>";
            }
            echo "</select>
</td>
";
        }
        else {
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
            <form id="form_term_ostad_dars_add" action="admin-term-ostad-dars-add.php" method="post">
                `term_ostad_dars_id`, `term_code`, `ostad_dars_code`

                <input type="hidden" name="term_code" id="term_code" value="">
                <input type="hidden" name="ostad_code" id="ostad_code" value="">
                <input type="hidden" name="dars_code" id="dars_code" value="">
                <input type="submit" value="ثبت">
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
        <tr>
            <th scope="col">ترم</th>
            <th scope="col">استاد</th>
            <th scope="col">درس</th>
            <th scope="col">عملیات</th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    <?php
    }
    ?>

</div>
<script>
    $(document).ready(function(){
        $("#select-term").on( "change", function() {
            $("#form_term_ostad_dars_add>#term_code").val(this.value)
        });

        $("#select_dros_ostad").on( "change", function() {
            $("#form_term_ostad_dars_add>#dars_code").val(this.value)
        });



        $("#select_ostad").on( "change", function() {
            //console.log("input#basic-default-name")
            var str =  $("#select_ostad").val()
            $("#form_term_ostad_dars_add>#ostad_code").val(str)
            console.log(str)
            $.ajax({
                type: "GET",
                url: "ajax-ostaddars.php",
                //data: "fname=" + fname + '&lname=' + lname,
                data:"data=" + str,
                success: function (result) {
                    //console.log(data2);
                    //$("#get_data_from_ajax").html(result)
                    $("#select_dros_ostad").html(result)
                }
            });
        });
    });
</script>
<script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

