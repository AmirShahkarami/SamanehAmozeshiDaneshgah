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
            $sql_dars = "SELECT * FROM `dars`";

            $result_term = $conn->query($sql_term);
            $result_ostad = $conn->query($sql_ostad);
            $result_dars = $conn->query($sql_dars);

            if ($result_term->num_rows > 0) {

                // `term_code`, `term_sal_tahsili`, `term_shomareh`, `tozihat`
         echo "
<tr>
<td>
         <select class='form-select' aria-label='Default select example' name='term'>
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
         <select class='form-select' aria-label='Default select example' name='ostad'>
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


        if ($result_dars->num_rows > 0) {

            //  (`dars_code`, `dars_name`, `dars_vahed`, `dars_zarfeiat`, `tozihat`)
            echo "

<td>
         <select class='form-select' aria-label='Default select example' name='dars'>
  <option selected>انتخاب درس</option>
  ";
            while ($row_dars = $result_dars->fetch_assoc()){
                $dars_code = $row_dars["dars_code"];
                $dars_name = $row_dars["dars_name"];
                echo "<option value='$dars_code'>$dars_name</option>";
            }
            echo "</select>
</td>
";
        }
        else {
            echo "درسی ثبت نشده!";
        }

            ?>
        </tr>
        </tbody>
    </table>

    <form action="" method="get">
        <div class="mb-3 mt-3">
            <label for="username" class="form-label">نام کاربری</label>
            <input type="search" class="form-control" id="username" placeholder="جستجوی نام کاربری" name="username"
                   value="">
        </div>
    </form>
    <?php
    }
    ?>

</div>

<script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

