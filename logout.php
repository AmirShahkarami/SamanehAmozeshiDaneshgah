<?php
session_start();

unset($_SESSION["user_logged"]);
//var_dump($_SESSION["user_logged"]);
header("location:login.html");
?>


