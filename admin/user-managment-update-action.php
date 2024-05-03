<?php
$user_code = $_POST["user_code"];
$username = $_POST["username"];
$password = $_POST["password"];
$role = $_POST["role"];

include ("../db.php");
$conn = (new my_database())->connection_database;

$sql = "UPDATE `user` SET `username` = '$username', `password` = '$password', `role` = '$role' WHERE `user`.`user_code` = $user_code";



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>بروزرسانی</title>
    <link rel="stylesheet" href="../assets/bootstrap-5.3.3-dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<?php
$alert = "<div class=\"container mt-3\">
  <h2>نتیجه</h2>";
if ($conn->query($sql) === TRUE) {
    $alert .= "<div class=\"alert alert-success\">
    <strong>موفقیت آمیز!</strong> 
    کاربر مورد نظر
    <span class='text-success'>
     بروزرسانی   
</span>
     شد.
  </div>";
} else {
    $alert .= "
    <div class=\"alert alert-danger\">
    <strong>خطا!</strong> $conn->error
  </div>
    ";
}

$alert .= "
<div class=\"mb-3 mt-3\">
    <a href=\"user-list.php\" class=\"btn btn-primary\">لیست کاربران</a>
</div>
</div>
";

echo $alert;
$conn->close();


?>

</body>
</html>

