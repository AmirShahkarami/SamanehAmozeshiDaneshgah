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
</head>
<body>

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

<div class="container">
    <div class="mb-3 mt-3">
        <a href="../logout.php"class="btn btn-danger">خروج</a>
    </div>
    <h1>داشبورد مدیریت سامانه</h1>
    <h2>
        <a href="user-list.php">لیست کاربران</a>
    </h2>
    <h2>
        <a href="admin-entekhabvahed.php">مدیریت انتخاب واحد</a>
    </h2>
    <hr>
    <h2>
        <a href="admin-manege-teachers.php">مدیریت اساتید</a>
    </h2>

</div>

<?php
}
?>
<script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
