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
    <title>داشبورد مدیریت سامانه</title>
    <link rel="stylesheet" href="../assets/bootstrap-5.3.3-dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/jquery/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <h1>مدیر سایت-مدیریت اساتید</h1>
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
            <a href="../logout.php"class="btn btn-danger">خروج</a>
        </div>

        <span style="display: none">
                (`ostad_code`, `ostad_name`, `ostad_family`, `ostad_madrak`, `ostad_reshtah`, `user_code`, `tozihat`
                `user_code`, `username`, `password`, `role`
        </span>

        <table class="table table-striped">
            <thead>
            <tr>

                <th scope="col">کد استاد</th>
                <th scope="col">نام</th>
                <th scope="col">فامیلی</th>
                <th scope="col">مدرک</th>
                <th scope="col">رشته</th>
                <th scope="col">توضیحات</th>
                <th scope="col">کد کاربری</th>
                <th scope="col">نام کاربری</th>
                <th scope="col">گذرواژه</th>
                <th scope="col">عملیات</th>
            </tr>
            </thead>
            <tr>

                <?php

                include("../db.php");
                $conn = (new my_database())->connection_database;

                $sql_user_ostad = "SELECT * FROM `ostad` as o INNER JOIN user as u on o.user_code = u.user_code;";
                //$sql_dars = "SELECT * FROM `dars`";

                $result = $conn->query($sql_user_ostad);

                if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                //`ostad_code`, `ostad_name`, `ostad_family`, `ostad_madrak`, `ostad_reshtah`, `user_code`, `tozihat`
                //user_code`, `username `, `password`, `role
                $ostad_code = $row["ostad_code"];
                $ostad_name = $row["ostad_name"];
                $ostad_family = $row["ostad_family"];
                $ostad_madrak = $row["ostad_madrak"];
                $ostad_reshtah = $row["ostad_reshtah"];
                $tozihat = $row["tozihat"];
                $user_code = $row["user_code"];
                $username = $row["username"];
                $password = $row["password"];
                ?>

            <tr>
                <td>
                    <?php echo $ostad_code ?>
                </td>
                <td>
                    <?php echo $ostad_name ?>
                </td>

                <td>
                    <?php echo $ostad_family ?>
                </td>
                <td>
                    <?php echo $ostad_madrak ?>
                </td>
                <td>
                    <?php echo $ostad_reshtah ?>
                </td>
                <td>
                    <?php echo $tozihat ?>
                </td>
                <td>
                    <?php echo $user_code ?>
                </td>
                <td>
                    <?php echo $username ?>
                </td>
                <td>
                    <?php echo $password ?>
                </td>
                <td>
                    <a href="admin-manege-teacher-useraccount.php?user_code=<?php echo $user_code; ?>">
                        مدیریت حساب کاربری
                    </a>
                    <br>
                    <a href="">
                        مدیریت مشخصات استاد
                    </a>
                </td>
            </tr>
            <?php
            }
            }
            else {
                echo "رکوردی ثت نشده است!.";
            }
            ?>
            </tbody>
        </table>
        <?php
    }
    ?>

    <script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

