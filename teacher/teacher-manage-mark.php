<?php
session_start();

if (!(isset($_SESSION["user_logged"]))) {
    header("location:../login.html");
}
else{

$user = $_SESSION["user_logged"];

if ($user["role"] == "student") {
    ?>
    <div class="alert alert-danger" role="alert">
        شما مجوز ورود به این صفحه را ندارید .
        <a href="../login.html" class="alert-link">صفحه ی ورود</a>
    </div>
    <?php
}
else {
include("../db.php");
$conn = (new my_database())->connection_database;

$user_code = $user["user_code"];
$sql_teacher = "SELECT * FROM `ostad` WHERE `user_code` = $user_code";
$result_teacher = $conn->query($sql_teacher);

$ostad_code = -1;
if ($result_teacher->num_rows == 1) {
    $teacher = $result_teacher->fetch_assoc();
    //`ostad_name`,`ostad_family`
    $teacher_Fullname = "استاد:" . $teacher["ostad_name"] . ' ' . $teacher["ostad_family"];
    $ostad_code = $teacher["ostad_code"];
} else {
    echo "اطلاعات نامعتبر";
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

    <div class="mb-3 mt-3">
        <a href="../logout.php" class="btn btn-danger">خروج</a>
        <a href="teacher-dashboard.php" class="btn btn-primary">داشبورد استاد</a>
    </div>

    <h2>
        <?php echo $teacher_Fullname; ?>
    </h2>

    <h2>لیست دروس ارائه شده</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">درس</th>
        </tr>
        </thead>
        <tbody>

        <?php


        if ($ostad_code != -1){

        $sql = "SELECT tod.term_ostad_dars_id , o.ostad_code, o.ostad_name,o.ostad_family, 
                    CONCAT( o.ostad_code , o.ostad_name , o.ostad_family) as ostad_full,
                    d.dars_name , d.dars_code, CONCAT(d.dars_name , d.dars_code) as dars_full,
                    t.term_sal_tahsili,t.term_shomareh, CONCAT(t.term_sal_tahsili , t.term_shomareh) as term_full 
                    FROM `term_ostad_dars` as tod 
                        INNER JOIN ostad_dars as od on tod.ostad_dars_code = od.id 
                        INNER JOIN ostad as o on od.ostad_code = o.ostad_code 
                        INNER JOIN dars as d on od.dars_code = d.dars_code 
                        INNER JOIN term as t on tod.term_code = t.term_code 
                    WHERE o.ostad_code =   $ostad_code                    
                    ORDER BY `term_full` DESC;";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $tod = [];
            while ($row = $result->fetch_assoc()) {
                $tod[] = $row;
            }

            /*
            var_dump($tod);
            exit("<hr>"."86");
            */

            ?>

            <?php
            foreach ($tod as $item_tod) {
                ?>
                <tr>
                    <td>
                        <a href="teacher-manage-mark-dars.php?term_ostad_dars_id=<?php echo $item_tod["term_ostad_dars_id"]."&dars_name=".$item_tod["dars_name"]."\"" ?>"
                           class="btn btn-primary">
                            <?php
                            echo $item_tod["dars_name"];
                            ?>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>


            <?php
        }
        ?>

        </tbody>
    </table>

    <?php
    }
    }
    }
    ?>

</div>

<script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
